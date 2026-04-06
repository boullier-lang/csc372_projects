<?php
/*
Simple logic to change our name. 4/4/2026
*/
require_once '../require/databaseConnection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['value']);

if (!$name) {
    echo json_encode(['success' => false, 'error' => 'Name cannot be empty.']);
    exit;
}

pdo($pdo, "UPDATE accounts SET NAME = ? WHERE USER_ID = ?", [$name, $_SESSION['user_id']]);
echo json_encode(['success' => true]);