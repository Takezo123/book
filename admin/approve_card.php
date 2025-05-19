<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../db.php';

if (isset($_POST['card_id'])) {
    $card_id = intval($_POST['card_id']);

    $stmt = $conn->prepare("UPDATE cards SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $card_id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit;