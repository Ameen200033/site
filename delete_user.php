<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header('Location: login.php');
    exit;
}

$pdo = new PDO('mysql:host=localhost;dbname=misic_site', 'root', '');

$id = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
$stmt->execute([$id]);

header('Location: admin_dashboard.php');
exit;
?>
