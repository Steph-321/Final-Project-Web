function adjustQuantity(change) {
  const qtyInput = document.getElementById('quantity');
  let value = parseInt(qtyInput.value);
  value = Math.max(1, value + change);
  qtyInput.value = value;
  updatePrice();
}

function updatePrice() {
  const typeSelect = document.getElementById('cake-type');
  const selectedOption = typeSelect.options[typeSelect.selectedIndex];
  const basePrice = parseInt(selectedOption.getAttribute('data-price'));
  const quantity = parseInt(document.getElementById('quantity').value);
  const total = basePrice * quantity;
  document.getElementById('action-price').innerText = `₱${total}`;
}
