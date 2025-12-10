// Mock signed-in user data
const currentUser = {
  id: 1,
  name: "John Doe",
  contactNumber: "555-1234",
  address: "123 Main St, City, State 12345"
};

let products = [];
let orderList = [];
let currentAddress = currentUser.address;

// Fetch products from your product database/API
async function loadProducts() {
  try {
    const response = await fetch('/api/products');
    products = await response.json();
    displayProducts();
  } catch (error) {
    console.error("Error loading products:", error);
    products = [
      { id: 1, name: "Laptop", price: 999.99 },
      { id: 2, name: "Mouse", price: 29.99 }
    ];
    displayProducts();
  }
}

// Display user info (auto-filled from signed-in account)
function displayUserInfo() {
  document.getElementById("userName").textContent = currentUser.name;
  document.getElementById("userContact").textContent = currentUser.contactNumber;
  document.getElementById("userAddress").textContent = currentAddress;
}

// Add new address and clear the field
function addNewAddress() {
  const newAddressInput = document.getElementById("newAddressInput").value.trim();
  
  if (newAddressInput === "") {
    alert("Please enter an address");
    return;
  }
  
  currentAddress = newAddressInput;
  displayUserInfo();
  
  // Clear the input field
  document.getElementById("newAddressInput").value = "";
  document.getElementById("addressForm").style.display = "none";
}

// Show address input form
function showAddressForm() {
  document.getElementById("addressForm").style.display = "block";
  document.getElementById("newAddressInput").focus();
}

// Display products from connected database
function displayProducts() {
  const productContainer = document.getElementById("productList");
  productContainer.innerHTML = "";
  
  products.forEach(product => {
    const productDiv = document.createElement("div");
    productDiv.className = "product-item";
    productDiv.innerHTML = `
      <p>${product.name} - $${product.price.toFixed(2)}</p>
      <button onclick="addToOrder(${product.id})">Add to Order</button>
    `;
    productContainer.appendChild(productDiv);
  });
}

// Add product from database to order
function addToOrder(productId) {
  const product = products.find(p => p.id === productId);
  if (product) {
    orderList.push({...product});
    updateOrderDisplay();
  }
}

// Remove product from order
function removeFromOrder(index) {
  orderList.splice(index, 1);
  updateOrderDisplay();
}

// Update order display and calculate total
function updateOrderDisplay() {
  const orderContainer = document.getElementById("orderList");
  orderContainer.innerHTML = "";
  let total = 0;
  
  orderList.forEach((item, index) => {
    const orderItem = document.createElement("div");
    orderItem.className = "order-item";
    orderItem.innerHTML = `
      <span>${item.name} - $${item.price.toFixed(2)}</span>
      <button onclick="removeFromOrder(${index})">Remove</button>
    `;
    orderContainer.appendChild(orderItem);
    total += item.price;
  });
  
  document.getElementById("total").textContent = `Total: $${total.toFixed(2)}`;
}

// Submit order
function submitOrder() {
  if (orderList.length === 0) {
    alert("Please add products to your order");
    return;
  }
  
  const order = {
    userId: currentUser.id,
    userName: currentUser.name,
    contactNumber: currentUser.contactNumber,
    address: currentAddress,
    items: orderList,
    total: orderList.reduce((sum, item) => sum + item.price, 0),
    date: new Date().toLocaleString()
  };
  
  console.log("Order submitted:", order);
  alert("Order submitted successfully!");
  orderList = [];
  updateOrderDisplay();
}

window.onload = function () {
  const orderList = document.getElementById('order-list');
  const totalAmount = document.getElementById('total-amount');
  const grandTotal = document.getElementById('grand-total');
  const feeAmount = parseFloat(document.getElementById('fee-amount').value);

  const selectedOrder = JSON.parse(sessionStorage.getItem('selectedOrder')) || [];

  let total = 0;

  selectedOrder.forEach(item => {
    const li = document.createElement('li');
    li.innerHTML = `
      <strong>${item.title}</strong> (${item.type}) x${item.qty} — ₱${item.price}
    `;
    orderList.appendChild(li);
    total += item.price * item.qty;
  });

  totalAmount.value = total.toFixed(2);
  grandTotal.value = (total + feeAmount).toFixed(2);
};
