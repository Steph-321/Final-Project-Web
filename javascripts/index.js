// select the nav and log it
const mainNav = document.querySelector('.main-nav');
console.log(mainNav);

// select all links inside it
const navLinks = document.querySelectorAll('.main-nav a');
navLinks.forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    // handle navigation
  });
});

// Grab modal elements
const loginModal = document.getElementById('loginModal');
const signupModal = document.getElementById('signupModal');

// Grab triggers
const loginTriggers = document.querySelectorAll('.login-trigger');
const signupTriggers = document.querySelectorAll('.signup-trigger');

// Grab forms
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');

// Utility functions
function openModal(modal) {
  modal.style.display = 'block';
  modal.setAttribute('aria-hidden', 'false');
}

function closeModal(modal) {
  modal.style.display = 'none';
  modal.setAttribute('aria-hidden', 'true');
}

// Close buttons
document.querySelectorAll('.close, .close-signup').forEach(btn => {
  btn.addEventListener('click', () => {
    closeModal(loginModal);
    closeModal(signupModal);
  });
});

// Trigger events
loginTriggers.forEach(trigger => {
  trigger.addEventListener('click', e => {
    e.preventDefault();
    openModal(loginModal);
    closeModal(signupModal);
  });
});

signupTriggers.forEach(trigger => {
  trigger.addEventListener('click', e => {
    e.preventDefault();
    openModal(signupModal);
    closeModal(loginModal);
  });
});

// ✅ Handle Signup
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

// ✅ Handle Login
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
      // Redirect to account page
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

document.addEventListener('DOMContentLoaded', () => {
  closeModal(loginModal);
  closeModal(signupModal);
});


document.getElementById("stores-link").addEventListener("click", function(e) {
  e.preventDefault(); 
  document.getElementById("storesModal").style.display = "flex";
});

// Close Stores modal
function closeStores() {
  document.getElementById("storesModal").style.display = "none";
}

function openMap(storeId) {
    const mapImage = document.getElementById("mapImage");

    if (storeId === "argao") {
      mapImage.src = "../assets/argao.png";
    } else if (storeId === "dalaguete") {
      mapImage.src = "../assets/dalaguete.png";
    } else if (storeId === "carcar") {
      mapImage.src = "../assets/carcar.png";
    } else if (storeId === "talisay") {
      mapImage.src = "../assets/talisay.png";
    } else if (storeId === "cebu") {
      mapImage.src = "../assets/cebu.png";
    } else if (storeId === "gallery") {
      mapImage.src = "../assets/gallery.png";
    } else if (storeId == "cordova") {
      mapImage.src = "../assets/cordova.png"
    } else if (storeId == "oslob") {
      mapImage.src = "../assets/oslob.png"
    }

    document.getElementById("mapModal").style.display = "flex";
  }

  function closeMap() {
    document.getElementById("mapModal").style.display = "none";
  }

