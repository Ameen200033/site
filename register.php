<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=misic_site", "root", "");

// Санҷиши супориши форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 2; // Роли default барои корбар

    // Санҷиши почтаи электронӣ
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $emailExists = $stmt->fetchColumn();

    if ($emailExists) {
        // Агар почта вуҷуд дошта бошад, паём нишон дода шавад
        //echo "<script>alert('Ин гуна почта аллакай сабт шудааст. Лутфан дигар почтаро истифода баред.');</script>";
		$error="Ин гуна почта аллакаи сабт шудааст. Лутфан дигар почтаро истифода намоед.";
    } else {
        // Агар почта вуҷуд надошта бошад, корбарро сабт кун
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
        $stmt->execute([$username, $email, $password, $role]);
        echo "<script>alert('Шумо бомуваффақият сабти ном шудед!');</script>";
        header('Location: pages/login.php'); // Ин ҷо корбарро ба саҳифаи login равона кунед
        exit;
    }
}
?>
<html lang="tg">
<head>
    <meta charset="UTF-8">
    <title>Сахифаи асоси</title>
	<link rel="shortcut icon" href="images/logo1.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css"> <!-- Пайваст кардани CSS -->
</head>
<body>
<div class="login-container">
 <h1>Саҳифаи бақайдгири</h1>
<form method="POST" action="pages/register.php">
    <label>Ном:</label>
    <input type="text" name="username" required><br>
    <label>Email:</label>
    <input type="email" name="email" required >
    <span style="color: red;">
        <?php if (!empty($error)) echo $error; ?>
    </span><br>
    <label>Парол:</label>
    <input type="password" name="password" required><br>
    <button type="submit" class="button">Сабти ном</button>
	
</form></div>
</body>
</html>