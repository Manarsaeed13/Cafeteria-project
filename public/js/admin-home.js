let cart = [];

document.getElementById('search-input')?.addEventListener('input', (e) => {
    const term = e.target.value.toLowerCase().trim();
    document.querySelectorAll('.product-col').forEach(col => {
        const name = col.querySelector('.product-name').innerText.toLowerCase();
        col.style.display = name.includes(term) ? '' : 'none';
    });
});

document.getElementById('user-select').addEventListener('change', function() {
    if(this.value) document.getElementById('user-warning').classList.add('d-none');
});
document.getElementById('room-select').addEventListener('change', function() {
    if(this.value) document.getElementById('room-warning').classList.add('d-none');
});

window.addToCart = function(product) {
    document.getElementById('cart-warning').classList.add('d-none');
    const existingItem = cart.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    updateCartUI();
};

window.updateCartUI = function() {
    const cartContainer = document.getElementById("cart-items");
    const totalPriceElement = document.getElementById("total-price");
    if (!cartContainer) return;

    if (cart.length === 0) {
        cartContainer.innerHTML = `<tr><td colspan="4" class="text-muted text-center py-4">No items added yet.</td></tr>`;
        totalPriceElement.innerText = "0";
        return;
    }

    let html = "";
    let total = 0;
    cart.forEach(item => {
        total += item.quantity * item.price;
        html += `
            <tr class="border-bottom align-middle">
                <td class="fw-bold">${item.name}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-secondary" onclick="changeQty(${item.id}, -1)">-</button>
                    <span class="px-2">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary" onclick="changeQty(${item.id}, 1)">+</button>
                </td>
                <td class="fw-bold">${item.quantity * item.price} EGP</td>
                <td><button class="btn btn-sm text-danger" onclick="removeFromCart(${item.id})">×</button></td>
            </tr>`;
    });
    cartContainer.innerHTML = html;
    totalPriceElement.innerText = total;
};

window.changeQty = function(id, delta) {
    const item = cart.find(i => i.id === id);
    if (item) {
        item.quantity += delta;
        if (item.quantity <= 0) removeFromCart(id);
        else updateCartUI();
    }
};

window.removeFromCart = function(id) {
    cart = cart.filter(i => i.id !== id);
    updateCartUI();
};

// 5. زر التأكيد
document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.getElementById("confirmBtn");

    if (confirmBtn) {
        confirmBtn.addEventListener("click", function() {
            const userSelect = document.getElementById("user-select");
            const roomSelect = document.getElementById("room-select");
            const notes = document.getElementById("order-notes").value;

            const cartWarning = document.getElementById("cart-warning");
            const userWarning = document.getElementById("user-warning");
            const roomWarning = document.getElementById("room-warning");

         
            cartWarning.classList.add("d-none");
            userWarning.classList.add("d-none");
            roomWarning.classList.add("d-none");

            let hasError = false;

            if (cart.length === 0) { cartWarning.classList.remove("d-none"); hasError = true; }
            if (!userSelect.value) { userWarning.classList.remove("d-none"); hasError = true; }
            if (!roomSelect.value) { roomWarning.classList.remove("d-none"); hasError = true; }

            if (!hasError) {
                fetch('/save-order', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ cart, user: userSelect.value, room: roomSelect.value, notes })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cart = [];
                        updateCartUI();
                        userSelect.value = "";
                        roomSelect.value = "";
                        document.getElementById("order-notes").value = "";
                        window.location.href = '/admin-checks';
                    } else {
                        console.error("Server error:", data.message);
                    }
                })
                .catch(err => console.error("Error:", err));
            }
        });
    } else {
        console.error("Confirm button not found!");
    }
});