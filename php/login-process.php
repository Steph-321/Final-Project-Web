<?php
session_start();
include 'db_connect.php';

$usernameOrEmail = $_POST['email'] ?? null;
$password        = $_POST['password'] ?? null;

if (!$usernameOrEmail || !$password) {
  echo "missing"; 
  exit;
}

$sql = "SELECT * FROM users WHERE email=? OR contact=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['email']     = $user['email'];

    echo "success";
  } else {
    echo "invalid"; 
  }
} else {
  echo "notfound";
}

$stmt->close();
$conn->close();
?>
