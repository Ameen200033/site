<?php
session_start();

// Санҷиши воридшавии администратор
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: login.php');
    exit;
}
$user_id=$_SESSION["user_id"];
$username=$_SESSION['username'];

// Пайвастшавӣ ба базаи маълумот
$pdo = new PDO('mysql:host=localhost;dbname=misic_site', 'root', '');

// Гирифтани ID истифодабаранда аз URL
if (!isset($_GET['id'])) {
    die("ID истифодабаранда муайян нашудааст.");
}
$user_id = $_GET['id'];

// Гирифтани ҳама мусиқии истифодабаранда бо user_id
$stmt = $pdo->prepare('
    SELECT 
        music.id, 
        music.title,
		music.ganr,
		music.soli_barorish,  		
        music.file_path, 
        users.username AS owner 
    FROM 
        music 
    JOIN 
        users 
    ON 
        music.user_id = users.id 
    WHERE 
        music.user_id = ?
');
$stmt->execute([$user_id]);
$musics = $stmt->fetchAll(PDO::FETCH_ASSOC); // Бардоштани тамоми мусиқии истифодабаранда

// Санҷиш агар мусиқии ёфта нашуд
if (!$musics) {
    echo "Мусиқии ёфт нашуд.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tj">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Маълумоти мусиқӣ</title>
	 <title>Саҳифаи администратор</title>
	<link rel="shortcut icon" href="images/logo1.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_dashboard.css"> <!-- Пайваст кардани CSS -->
  <script src="./js/ohang.js" defer></script> <!-- Пайваст кардани JavaScript -->
  <link rel="stylesheet" href="css/style1.css"> <!-- CSS пайваст кунед -->
	
	
</head>
<body>
 <header>
        Панели Идоракунии Администратор
    </header>
	<nav>
        <a href="admin_dashboard.php">Асосӣ</a>
        <a href="admin_dashboard.php">Бозгашт ба панел</a>
        <a href="logout.php">Баромад</a>
    </nav>
    <h1>Мусиқии истифодабаранда <?= htmlspecialchars($username) ?></h1>
<div class="file-box">
 
         <?php foreach ($musics as $music): ?>
		
         <div class="music-item">
        <div class="music-info">
		
       <p><strong>Номи мусиқӣ:</strong> <?php echo htmlspecialchars($music['title']); ?></p>
       <p> <strong>Соҳиб:</strong> <?php echo htmlspecialchars($music['owner']); ?></p>
	    <p>  <strong>Жанр:</strong> <?= htmlspecialchars($music['ganr']) ?></p>
                   <p>   <strong>Соли барориш:</strong> <?= htmlspecialchars($music['soli_barorish']) ?>  <p> </div>
			
        <audio controls> <source src="<?= htmlspecialchars($music['file_path']) ?>" type="audio/mp3">
					 </audio> </div>
       
    <?php endforeach; ?>
    

</body>
</html>
