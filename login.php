 <?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=misic_site", "root", "");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
	//сабти маълумот бо истифодаи сессия
        $_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['role'] = $user['role']; // Нақши корбар
		if ($user['role'] == 1) { 
		
		header('Location: admin_dashboard.php');
		} else {
        header("Location: dashboard.php");
    }
    exit;
	}
	else {
        $errorMassage="Ном ё Email ё Рамз/Парол нодуруст аст!";
    }
	}
?>
<html lang="tg">
<head>
    <meta charset="UTF-8">
	<link rel="shortcut icon" href="images/logo1.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css"> <!-- Пайваст кардани CSS -->
<style>
.error{
font-family:Arial, sans-serif;
color:red;
font-size:14px;
text-align:center;
}
</style>
    <title>Воридшавӣ</title>
</head>
<body>
<div class="login-container">
    <h1>ВОРИДШАВӢ БА СИСТЕМА</h1>
<form method="POST" action="login.php">
<?php 
if(!empty($errorMassage)) {
 echo '<div class="error">'.$errorMassage.'</div>'; } ?> 
   <input type="email" name="email" placeholder="Ном ё /Email" required><br>
   <input type="password" name="password" placeholder="Рамз ё /Парол" required><br>
    <button type="submit">Ворид шудан</button>

	</form></div>
</body>
</html>