// Load cart items from the server
function loadCart() {
  const cartBox = document.getElementById('cart-box');
  cartBox.innerHTML = '';

  fetch('get_cart.php') 
    .then(res => res.json())
    .then(cart => {
      const box = document.createElement('div');
      box.className = 'cart-content-box';

      if (cart.length === 0) {
        box.innerHTML = `
          <h2>Oops, Cart is Empty</h2>
          <p>Browse our products and add your favorites!</p>
          <button onclick="window.location.href='account.php#menu'" class="go-shopping-btn">
            Order your cravings now
          </button>
        `;
      } else {
        cart.forEach(item => {
          const div = document.createElement('div');
          div.className = 'cart-item';

          div.innerHTML = `
            <input type="checkbox" data-id="${item.cid}">
            <img src="../assets/${item.product_image}" alt="${item.product_name}">
            <div class="cart-info">
              <strong>${item.product_name}</strong><br>
              Qty: ${item.quantity}<br>
              Price: ₱${item.price}
            </div>
            <button onclick="removeItem(${item.cid})">Remove</button>
          `;

          box.appendChild(div);
        });

        // Cart actions
        const actions = document.createElement('div');
        actions.className = 'cart-actions';
        actions.innerHTML = `
          <button onclick="placeOrder()">Place Selected Order</button>
          <button onclick="clearCart()">Clear Cart</button>
        `;
        box.appendChild(actions);
      }

      cartBox.appendChild(box);
    });
}

// Add item to cart (server-side)
function addToCart() {
  const title = document.getElementById('modal-title').innerText;
  const price = parseFloat(document.getElementById('action-price').innerText.replace('₱', ''));
  const quantity = parseInt(document.getElementById('quantity').value);
  const type = document.querySelector('.type-btn.active')?.innerText || '';
  const img = document.getElementById('modal-img').src;

  fetch('add_cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ title, price, quantity, type, img })
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message || 'Added to cart!');
    closeModalById('productModal');
    loadCart(); // refresh cart display
  });
}

// Remove item from cart
function removeItem(cid) {
  fetch('remove_from_cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ cid })
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message || 'Item removed!');
    loadCart();
  });
}

// Place order
function placeOrder() {
  const selected = [];
  document.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
    selected.push(cb.dataset.id);
  });

  if (selected.length === 0) {
    alert('Please select at least one item to order.');
    return;
  }

  fetch('place_order.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ items: selected })
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message || 'Order placed!');
    loadCart();
  });
}

// Clear cart
function clearCart() {
  fetch('clear_cart.php', { method: 'POST' })
    .then(res => res.json())
    .then(data => {
      alert(data.message || 'Cart cleared!');
      loadCart();
    });
}

window.onload = loadCart;
