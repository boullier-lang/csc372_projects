<?php
/*
Simple logic to change our email. 4/4/2026
*/
require_once '../require/databaseConnection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$email = filter_var(trim($data['value']), FILTER_VALIDATE_EMAIL);

if (!$email) {
    echo json_encode(['success' => false, 'error' => 'Email cannot be empty.']);
    exit;
}

$existing = pdo($pdo, "SELECT USER_ID FROM accounts WHERE EMAIL = ?", [$email])->fetch();
if ($existing) {
    echo json_encode(['success' => false, 'error' => 'That email is already in use.']);
    exit;
}


pdo($pdo, "UPDATE accounts SET EMAIL = ? WHERE USER_ID = ?", [$email, $_SESSION['user_id']]);
echo json_encode(['success' => true]);