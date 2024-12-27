<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION['username'];

// Пайвастшавӣ ба базаи маълумот
$pdo = new PDO("mysql:host=localhost;dbname=misic_site", "root", "");

// Гирифтани маълумот барои мусиқӣ ва жанрҳо
$music_stmt = $pdo->prepare("SELECT * FROM music WHERE user_id = ?");
$music_stmt->execute([$_SESSION['user_id']]);
$music_list = $music_stmt->fetchAll(PDO::FETCH_ASSOC);

// Гирифтани жанрҳо барои интихоб
$genre_stmt = $pdo->prepare("SELECT * FROM janr");  // genres - номи ҷадвали жанрҳо
$genre_stmt->execute();
$genres = $genre_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tg">
<head>
    <meta charset="UTF-8">
	<link rel="shortcut icon" href="images/logo1.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_dashboard.css"> <!-- Пайваст кардани CSS -->
    <link rel="stylesheet" href="css/style1.css"> <!-- CSS пайваст кунед -->
	<script src="js/ohang.js" defer></script> <!-- Пайваст кардани JavaScript -->
    <title>Сахифаи илова кардани мусиқи</title>
	
<style>
/* Стил барои селект */
select {

    width: 70%; /* Барои роҳатии мобил, селект бояд ба паҳнои кӯмаккарда мувофиқ шавад */
    padding: 10px 20px; /* Ранҷкунии дохили селект */
    font-size: 16px; /* Андозаи фонти матн */
    font-family: 'Arial', sans-serif; /* Фонти кросс-браузери бе маҳдудият */
    border: 1px solid #007BFF; /* Хати марз бо ранг, ки як намуди муосир дорад */
    border-radius: 0px; /* Кунҷҳои радиусӣ барои намуди зебо */
    background-color: #ffffff; /* Ранги заминаи тоза */
    color: #495057; /* Ранги хати матн */
    appearance: none; /* Нест кардани тир (arrow) стандартии селект */
    -webkit-appearance: auto; /* Барои Safari */
    -moz-appearance: auto; /* Барои Firefox */
    cursor: pointer; /* Қисмҳои кунҷи курсор ба зебоӣ */
    outline: none; /* Ба ҳангоми фокус на падид омадани хати фокуси стандартӣ */
    
}

/* Ҳангоми фокус кардани селект */
select:focus {
    border-color: #0056b3; /* Ранги марзи сафед ё як ранг мукофот барои фокус */
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5); /* Сени фокуси сафед */
}

/* Ҳангоми hover кардан дар селект */
select:hover {
    border-color: #0056b3; /* Хати марз вақте ки курсор боло равад */
	
}

/* Стили опсияҳои селект */
option {
    padding: 0px; /* Ранҷкунии дохилӣ барои ҳар як опсия */
    background-color: #ffffff; /* Ранги заминаи опсия */
    color: #333; /* Ранги матни опсия */
    border-bottom: 1px solid #e2e6ea; /* Хати тасвир барои ҷудо кардани опсияҳо */
    transition: background-color 0.3s ease; /* Ба осонӣ гузариш кардани фоны опсия */
	 cursor: pointer; /* Қисмҳои кунҷи курсор ба зебоӣ */
}

/* Стили hover опсия */
option:hover {
    background-color: #007BFF; /* Ранги заминаи опсияҳо ҳангоми ховидан */
    color: white; /* Ранги сафед барои хати матн */
	cursor: pointer; /* Қисмҳои кунҷи курсор ба зебоӣ */
}

/* Тиркаи (arrow) нест кардан */
select::-ms-expand {
    display: none; /* Барои нест кардани тиркаи стандартии Internet Explorer */
	 cursor: pointer; /* Қисмҳои кунҷи курсор ба зебоӣ */
}

/* Вақте ки селект дар мобил намоиш дода мешавад */
@media (max-width: 768px) {
    select {
        width: 100%; /* Паёмнома барои паҳнои тоза ва ҷавобгӯ */
		 cursor: pointer; /* Қисмҳои кунҷи курсор ба зебоӣ */
    }
}


</style>	
</head>
<body>
    <header>
        Саҳифаи шахсии истифодабарандаи <?= htmlspecialchars($username) ?>! <br>барои илова намудани мусиқи
    </header>
    <nav>
        <a href="dashboard.php">Багашт</a>
        <a href="logout.php">Баромад</a>
    </nav>
    
    <h2>Мусиқиро илова кунед!</h2>
    <form method="POST" action="upload_music.php" enctype="multipart/form-data">
        Номи мусиқӣ: <input type="text" name="title" required><br>
        
        <!-- Ҷойи интихоб кардани жанр -->
        Жанри мусиқӣ:
        <select name="ganr" required class="custom-select">
            <option value="">Жанри Мусиқиро интихоб кунед</option>
            <?php
            // Намудҳои жанрро намоиш медиҳем
            foreach ($genres as $genre) {
                echo "<option value=\"" . htmlspecialchars($genre['title']) . "\">" . htmlspecialchars($genre['title']) . "</option>";
            }
            ?>
        </select><br>

        Соли барориш: <input type="text" name="soli_barorish" required><br>
        Дарозии мусиқи: <input type="text" name="darozi" required><br>
        Тасвири мусиқи: <input type="file" name="images_file" required><br>
        Оҳанг: <input type="file" name="music_file" required><br>
        
       <button type="submit" class="tugma1">Илова кардан</button> <br><br>
    </form>
</body>
</html>
