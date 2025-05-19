<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user']['id'];
$stmt = $conn->prepare("SELECT * FROM cards WHERE user_id = ? AND status != 'archived'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cards = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои карточки</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Мои карточки</h2>
    <a href="add_card.php" class="btn btn-success mb-3">Добавить новую карточку</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Автор</th>
            <th>Название</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cards as $card): ?>
            <tr>
                <td><?= htmlspecialchars($card['author']) ?></td>
                <td><?= htmlspecialchars($card['title']) ?></td>
                <td><?= ucfirst($card['status']) ?></td>
                <td>
                    <form action="archive_card.php" method="post" style="display:inline;">
                        <input type="hidden" name="card_id" value="<?= $card['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="logout.php" class="btn btn-secondary mt-3">Выход</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>