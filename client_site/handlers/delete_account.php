<?php
/*
Simple logic to DELETE OUR ACCOUNT!!! AHH. 4/4/2026
*/
require_once '../require/databaseConnection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in.']);
    exit;
}

pdo($pdo, "DELETE FROM accounts WHERE USER_ID = ?", [$_SESSION['user_id']]);

session_unset();
session_destroy();
echo json_encode(['success' => true]);