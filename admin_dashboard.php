<?php
session_start();
// Танҳо администратор дастрасӣ дошта бошад

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: login.php');
    exit;
}
$pdo = new PDO('mysql:host=localhost;dbname=misic_site', 'root', '');
$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tg">
<head>
    <meta charset="UTF-8">
    <title>Саҳифаи администратор</title>
	<link rel="shortcut icon" href="images/logo1.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_dashboard.css"> <!-- Пайваст кардани CSS -->
</head>
<body>
   <header>
        Панели Идоракунии Администратор
    </header>
<nav>
        <a href="admin_dashboard.php">Асосӣ</a>
        <a href="register.php">Иловаи Истифодабаранда</a>
        <a href="logout.php">Баромад</a>
    </nav>
  <div class="container">
  <!-- downplayer -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Ном</th>
            <th>E-mail</th>
            <th>Нақш</th>
            <th>Амалиёт</th>
			<th>Мусиқиҳо</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role'] == 1 ? 'Admin' : 'User') ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $user['id'] ?>">Тағйир</a> |
                    <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Шумо боварӣ доред?')">Нест кардан</a>
                </td>
				<td><a href="view_music.php?id=<?= $user['id'] ?>">Руйхати мусиқиҳо</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
	</div>
   
	<footer>
        © 2024 Панели Идоракунӣ
    </footer>

</body>
</html>
