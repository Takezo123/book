<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}


require_once '../db.php'; 


$sql = "SELECT cards.*, users.full_name 
        FROM cards 
        JOIN users ON cards.user_id = users.id 
        ORDER BY cards.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$cards = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Панель администратора</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Автор</th>
            <th>Название</th>
            <th>Пользователь</th>
            <th>Статус</th>
            <th>Причина отклонения</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($cards)): ?>
            <?php foreach ($cards as $card): ?>
                <tr>
                    <td><?= htmlspecialchars($card['author']) ?></td>
                    <td><?= htmlspecialchars($card['title']) ?></td>
                    <td><?= htmlspecialchars($card['full_name']) ?></td>
                    <td><?= ucfirst($card['status']) ?></td>
                    <td><?= htmlspecialchars($card['reject_reason']) ?: '-' ?></td>
                    <td>
                        <form method="post" action="approve_card.php" style="display:inline;">
                            <input type="hidden" name="card_id" value="<?= $card['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-success">Одобрить</button>
                        </form>

                        <form method="post" action="reject_card.php" style="display:inline;">
                            <input type="hidden" name="card_id" value="<?= $card['id'] ?>">
                            <input type="text" name="reason" placeholder="Причина" required>
                            <button type="submit" class="btn btn-sm btn-danger">Отклонить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Карточек пока нет</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="../logout.php" class="btn btn-secondary mt-3">Выход</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"crossorigin="anonymous"></script>
</body>
</html>