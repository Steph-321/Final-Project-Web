<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit;
}

$product_name = '';
$variant      = '';
$quantity     = 1;
$unit_price   = 0;
$total        = 0;
$delivery_fee = 50.00;
$grand_total  = $total + $delivery_fee;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Purple Yam Delivery</title>
  <link rel="icon" type="image/png" href="../assets/logo.png" /> 
  <link rel="stylesheet" href="../styles/order.css" />
</head>
<body>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script>
    alert("Order submitted successfully!");
    sessionStorage.removeItem('selectedOrder'); 
  </script>
<?php endif; ?>

<header>
  <div class="logo">
    <img src="../assets/logo.png" alt="Purple Yam Logo" />
    <h1>PURPLE YAM</h1>
  </div>

  <nav class="main-nav">
    <ul>
      <li><a href="account.php">Home</a></li>
      <li><a href="account.php#menu">Menu</a></li>
      <li><a href="account.php#about">About</a></li>
      <li><a href="account.php#store" class="stores-trigger">Stores</a></li>
    </ul>
  </nav>

  <div class="auth-links">
    <a href="order.php">
      <img src="../assets/cart.png" alt="Cart">
    </a>
    <a href="userPage.php">
      <img src="../assets/profile-picture.png" alt="User" class="user-icon" />
      <span>Account</span>
    </a>
  </div>
</header>

<main class="order-main">
  <form action="place_order.php" method="POST">
    <section class="left">
      <h2>Delivery: Schedule for later &gt;</h2>
      <div class="info">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Full Name" required />

        <label for="contact">Contact Number</label>
        <input type="text" name="contact" placeholder="+639" required />
      </div>

      <label for="location">Delivery location</label>
      <input type="text" name="location" placeholder="e.g., Argao, Cebu, Philippines" required />

      <label for="address">Home Address</label>
      <input type="text" name="address" placeholder="e.g., street," required />
    </section>

    <section class="right">
      <h2>Order List</h2>
      <div class="order-box">
        <ul id="order-list" class="order-list">
          <li id="order-summary">No product selected yet.</li>
        </ul>

        <!-- Hidden fields for backend -->
        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>" />
        <input type="hidden" name="variant" value="<?php echo htmlspecialchars($variant); ?>" />
        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>" />
        <input type="hidden" name="unit_price" value="<?php echo $unit_price; ?>" />
        <input type="hidden" name="total" value="<?php echo $total; ?>" />
        <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>" />

        <div class="totals">
          <div class="cal">
            <span>Total</span>
            <input type="text" id="total-display" value="₱<?php echo number_format($total, 2); ?>" readonly />
          </div>
          <div class="cal">
            <span>Fee</span>
            <input type="text" value="₱<?php echo number_format($delivery_fee, 2); ?>" readonly />
          </div>
          <div class="cal">
            <span>Grand Total</span>
            <input type="text" id="grand-total-display" value="₱<?php echo number_format($grand_total, 2); ?>" readonly />
          </div>

          <div class="place">
            <button type="submit" class="add-address">Place Order</button>
          </div>
        </div>
      </div>
    </section>
  </form>
</main>

<footer>
  <p class="footer-bottom">© 2025 Purple Yam Bakeshop. All rights reserved.</p>
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const orderData = JSON.parse(sessionStorage.getItem("selectedOrder") || "[]");
  if (orderData.length > 0) {
    const item = orderData[0];
    // Update summary
    document.getElementById("order-summary").innerText =
      `${item.title} – ${item.type} (x${item.qty})`;

    // Fill hidden inputs
    document.querySelector("input[name='product_name']").value = item.title;
    document.querySelector("input[name='variant']").value = item.type;
    document.querySelector("input[name='quantity']").value = item.qty;
    document.querySelector("input[name='unit_price']").value = item.price;
    document.querySelector("input[name='total']").value = item.price * item.qty;
    document.querySelector("input[name='grand_total']").value = (item.price * item.qty) + 50;

    // Update totals display
    document.getElementById("total-display").value = `₱${(item.price * item.qty).toFixed(2)}`;
    document.getElementById("grand-total-display").value = `₱${((item.price * item.qty) + 50).toFixed(2)}`;
  }
});
</script>
</body>
</html>
