<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    $errors = [];

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
        $errors[] = "Логин должен содержать только буквы, цифры и символы подчеркивания.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Пароль должен быть не менее 6 символов.";
    }

    if (!preg_match('/^[а-яА-ЯёЁ\s]+$/u', $full_name)) {
        $errors[] = "ФИО должно содержать только кириллицу и пробелы.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email указан некорректно.";
    }

    if (empty($errors)) {

        $stmt = $conn->prepare("SELECT id FROM users WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Этот логин уже занят.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (login, password, full_name, phone, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $login, $hashed_password, $full_name, $phone, $email);
            $stmt->execute();
            header("Location: login.php");
            exit;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Регистрация</h2>
    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
    <?php } ?>
    <form method="post">
        <div class="mb-3">
            <label>Логин</label>
            <input type="text" name="login" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Пароль (не менее 6 символов)</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ФИО (кириллица и пробелы)</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Телефон</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
    <p class="mt-3">Уже есть аккаунт? <a href="login.php">Войти</a></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>