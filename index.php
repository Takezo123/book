<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head>
<body class="bg-light">
<div class="container py-5 text-center">
    <h1>Система управления карточками книг</h1>
    <?php if (isset($_SESSION['user'])): ?>
        <p>Привет, <?= htmlspecialchars($_SESSION['user']['full_name']) ?>!</p>
        <?php if ($_SESSION['user']['is_admin']): ?>
            <a href="admin/dashboard.php" class="btn btn-warning me-2">Панель администратора</a>
        <?php endif; ?>
        <a href="my_cards.php" class="btn btn-primary me-2">Мои карточки</a>
        <a href="add_card.php" class="btn btn-success me-2">Добавить карточку</a>
        <a href="logout.php" class="btn btn-secondary">Выход</a>
    <?php else: ?>
        <a href="login.php" class="btn btn-success me-2">Войти</a>
        <a href="register.php" class="btn btn-primary">Регистрация</a>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>