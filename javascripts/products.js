let currentProduct = {};
let selectedPrice = 0;

function openModal(title, description, imgSrc, types = []) {
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

  document.getElementById('productModal').style.display = 'block';
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

function closeModal(id) {
  document.getElementById(id).style.display = 'none';
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
