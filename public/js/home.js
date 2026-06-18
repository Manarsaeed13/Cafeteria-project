let cart = [];
let allProducts = [];

const BASE = '';

document.addEventListener("DOMContentLoaded", () => {

  // 1. جلب الـ Footer
  fetch(`${BASE}/partions/footer.php`)
    .then(r => r.text())
    .then(data => {
      const ft = document.getElementById('footer-placeholder');
      if (ft) ft.innerHTML = data;
    })
    .catch(err => console.error('Footer error:', err));

  // 2. جلب المنتجات وعرضها
fetch('controller/get_products.php')
    .then(r => r.json())
    .then(products => {
      allProducts = products;
      displayProducts(allProducts);
      setupSearch();
    })
    .catch(err => console.error('Products error:', err));

  // 3. جلب الغرف
fetch('controller/get_rooms.php')
    .then(r => r.json())
    .then(rooms => {
      const select = document.getElementById('room-select');
      if (select) {
        select.innerHTML = '<option selected disabled value="">Choose Room...</option>';
        rooms.forEach(room => {
          const opt = document.createElement('option');
          opt.value = room.ID;
          opt.textContent = 'Room ' + room.Room_number;
          select.appendChild(opt);
        });
      }
    })
    .catch(err => console.error('Rooms error:', err));

  // 4. تأكيد الأوردر (Confirm Order)
  document.getElementById('confirmBtn').addEventListener('click', () => {
    const room = document.getElementById('room-select').value;
    const notes = document.getElementById('order-notes').value;
    const cartWarning = document.getElementById('cart-warning');
    const roomWarning = document.getElementById('room-warning');

    if(cartWarning) cartWarning.classList.add('d-none');
    if(roomWarning) roomWarning.classList.add('d-none');

    if (cart.length === 0) { if(cartWarning) cartWarning.classList.remove('d-none'); return; }
    if (!room)              { if(roomWarning) roomWarning.classList.remove('d-none'); return; }

  fetch('controller/confirm_order.php', {      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ cart, room, notes })
    })
      .then(r => r.json())
      .then(res => {
        if (res.success) {
          cart = [];
          updateTotal();
          alert('Order confirmed!');
          
          // عند نجاح الأوردر نقوم بتفريغ قسم الـ Latest Order أيضاً كبداية جديدة
          const container = document.getElementById('latest-order-container');
          if (container) {
            container.innerHTML = '<span class="latest-empty">No items yet — tap a product to add!</span>';
          }
        } else {
          alert(res.message || 'Error confirming order');
        }
      })
      .catch(err => console.error('Order error:', err));
  });

  // استدعاء أولي لتهيئة الجدول
  updateTotal();
});

// ── عرض المنتجات ──────────────────────────────────────────────────────────
function displayProducts(products) {
  const container = document.getElementById('products-container');
  if (!container) return;
  container.innerHTML = '';

  if (products.length === 0) {
    container.innerHTML = '<p class="text-muted">No products found.</p>';
    return;
  }

  products.forEach(product => {
    const col = document.createElement('div');
    col.className = 'col';
    col.innerHTML = `
      <div class="card product-card h-100 border-0 shadow-sm text-center p-3"
           style="border-radius:16px; cursor:pointer;"
           onclick="addToCart(${product.ID}, '${escapeJs(product.Name)}', ${product.Price}, '${escapeJs(product.Image)}')">
        <img src="${product.Image}"
             class="mx-auto mb-2"
             alt="${escapeJs(product.Name)}"
             style="width:90px;height:90px;object-fit:cover;border-radius:50%;">
        <h6 class="fw-bold mb-1" style="font-size:14px;">${escapeJs(product.Name)}</h6>
        <span class="badge" style="background:#0D530E;font-size:13px;">${product.Price} EGP</span>
      </div>`;
    container.appendChild(col);
  });
}

// ── search ─────────────────────────────────────────────────────────────────
function setupSearch() {
  const input = document.getElementById('search-input');
  if (!input) return;
  input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();
    const filtered = allProducts.filter(p => p.Name.toLowerCase().includes(q));
    displayProducts(filtered);
  });
}

// ── update─────────────────────────────────
function addToCart(id, name, price, image) {
  const existing = cart.find(i => i.id === id);
  if (existing) {
    existing.qty++;
  } else {
    cart.push({ id, name, price: parseFloat(price), image, qty: 1 });
  }
  updateTotal();
  showToast(name);

  //  التعديل السحري هنا: إضافة المنتج المفتوح لقسم الـ Latest Order فوراً عند الضغط عليه
  updateLatestOrderUI(id, name, price, image);
}

// دالة مخصصة لإضافة الأيقونة فوراً في قسم الـ Latest Order عند الضغط
function updateLatestOrderUI(id, name, price, image) {
  const container = document.getElementById('latest-order-container');
  if (!container) return;

  // إزالة رسالة "No items yet" إذا كانت موجودة
  const emptyMessage = container.querySelector('.latest-empty');
  if (emptyMessage) {
    container.innerHTML = '';
  }

// latest 
 const alreadyExists = container.querySelector(`[data-latest-id="${id}"]`);
  if (!alreadyExists) {
    const div = document.createElement('div');
    div.className = 'latest-order-item';
    div.setAttribute('data-latest-id', id);
    div.style.cursor = 'pointer';
    div.innerHTML = `<img src="${image}" alt="${name}" title="${name}">`;

    // عند الضغط على الأيقونة من قسم الـ Latest Order يتم زيادته في الكارت مجدداً
    div.addEventListener('click', () => {
      addToCart(id, name, price, image);
    });

    // إضافة الأيقونة الجديدة في بداية القائمة (لتظهر كأحدث شيء تم الضغط عليه)
    container.insertBefore(div, container.firstChild);
  }
}

// جعل دالة addToCart متاحة للـ HTML
window.addToCart = addToCart;

// دالة تحديث السعر وعرض الجدول
function updateTotal() {
  const cartItemsContainer = document.getElementById('cart-items');
  if (!cartItemsContainer) return;

  const total = cart.reduce((sum, i) => sum + i.price * i.qty, 0);
  document.getElementById('total-price').textContent = total;

  if (cart.length === 0) {
    cartItemsContainer.innerHTML = `<tr><td class="text-center text-muted py-4">No items added yet.</td></tr>`;
    return;
  }

  cartItemsContainer.innerHTML = '';
  cart.forEach(item => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="cart-item-name">${item.name}</td>
      <td class="text-center">
        <button class="btn-minus" onclick="changeQty(${item.id}, -1)">-</button>
        <span class="cart-qty-val">${item.qty}</span>
        <button class="btn-plus" onclick="changeQty(${item.id}, 1)">+</button>
      </td>
      <td class="text-end cart-item-price">${item.price * item.qty} EGP</td>
      <td class="text-center"><span class="btn-delete" onclick="removeFromCart(${item.id})">X</span></td>
    `;
    cartItemsContainer.appendChild(tr);
  });
}

// د (+ و -)
window.changeQty = function(id, change) {
  const item = cart.find(i => i.id === id);
  if (item) {
    item.qty += change;
    if (item.qty <= 0) {
      removeFromCart(id);
    } else {
      updateTotal();
    }
  }
}

window.removeFromCart = function(id) {
  cart = cart.filter(item => item.id !== id);
  updateTotal();
}

function showToast(name) {
  let toast = document.getElementById('cart-toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'cart-toast';
    toast.style.cssText = 'position:fixed;bottom:30px;right:30px;background:#0D530E;color:#fff;padding:12px 20px;border-radius:12px;font-weight:600;z-index:9999;transition:opacity 0.4s;';
    document.body.appendChild(toast);
  }
  toast.textContent = `✓ ${name} added`;
  toast.style.opacity = '1';
  clearTimeout(toast._timer);
  toast._timer = setTimeout(() => { toast.style.opacity = '0'; }, 2000);
}


function escapeJs(str) {
  return String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '&quot;');
}