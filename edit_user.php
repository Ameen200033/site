<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header('Location: login.php');
    exit;
	}
$pdo = new PDO('mysql:host=localhost;dbname=misic_site', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role']; // 1 ё 2

    $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?');
    $stmt->execute([$username, $email, $role,  $id]);

    header('Location: admin_dashboard.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'Корбар ёфт нашуд.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="tg">
<head>
    <meta charset="UTF-8">
    <title>Тағйир додани корбар</title>
	<link rel="shortcut icon" href="images/logo1.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/syle_edit.css"> <!-- Пайваст кардани CSS -->
	
</head>
<body>
   <header>
        Панели идоракунии Администратор
    </header>
<nav>
            <a href="admin_dashboard.php">Баргашт</a>
        <a href="logout.php">Баромад</a>
    </nav>

<div class="container">
    <h1>Тағйир додани корбар</h1>
    <form method="POST">
	<div class="error">Илтимос майдонҳоро дуруст пур кунед!</div>
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <label>Ном:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"><br>
        <label>E-mail:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"><br>
		
        <label>Нақш (Рол) (1 - Администратор, 2 - Истифодабарандаи одди):</label>
        <select name="role">
            <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Администратор (Admin)</option>
            <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Истифодабарандаи одди (User)</option>
        </select><br>
        <button type="submit">Сабт кардан</button>
    </form>
	 </div>
    <footer>
        © 2024 Таҳрири корбар
    </footer>
</body>
</html>
