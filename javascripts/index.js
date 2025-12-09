// ===== Grab Elements =====
const loginModal = document.getElementById('loginModal');
const signupModal = document.getElementById('signupModal');
const storesModal = document.getElementById('storesModal');
const mapModal = document.getElementById('mapModal');

// Triggers
const loginTriggers = document.querySelectorAll('.login-trigger');
const signupTriggers = document.querySelectorAll('.signup-trigger');
const storesTrigger = document.querySelector('.stores-trigger');
const menuTrigger = document.querySelector('.menu-trigger'); // nav Menu link

// Forms
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');

// ===== Utility Functions =====
function openModalById(id) {
  const modal = document.getElementById(id);
  if (!modal) return;
  modal.style.display = 'flex';
  modal.setAttribute('aria-hidden', 'false');
}

function closeModalById(id) {
  const modal = document.getElementById(id);
  if (!modal) return;
  modal.style.display = 'none';
  modal.setAttribute('aria-hidden', 'true');
}

// Close buttons
document.querySelectorAll('.close, .close-signup, .close-btn').forEach(btn => {
  btn.addEventListener('click', e => {
    const modal = e.target.closest('.modal');
    if (modal) {
      modal.style.display = 'none';
      modal.setAttribute('aria-hidden', 'true');
    }
  });
});

// ===== Nav Trigger Events =====
loginTriggers.forEach(trigger => {
  trigger.addEventListener('click', e => {
    e.preventDefault();
    openLoginModal();
    closeModalById('signupModal');
    closeModalById('storesModal');
  });
});

signupTriggers.forEach(trigger => {
  trigger.addEventListener('click', e => {
    e.preventDefault();
    openSignupModal();
    closeModalById('loginModal');
    closeModalById('storesModal');
  });
});

if (storesTrigger) {
  storesTrigger.addEventListener('click', e => {
    e.preventDefault();
    openModalById('storesModal');
    closeModalById('loginModal');
    closeModalById('signupModal');
  });
}

// Menu trigger (currently disabled product modal logic)
// You can repurpose this to scroll to a section instead:
if (menuTrigger) {
  menuTrigger.addEventListener('click', e => {
    e.preventDefault();
    // Example: scroll to category section
    const section = document.getElementById('ube');
    if (section) {
      section.scrollIntoView({ behavior: 'smooth' });
    }
  });
}

// ===== Signup Form =====
signupForm && signupForm.addEventListener('submit', e => {
  e.preventDefault();
  const formData = new FormData(signupForm);

  fetch('php/signup-process.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(data => {
      if (data === 'success') {
        alert('Account created successfully!');
        signupForm.reset();
        closeModalById('signupModal');
        openLoginModal();

        // Auto-fill login email
        const loginEmail = document.getElementById('index-login-email');
        const signupEmail = document.getElementById('index-signup-email');
        if (loginEmail && signupEmail) {
          loginEmail.value = signupEmail.value;
        }
      } else if (data === 'exists') {
        alert('Email already registered.');
      } else {
        alert('Signup failed.');
      }
    });
});

// ===== Login Form =====
loginForm && loginForm.addEventListener('submit', e => {
  e.preventDefault();
  const formData = new FormData(loginForm);

  fetch('php/login-process.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(data => {
      if (data === 'success') {
        alert('Login successful!');
        loginForm.reset();
        closeModalById('loginModal');
        localStorage.setItem('isLoggedIn', 'true'); // mark user logged in
        window.location.href = 'php/account.php';
      } else if (data === 'invalid') {
        alert('Incorrect password.');
      } else if (data === 'notfound') {
        alert('No account found with that email.');
      } else {
        alert('Login failed.');
      }
    });
});

// ===== Store Map =====
function openMap(storeId) {
  const mapImage = document.getElementById('mapImage');
  const mapMap = {
    argao: 'assets/argao.png',
    dalaguete: 'assets/dalaguete.png',
    carcar: 'assets/carcar.png',
    talisay: 'assets/talisay.png',
    cebu: 'assets/cebu.png',
    gallery: 'assets/gallery.png',
    cordova: 'assets/cordova.png',
    oslob: 'assets/oslob.png'
  };

  if (mapMap[storeId]) {
    mapImage.src = mapMap[storeId];
    openModalById('mapModal');
  }
}

function closeMap() {
  closeModalById('mapModal');
}

// ===== Helpers =====
function openLoginModal() {
  openModalById('loginModal');
}
function openSignupModal() {
  openModalById('signupModal');
}

// ===== Initialize =====
document.addEventListener('DOMContentLoaded', () => {
  closeModalById('loginModal');
  closeModalById('signupModal');
  closeModalById('storesModal');
  closeModalById('mapModal');
});

// Product script
let currentProduct = {};
let selectedPrice = 0;

function openProductModal(title, description, imgSrc, types = []) {
  currentProduct = { title, description, imgSrc, types };
  document.getElementById('modal-title').innerText = title;
  document.getElementById('modal-description').innerText = description;
  document.getElementById('modal-img').src = imgSrc;
  document.getElementById('quantity').value = 1;

  const container = document.getElementById('type-buttons');
  container.innerHTML = '';

  if (types.length > 0) {
    types.forEach(type => {
      const btn = document.createElement('button');
      btn.className = 'type-btn';
      btn.innerText = type.label;
      btn.onclick = () => selectType(type);
      container.appendChild(btn);
    });
    selectType(types[0]); // default to first type
  } else {
    selectedPrice = 0;
    updatePrice();
  }

  openModalById('productModal'); // use generic opener
}

function selectType(type) {
  selectedPrice = type.price;
  document.getElementById('modal-img').src = type.img;
  document.getElementById('modal-description').innerText = type.description;
  updatePrice();
  highlightSelectedType(type.label);
}

function showCategory(categoryId) {
  const sections = document.querySelectorAll('.category-section');
  sections.forEach(section => {
    section.style.display = section.id === categoryId ? 'block' : 'none';
  });

  const buttons = document.querySelectorAll('.category-tabs button');
  buttons.forEach(btn => {
    btn.classList.toggle('active', btn.getAttribute('onclick').includes(categoryId));
  });
}


function updatePrice() {
  const qty = parseInt(document.getElementById('quantity').value) || 1;
  const total = selectedPrice * qty;
  document.getElementById('action-price').innerText = `₱${total}`;
}

function adjustQuantity(change) {
  const qtyInput = document.getElementById('quantity');
  let value = parseInt(qtyInput.value);
  value = Math.max(1, value + change);
  qtyInput.value = value;
  updatePrice();
}

function highlightSelectedType(label) {
  const buttons = document.querySelectorAll('.type-btn');
  buttons.forEach(btn => {
    btn.classList.toggle('active', btn.innerText === label);
  });
}
