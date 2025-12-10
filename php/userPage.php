<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/account.php");
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

$orders = [];
$order_sql = "SELECT id, total, order_date, status FROM orders WHERE user_id=? ORDER BY order_date DESC";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
while ($row = $order_result->fetch_assoc()) {
    $orders[] = $row;
}
$order_stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Account - Purple Yam</title>
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
                <li><a href="../index.html">Home</a></li>
                <li><a href="../index.html#menu">Menu</a></li>
                <li><a href="../index.html#about">About</a></li>
                <li><a href="#" class="stores-trigger">Stores</a></li>
            </ul>
        </nav>

        <div class="auth-links">
            <span></span>
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <div class="auth-links">
                <h2><span>Welcome, <?php echo htmlspecialchars($user['firstname']); ?></span></h2>
            </div>
            <ul>
                <li class="active" data-section="account-info"><a href="#">Account Information</a></li>
                <li data-section="transactions"><a href="#transactions">Purchase History</a></li>
                <li data-section="logout"><a href="#logout">Logout</a></li>
            </ul>
        </div>

        <main class="main-content">

            <section id="account-info" class="section active account-info">
                <h2>Account Information</h2>
                <form>
                    <div>
                        <label>Firstname</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['firstname']); ?>" readonly>
                    </div>
                    <div>
                        <label>Lastname</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['lastname']); ?>" readonly>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                    <div>
                        <label>Contact</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['contact']); ?>" readonly>
                    </div>
                </form>
            </section>

            <section id="transactions" class="transactions section">
                <h2>Purchase History</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                        <tr><td colspan="4">No orders yet.</td></tr>
                        <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>₱<?php echo number_format($order['total'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

            <section id="logout" class="logout section">
                <h2>Logout</h2>
                <p>Click below to end your session.</p>
                <a href="../php/logout.php"><button>Logout</button></a>
            </section>

        </main>
    </div>

    <footer>
        <p class="footer-bottom">© 2025 Purple Yam Bakeshop. All rights reserved.</p>
    </footer>

    <script src="javascripts/account.js"></script>
</body>

</html>
