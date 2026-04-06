<?php
/*
Simple logic to change our password. 4/4/2026
*/
require_once '../require/databaseConnection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$password = trim($data['value']);

if (!$password) {
    echo json_encode(['success' => false, 'error' => 'Password cannot be empty.']);
    exit;
}
if (strlen($password) < 5) {
    echo json_encode(['success' => false, 'error' => 'Password must be longer than 5 characters.']);
    exit;
}

pdo($pdo, "UPDATE accounts SET PASSWORD = ? WHERE USER_ID = ?", [password_hash($password, PASSWORD_DEFAULT), $_SESSION['user_id']]);
echo json_encode(['success' => true]);