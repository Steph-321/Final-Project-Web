<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

include 'db_connect.php';

$user_id = $_SESSION['user_id'];

$cart_sql = "SELECT cid, product_name, product_image, price, quantity 
             FROM cart WHERE user_id = ?";

$stmt = $conn->prepare($cart_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Cart</title>
  <link rel="stylesheet" href="../styles/cart.css" />
</head>

<body>
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
        <li><a href="account.php" class="stores-trigger">Stores</a></li>
      </ul>
    </nav>

    <div class="auth-links">
      <a href="cart.php">
        <img src="../assets/cart.png" alt="Cart">
      </a>
      <a href="userPage.php">
        <img src="../assets/profile-picture.png" alt="User" class="user-icon" />
        <span>Account</span>
      </a>
    </div>
  </header>

  <main>
    <section class="cart-section">
      <?php if (empty($cart_items)): ?>
      <!-- Empty cart state -->
      <div class="empty-cart-box">
        <div class="cart-illustration">
          <div class="cart-icon">🛒</div>
        </div>
        <h2>Oops, Your Food Cart is Empty</h2>
        <p>Browse our awesome cake deals now!</p>
        <a href="account.php#menu" class="go-shopping-btn">Order your cravings now</a>
      </div>
      <?php else: ?>
      <!-- Cart items -->
      <div id="cart-box" class="cart-box">
        <?php foreach ($cart_items as $item): ?>
        <div class="cart-item">
          <img src="../assets/<?php echo htmlspecialchars($item['product_image']); ?>"
               alt="<?php echo htmlspecialchars($item['product_name']); ?>" />
          <div class="item-details">
            <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
            <p>₱<?php echo number_format($item['price'], 2); ?></p>
            <p>Quantity: <?php echo (int)$item['quantity']; ?></p>
          </div>
          <button class="remove-item" onclick="removeItem(<?php echo (int)$item['cid']; ?>)">Remove</button>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Cart actions -->
      <div class="cart-actions">
        <button onclick="placeOrder()">Place Selected Order</button>
        <button onclick="clearCart()">Clear Cart</button>
      </div>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <p class="footer-bottom">© 2025 Purple Yam Bakeshop. All rights reserved.</p>
  </footer>

  <script src="../javascripts/cart.js"></script>
</body>

</html>
