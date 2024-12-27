<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION["user_id"];
$username = $_SESSION['username'];

// Пайвастшави ба база ва гирифтани маълумот
$pdo = new PDO("mysql:host=localhost;dbname=misic_site", "root", "");
$stmt = $pdo->prepare("SELECT * FROM music WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$music_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tg">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/logo1.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_dashboard.css"> <!-- Пайваст кардани CSS -->
    <link rel="stylesheet" href="css/style1.css"> <!-- CSS пайваст кунед -->
    <script src="../js/ohang.js" defer></script> <!-- Пайваст кардани JavaScript -->
    <title>Сахифаи асоси</title>
</head>
<body>
   <header>
        Саҳифаи шахсии истифодабарандаи <?= htmlspecialchars($username) ?>!
    </header>
   <nav>
        <a href="add_music.php">Иловаи мусиқи</a>
        <a href="logout.php">Баромад</a>
    </nav>

   <h2>Мусиқиҳои Шумо:</h2>

   <div class="file-box">
    <?php if (count($music_list) > 0): ?>
        <ul>
            <?php foreach ($music_list as $music): ?>
                <div class="music-item">
				<div class="music-info">
                 <p>   <strong>Ном:</strong> <?= htmlspecialchars($music['title']) ?></p>
                 <p>  <strong>Жанр:</strong> <?= htmlspecialchars($music['ganr']) ?></p>
                   <p>   <strong>Соли барориш:</strong> <?= htmlspecialchars($music['soli_barorish']) ?>  <p> </div>
                                       
                    <audio controls> 
                        <source src="<?= htmlspecialchars($music['file_path']) ?>" type="audio/mp3">
                    </audio></div>
               
            <?php endforeach; ?>
       
   
    <?php else: ?>
        <p>Шумо ягон мусиқии илова накардаед.</p>
    <?php endif; ?>
</body>
</html>




	