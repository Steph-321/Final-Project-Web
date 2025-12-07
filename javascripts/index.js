// Select the nav and log it
const mainNav = document.querySelector('.main-nav');
console.log(mainNav);

// Grab modal elements
const loginModal = document.getElementById('loginModal');
const signupModal = document.getElementById('signupModal');
const storesModal = document.getElementById('storesModal'); // make sure HTML uses this ID

// Grab triggers
const loginTriggers = document.querySelectorAll('.login-trigger');
const signupTriggers = document.querySelectorAll('.signup-trigger');
const storesTrigger = document.querySelector('.stores-trigger'); // nav link/button

// Grab forms
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');

// Utility functions
function openModal(modal) {
  if (!modal) return;
  modal.style.display = 'flex'; // flex for centering
  modal.setAttribute('aria-hidden', 'false');
}

function closeModal(modal) {
  if (!modal) return;
  modal.style.display = 'none';
  modal.setAttribute('aria-hidden', 'true');
}

// Close buttons for all modals
document.querySelectorAll('.close, .close-signup, .close-btn').forEach(btn => {
  btn.addEventListener('click', (e) => {
    const modal = e.target.closest('.modal');
    if (modal) closeModal(modal);
  });
});

// Login trigger events
loginTriggers.forEach(trigger => {
  trigger.addEventListener('click', e => {
    e.preventDefault();
    openModal(loginModal);
    closeModal(signupModal);
    closeModal(storesModal);
  });
});

// Signup trigger events
signupTriggers.forEach(trigger => {
  trigger.addEventListener('click', e => {
    e.preventDefault();
    openModal(signupModal);
    closeModal(loginModal);
    closeModal(storesModal);
  });
});

// Stores trigger event
if (!storesTrigger) {
  console.warn('No .stores-trigger found in DOM');
} else {
  storesTrigger.addEventListener('click', async e => {
    e.preventDefault();

    const pathsToTry = ['stores.html', 'pages/stores.html', './pages/stores.html'];
    let html = null;

    for (const p of pathsToTry) {
      try {
        const res = await fetch(p);
        if (!res.ok) throw new Error(`${res.status} ${res.statusText}`);
        html = await res.text();
        console.log('Loaded stores from', p);
        break;
      } catch (err) {
        console.debug('fetch failed for', p, err);
      }
    }

    if (!html) {
      console.error('Could not load stores.html from any path.');
      return;
    }

    const storesContainer = document.getElementById('stores-container');
    if (!storesContainer) {
      console.error('#stores-container not found in DOM. Add the modal placeholder to index.html.');
      return;
    }

    storesContainer.innerHTML = html;
    openModal(storesModal);
    closeModal(loginModal);
    closeModal(signupModal);

    // attach dynamic handlers inside loaded content
    storesContainer.querySelectorAll('[data-open-map]').forEach(el => {
      el.addEventListener('click', (ev) => {
        const id = el.getAttribute('data-open-map');
        openMap(id);
      });
    });
  });
}

// Handle Signup
signupForm && signupForm.addEventListener('submit', e => {
  e.preventDefault();

  const formData = new FormData(signupForm);

  fetch('php/signup-process.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    if (data === 'success') {
      alert('Account created successfully!');
      signupForm.reset();
      closeModal(signupModal);
      openModal(loginModal);

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

// Handle Login
loginForm && loginForm.addEventListener('submit', e => {
  e.preventDefault();

  const formData = new FormData(loginForm);

  fetch('php/login-process.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    if (data === 'success') {
      alert('Login successful!');
      loginForm.reset();
      closeModal(loginModal);
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

document.getElementById('mapModal').setAttribute('data-active', 'true');

// Map functions
function openMap(storeId) {
  const mapImage = document.getElementById('mapImage');
  const mapMap = {
    argao: '../assets/argao.png',
    dalaguete: '../assets/dalaguete.png',
    carcar: '../assets/carcar.png',
    talisay: '../assets/talisay.png',
    cebu: '../assets/cebu.png',
    gallery: '../assets/gallery.png',
    cordova: '../assets/cordova.png',
    oslob: '../assets/oslob.png'
  };

  if (mapMap[storeId]) {
    mapImage.src = mapMap[storeId];
    document.getElementById('mapModal').style.display = 'flex';
  }
}

function closeMap() {
  document.getElementById('mapModal').style.display = 'none';
}

// Initialize - close modals on load
document.addEventListener('DOMContentLoaded', () => {
  closeModal(loginModal);
  closeModal(signupModal);
  closeModal(storesModal);
});
