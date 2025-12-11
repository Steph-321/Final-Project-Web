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

document.querySelectorAll('.close, .close-signup, .close-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        const modal = e.target.closest('.modal');
        if (modal) {
            closeModalById(modal.id);
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
  // Existing close button logic
  document.querySelectorAll('.close, .close-signup, .close-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      const modal = e.target.closest('.modal');
      if (modal) closeModalById(modal.id);
    });
  });

  const storesTrigger = document.querySelector(".stores-trigger");
  const storesModal = document.getElementById("storesModal");

  if (storesTrigger && storesModal) {
    storesTrigger.addEventListener("click", (e) => {
      e.preventDefault(); // prevent page jump
      openModalById("storesModal");
    });
  }
});

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
    openModalById('mapModal');
  }
}

function closeMap() {
  closeModalById('mapModal');
}


function openLoginModal() { openModalById('loginModal'); }
function openSignupModal() { openModalById('signupModal'); }

// --- Product Modal ---
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
        selectType(types[0]);
    } else {
        selectedPrice = 0;
        updatePrice();
    }

    openModalById('productModal');
}

function selectType(type) {
    selectedPrice = type.price;
    document.getElementById('modal-img').src = type.img;
    document.getElementById('modal-description').innerText = type.description;
    updatePrice();
    highlightSelectedType(type.label);
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

// --- Redirect to Order Page ---
function redirectToOrderPage() {
    const title = document.getElementById("modal-title").innerText;
    const price = parseFloat(document.getElementById("action-price").innerText.replace("₱", ""));
    const quantity = parseInt(document.getElementById("quantity").value);
    const variant = document.querySelector(".type-btn.active")?.innerText || "";

    const orderData = [{
        title: title,
        price: price,
        qty: quantity,
        type: variant
    }];
    
    sessionStorage.setItem("selectedOrder", JSON.stringify(orderData));
    alert("Redirect triggered!");

    window.location.href = "order.php";
}

// --- Category Tabs ---
function showCategory(categoryId) {
  // Hide all category sections
  const sections = document.querySelectorAll('.category-section');
  sections.forEach(section => {
    section.style.display = 'none';
  });

  // Show the selected category
  const selected = document.getElementById(categoryId);
  if (selected) {
    selected.style.display = 'block';
  }

  // Highlight the active tab
  const buttons = document.querySelectorAll('.category-tabs button');
  buttons.forEach(btn => {
    btn.classList.toggle('active', btn.getAttribute('onclick').includes(categoryId));
  });
}

