<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

include 'db_connect.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT firstname, lastname, email, contact FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$sql = "SELECT id, order_date, product_name, variant, quantity, unit_price, total, grand_total 
        FROM orders 
        WHERE user_id = ? 
        ORDER BY order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Account - Purple Yam</title>
    <link rel="icon" type="image/png" href="../assets/logo.png" /> 
    <link rel="stylesheet" href="../styles/userePage.css">
</head>

<body>

    <header>
        <div class="logo">
            <img src="../assets/logo.png" alt="Purple Yam Logo">
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
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <h2>Welcome, <?php echo htmlspecialchars($user['firstname']); ?></h2>
            <ul>
                <li class="active" data-section="account-info"><a href="#">Account Information</a></li>
                <li data-section="transactions"><a href="#transactions">Purchase History</a></li>
                <li data-section="logout"><a href="#logout">Logout</a></li>
            </ul>
        </div>

        <main class="main-content">

            <section id="account-info" class="section active account-info">
                <h2>Account Information</h2>
                <form action="update_account.php" method="POST">
                <div>
                    <label>Firstname</label>
                    <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                </div>
                <div>
                    <label>Lastname</label>
                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div>
                    <label>Contact</label>
                    <input type="text" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
                </div>
                <button type="submit" class="save-btn">Update Info</button>
                </form>

            </section>

            <section id="transactions" class="transactions section">
                <h2>Purchase History</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows === 0): ?>
                            <tr><td colspan="8">No orders yet.</td></tr>
                        <?php else: ?>
                            <?php while ($order = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['order_date']; ?></td>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['variant']); ?></td>
                                <td><?php echo (int)$order['quantity']; ?></td>
                                <td>₱<?php echo number_format($order['unit_price'], 2); ?></td>
                                <td>₱<?php echo number_format($order['total'], 2); ?></td>
                                <td>₱<?php echo number_format($order['grand_total'], 2); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        </tbody>

                </table>
            </section>



            <section id="logout" class="logout section">
                <h2>Logout</h2>
                <p>Click below to end your session.</p>
                <button id="logoutBtn">Logout</button>
            </section>

        </main>
    </div>

    <footer>
        <p class="footer-bottom">© 2025 Purple Yam Bakeshop. All rights reserved.</p>
    </footer>

    <script src="../javascripts/userPage.js"></script>
</body>

</html>
