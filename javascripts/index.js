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



