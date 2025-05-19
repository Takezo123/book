<?php
session_start();
require_once 'db.php'; 

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['card_id'])) {
    $card_id = $_POST['card_id'];
    $user_id = $_SESSION['user']['id'];


    $stmt = $conn->prepare("UPDATE cards SET status = 'archived' WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $card_id, $user_id);
    $stmt->execute();
}

header("Location: my_cards.php");
exit;