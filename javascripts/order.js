window.onload = function () {
  const orderListElement = document.getElementById('order-list');
  const totalAmount = document.getElementById('total-amount');
  const grandTotal = document.getElementById('grand-total');
  const feeAmount = parseFloat(document.getElementById('fee-amount').value);

  // Get selected order from sessionStorage (set in modal)
  const selectedOrder = JSON.parse(sessionStorage.getItem('selectedOrder')) || [];

  let total = 0;

  // Build order list
  selectedOrder.forEach(item => {
    const li = document.createElement('li');
    li.innerHTML = `
      <strong>${item.title}</strong> (${item.type}) x${item.qty} — ₱${item.price}
    `;
    orderListElement.appendChild(li);
    total += item.price * item.qty;
  });

  // Update totals
  totalAmount.value = total.toFixed(2);
  grandTotal.value = (total + feeAmount).toFixed(2);

  // Auto-fill hidden inputs for PHP backend
  const productInput = document.querySelector('input[name="product_name"]');
  const variantInput = document.querySelector('input[name="variant"]');
  const quantityInput = document.querySelector('input[name="quantity"]');
  const unitPriceInput = document.querySelector('input[name="unit_price"]');
  const totalInput = document.querySelector('input[name="total"]');
  const grandTotalInput = document.querySelector('input[name="grand_total"]');

  if (selectedOrder.length > 0) {
    const item = selectedOrder[0]; // assuming single item for now
    if (productInput) productInput.value = item.title;
    if (variantInput) variantInput.value = item.type;
    if (quantityInput) quantityInput.value = item.qty;
    if (unitPriceInput) unitPriceInput.value = item.price;
    if (totalInput) totalInput.value = total.toFixed(2);
    if (grandTotalInput) grandTotalInput.value = (total + feeAmount).toFixed(2);
  }
};
