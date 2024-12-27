<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Маълумотҳои марбут ба мусиқӣ ва тасвир
    $title = $_POST['title'];
    $ganr = $_POST['ganr'];
    $soli_barorish = $_POST['soli_barorish'];
    $darozi = $_POST['darozi'];
    $user_id = $_SESSION['user_id'];

    // Боргузории оҳанг (музика)
    if (isset($_FILES['music_file']) && $_FILES['music_file']['error'] == 0) {
        $music_file_path = 'uploads/' . basename($_FILES['music_file']['name']);
        if (!move_uploaded_file($_FILES['music_file']['tmp_name'], $music_file_path)) {
            echo "Хатоги ҳангоми боргузор кардани оҳанг!";
            exit;
        }
    } else {
        echo "Оҳанг интихоб нагардидааст!";
        exit;
    }

    // Боргузории тасвир
    if (isset($_FILES['images_file']) && $_FILES['images_file']['error'] == 0) {
        $image_file_path = 'uploads/images/' . basename($_FILES['images_file']['name']);
        if (!move_uploaded_file($_FILES['images_file']['tmp_name'], $image_file_path)) {
            echo "Хатоги ҳангоми боргузор кардани тасвир!";
            exit;
        }
    } else {
        echo "Тасвир интихоб нагардидааст!";
        exit;
    }

    // Пайвастшавӣ ба базаи додаҳо
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=misic_site", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ворид кардани маълумот ба база
        $stmt = $pdo->prepare("INSERT INTO music (user_id, title, file_path, imag_path, ganr, soli_barorish, darozi) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $music_file_path, $image_file_path, $ganr, $soli_barorish, $darozi]);

        echo "Мусиқи бо муваффақият илова шуд!";
        header("Location: pages/dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Ҳатоги дар базаи додаҳо: " . $e->getMessage();
    }
}
?>
