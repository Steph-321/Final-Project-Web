<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}
include 'db_connect.php';

$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);

$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$user_id'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Account</title>
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
  <h2>Welcome, <?php echo $user['firstname']; ?>!</h2>
  <p>Email: <?php echo $user['email']; ?></p>

  <h3>Your Orders</h3>
  <table>
    <tr>
      <th>Product</th>
      <th>Type</th>
      <th>Quantity</th>
      <th>Total Price</th>
      <th>Date</th>
      <th>Status</th>
    </tr>
    <?php while($order = mysqli_fetch_assoc($order_query)) { ?>
    <tr>
      <td><?php echo $order['product_name']; ?></td>
      <td><?php echo $order['type']; ?></td>
      <td><?php echo $order['quantity']; ?></td>
      <td>₱<?php echo $order['total_price']; ?></td>
      <td><?php echo $order['order_date']; ?></td>
      <td><?php echo $order['status']; ?></td>
    </tr>
    <?php } ?>
  </table>

  <a href="logout.php">Logout</a>
</body>
</html>