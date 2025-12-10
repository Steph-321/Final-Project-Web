function loadCart() {
  const cartBox = document.getElementById('cart-box');
  const cart = JSON.parse(localStorage.getItem('cart')) || [];

  cartBox.innerHTML = ''; // Clear previous content

  const box = document.createElement('div');
  box.className = 'cart-content-box';

  if (cart.length === 0) {
    box.innerHTML = `
      <h2>Oops, Cart is Empty</h2>
      <p>Browse our products and add your favorites!</p>
    `;
  } else {
    cart.forEach((item, index) => {
      const div = document.createElement('div');
      div.className = 'cart-item';

      div.innerHTML = `
        <input type="checkbox" id="item-${index}" data-index="${index}">
        <img src="${item.img}" alt="${item.title}">
        <div class="cart-info">
          <strong>${item.title}</strong><br>
          Type: ${item.type} | Qty: ${item.qty}<br>
          Price: ₱${item.price}
        </div>
      `;

      box.appendChild(div);
    });
  }

  cartBox.appendChild(box);
}

function placeOrder() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const selected = [];

  document.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
    selected.push(cart[cb.dataset.index]);
  });

  if (selected.length === 0) {
    alert('Please select at least one item to order.');
    return;
  }

  // Save selected items to sessionStorage
  sessionStorage.setItem('selectedOrder', JSON.stringify(selected));

  // Redirect to order.html
  window.location.href = '../pages/order.html';
}

function clearCart() {
  localStorage.removeItem('cart');
  loadCart();
}

window.onload = loadCart;
