<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author = trim($_POST['author']);
    $title = trim($_POST['title']);
    $want_library = isset($_POST['want_library']) ? 1 : 0;

    if (!empty($author) && !empty($title)) {
        $stmt = $conn->prepare("INSERT INTO cards (user_id, author, title, want_library) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $_SESSION['user']['id'], $author, $title, $want_library);
        $stmt->execute();
        header("Location: my_cards.php");
        exit;
    } else {
        $error = "Заполните все обязательные поля";
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить карточку</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Добавить карточку книги</h2>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>" ?>
    <form method="post">
        <div class="mb-3">
            <label>Автор</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Название книги</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="want_library" id="libraryCheck" class="form-check-input">
            <label for="libraryCheck" class="form-check-label">Хочу свою библиотеку</label>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>