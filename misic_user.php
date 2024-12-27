<?php
session_start();

// Санҷиши воридшавии администратор
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !=1) {
    header('Location: login.php');
    exit;
}

// Пайвастшавӣ ба базаи маълумот
$pdo = new PDO('mysql:host=localhost;dbname=misic_site', 'root', '');

// Гирифтани рӯйхати мусиқиҳо
$stmt = $pdo->prepare('
    SELECT 
        music.id, 
        music.title, 
        music.file_path, 
        users.username AS owner 
    FROM 
        music 
    JOIN 
        users 
    ON 
        music.user_id = users.id
    ORDER BY 
        music.user DESC
');
$stmt->execute();
$musicList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tj">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Мусиқаҳои истифодабарандагон</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Номи мусиқӣ</th>
                <th>Корбар</th>
                <th>Файл</th>
                <th>Амалиёт</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($musicList as $music): ?>
                <tr>
                    <td><?php echo $music['id']; ?></td>
                    <td><?php echo htmlspecialchars($music['title']); ?></td>
                    <td><?php echo htmlspecialchars($music['owner']); ?></td>
                    <td><a href="<?php echo $music['file_path']; ?>" target="_blank">Намешо</a></td>
                    <td>
                        <!-- Тугмаҳои тағйир ва нест кардан -->
                        <a href="edit_music.php?id=<?php echo $music['id']; ?>">Тағйир</a> |
                        <a href="delete_music.php?id=<?php echo $music['id']; ?>" onclick="return confirm('Мусиқиро нест мекунед?')">Нест кардан</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
