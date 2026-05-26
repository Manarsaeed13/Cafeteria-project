let cart = [];
let allProducts = []; 

document.addEventListener("DOMContentLoaded", () => {
  
  fetch('partions/admin-navbar.html')
    .then(response => {
      if (!response.ok) throw new Error('Navbar file not found');
      return response.text();
    })
    .then(data => {
      const nvPlaceholder = document.getElementById('navbar-placeholder');
      if (nvPlaceholder) nvPlaceholder.innerHTML = data;
    })
    .catch(err => console.error(err));

  fetch('partions/footer.html')
    .then(response => {
      if (!response.ok) throw new Error('Footer file not found');
      return response.text();
    })
    .then(data => {
      const ftPlaceholder = document.getElementById('footer-placeholder');
      if (ftPlaceholder) ftPlaceholder.innerHTML = data;
    })
    .catch(err => console.error(err));

  fetch('products.json')
    .then(response => {
      if (!response.ok) throw new Error('Products JSON file not found');
      return response.json();
    })
    .then(products => {
      allProducts = products;
      displayProducts(allProducts);
      setupSearch();
    })
    .catch(error => console.error(error));
});

function setupSearch() {
  const searchInput = document.getElementById('search-input');
  if (!searchInput) return;

  searchInput.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase().trim();
    
    const filteredProducts = allProducts.filter(product => 
      product.name.toLowerCase().includes(searchTerm)
    );
    
    displayProducts(filteredProducts);
  });
}

// دالة عرض المنتجات ومسح التكرار وحل مشكلة الرعشة
function displayProducts(products) {
  const container = document.getElementById('products-container');
  if (!container) return;
  container.innerHTML = ''; 

  if (products.length === 0) {
    container.innerHTML = `<div class="col-12 text-center text-muted py-4 fw-bold">No products found!</div>`;
    return;
  }

  products.forEach(product => {
    const productHtml = `
      <div class="col">
        <div class="product-item text-center p-3 position-relative border rounded-3 bg-white shadow-sm" style="cursor: pointer;" onclick="addToCart('${product.name}', ${product.price})">
          
          <div class="img-wrapper d-flex align-items-center justify-content-center mx-auto mb-3 rounded-circle bg-light border" style="width: 80px; height: 80px; overflow: hidden;">
            <img src="${product.image}" alt="${product.name}" class="img-fluid w-100 h-100 object-fit-cover" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/51c/51c554.png';">
          </div>
          
          <span class="badge bg-success position-absolute top-0 end-0 m-2 px-2 py-1 fs-7 rounded-pill">${product.price} LE</span>
          
          <p class="product-name fw-bold text-dark mb-0 mt-2">${product.name}</p>
          
        </div>
      </div>
    `;
    container.innerHTML += productHtml;
  });
}

function addToCart(name, price) {
  const existingItem = cart.find(item => item.name === name);
  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.push({ name: name, price: price, quantity: 1 });
  }
  updateCartUI();
}

function changeQuantity(name, amount) {
  const item = cart.find(item => item.name === name);
  if (item) {
    item.quantity += amount;
    if (item.quantity <= 0) {
      removeFromCart(name);
      return;
    }
  }
  updateCartUI();
}

function removeFromCart(name) {
  cart = cart.filter(item => item.name !== name);
  updateCartUI();
}

function updateCartUI() {
  const cartContainer = document.getElementById("cart-items");
  const totalPriceElement = document.getElementById("total-price");
  if (!cartContainer || !totalPriceElement) return;

  if (cart.length === 0) {
    cartContainer.innerHTML = `<p class="text-muted text-center py-4">No items added yet.</p>`;
    totalPriceElement.innerText = "0";
    return;
  }
  
  let html = "";
  let total = 0;
  
  cart.forEach(item => {
    let itemTotal = item.quantity * item.price;
    total += itemTotal;
    
    html += `
      <div class="cart-item d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
        <span class="item-name fw-bold" style="min-width: 70px;">${item.name}</span>
        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-sm bg-danger text-white fw-bold" style="width:28px; height:28px; padding:0; border-radius:6px;" onclick="changeQuantity('${item.name}', -1)">-</button>
          <span class="fw-bold fs-5 px-1">${item.quantity}</span>
          <button class="btn btn-sm bg-success text-white fw-bold" style="width:28px; height:28px; padding:0; border-radius:6px;" onclick="changeQuantity('${item.name}', 1)">+</button>
        </div>
        <span class="fw-bold text-success">${itemTotal} EGP</span>
        <button class="btn text-danger fw-bold bg-transparent border-0" onclick="removeFromCart('${item.name}')">X</button>
      </div>
    `;
  });
  
  cartContainer.innerHTML = html;
  totalPriceElement.innerText = total;
}

document.getElementById("confirmBtn")?.addEventListener("click", function() {
  const userSelect = document.getElementById("user-select");
  const roomSelect = document.getElementById("room-select");
  
  const cartWarning = document.getElementById("cart-warning");
  const userWarning = document.getElementById("user-warning");
  const roomWarning = document.getElementById("room-warning");
  
  let hasError = false;

  if (cart.length === 0) {
    cartWarning.classList.remove("d-none");
    hasError = true;
  } else {
    cartWarning.classList.add("d-none");
  }

  if (userSelect.value === "") {
    userWarning.classList.remove("d-none");
    userSelect.classList.add("border-danger");
    hasError = true;
  } else {
    userWarning.classList.add("d-none");
    userSelect.classList.remove("border-danger");
  }

  if (roomSelect.value === "") {
    roomWarning.classList.remove("d-none");
    roomSelect.classList.add("border-danger");
    hasError = true;
  } else {
    roomWarning.classList.add("d-none");
    roomSelect.classList.remove("border-danger");
  }

  if (hasError) return;

  window.location.href = "success.html";
});