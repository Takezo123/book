<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../db.php';

if (isset($_POST['card_id'], $_POST['reason'])) {
    $card_id = intval($_POST['card_id']);
    $reason = htmlspecialchars(trim($_POST['reason']));


    $stmt = $conn->prepare("UPDATE cards SET status = 'rejected', reject_reason = ? WHERE id = ?");
    $stmt->bind_param("si", $reason, $card_id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit;