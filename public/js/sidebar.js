
// ---------- SIDEBAR ----------
const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
const mainSidebar      = document.getElementById('mainSidebar');
const sidebarOverlay   = document.getElementById('sidebarOverlay');
const sidebarCloseBtn  = document.getElementById('sidebarCloseBtn');

function openSidebar() {
  mainSidebar.classList.add('open');
  sidebarOverlay.classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeSidebar() {
  mainSidebar.classList.remove('open');
  sidebarOverlay.classList.remove('show');
  document.body.style.overflow = '';
}

sidebarToggleBtn.addEventListener('click', openSidebar);
sidebarCloseBtn.addEventListener('click', closeSidebar);
sidebarOverlay.addEventListener('click', closeSidebar);

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeSidebar();
});

// ---------- LATEST ORDER ----------
const productsContainer = document.getElementById('products-container');
const latestContainer   = document.getElementById('latest-order-container');

function addToLatest(imgSrc, name) {
  const emptyMsg = latestContainer.querySelector('.latest-empty');
  if (emptyMsg) emptyMsg.remove();

  const exists = [...latestContainer.querySelectorAll('img')].some(img => img.alt === name);
  if (exists) return;

  const item = document.createElement('div');
  item.className = 'latest-order-item';
  item.title = name;
  item.innerHTML = `<img src="${imgSrc}" alt="${name}">`;
  latestContainer.appendChild(item);
}

const observer = new MutationObserver(() => {
  productsContainer.querySelectorAll('.product-card:not([data-listener])').forEach(card => {
    card.setAttribute('data-listener', 'true');
    card.addEventListener('click', () => {
      const img  = card.querySelector('img');
      const name = card.querySelector('.product-name');
      if (img && name) {
        addToLatest(img.src, name.textContent.trim());
      }
    });
  });
});

observer.observe(productsContainer, { childList: true, subtree: true });