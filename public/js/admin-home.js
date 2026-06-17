let cart = [];

// 1. ميزة البحث: تبحث في المنتجات المعروضة في الصفحة
document.getElementById('search-input')?.addEventListener('input', (e) => {
    const term = e.target.value.toLowerCase().trim();
    document.querySelectorAll('.product-col').forEach(col => {
        const name = col.querySelector('.product-name').innerText.toLowerCase();
        col.style.display = name.includes(term) ? '' : 'none';
    });
});

// 2. إضافة المنتج للسلة: يتم استدعاؤها من الـ HTML مباشرة
window.addToCart = function(product) {
    console.log("Adding product:", product); // للتأكد من أن الكود يعمل
    
    const existingItem = cart.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    updateCartUI();
};

// 3. تحديث واجهة السلة (الجدول)
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

// 4. تغيير الكمية
window.changeQty = function(id, delta) {
    const item = cart.find(i => i.id === id);
    if (item) {
        item.quantity += delta;
        if (item.quantity <= 0) removeFromCart(id);
        else updateCartUI();
    }
};

// 5. حذف منتج من السلة
window.removeFromCart = function(id) {
    cart = cart.filter(i => i.id !== id);
    updateCartUI();
};

// 6. التعامل مع زر التأكيد
document.getElementById("confirmBtn")?.addEventListener("click", function() {
    const userSelect = document.getElementById("user-select");
    const roomSelect = document.getElementById("room-select");
    const cartWarning = document.getElementById("cart-warning");

    let hasError = false;

    if (cart.length === 0) {
        cartWarning.classList.remove("d-none");
        hasError = true;
    } else {
        cartWarning.classList.add("d-none");
    }

    // تأكدي من اختيار مستخدم وغرفة
    if (!userSelect.value || !roomSelect.value) {
        alert("Please select User and Room!");
        hasError = true;
    }

    if (!hasError) {
        console.log("Order Confirmed!", { cart, user: userSelect.value, room: roomSelect.value });
        alert("Order placed successfully!");
        // هنا يمكنك إضافة كود الإرسال للسيرفر لاحقاً
    }
});