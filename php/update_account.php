<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: userPage.php");
    exit;
}

$user_id  = $_SESSION['user_id'];
$firstname = $_POST['firstname'];
$lastname  = $_POST['lastname'];
$email     = $_POST['email'];
$contact   = $_POST['contact'];

$sql = "UPDATE users SET firstname=?, lastname=?, email=?, contact=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $firstname, $lastname, $email, $contact, $user_id);

if ($stmt->execute()) {
    header("Location: userPage.php?updated=1");
    exit;
} else {
    echo "Update failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
