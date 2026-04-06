<?php
/*
The admin control center for our site. Is used to allow people with admin powers to
edit the databases. Uses partials/admins to show content.
*/
session_start();
$pageTitle = 'Golden Mane Salon — Admin';
$pageStyles = ['fields.css'];
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once __DIR__ . '/require/databaseConnection.php';

// Auth check; pull rank live from DB
if (!isset($_SESSION['user_id']) || pdo($pdo, "SELECT RANK FROM accounts WHERE USER_ID = ?", [$_SESSION['user_id']])->fetch()['RANK'] == 0) {
    header('Location: home_page.php');
    exit;
}

$section = $_GET['section'] ?? 'announcements';
?>

<div id="main">
    <div id="left">
        <?php require_once "partials/sidebar.php" ?>
    </div>
    <div id="right">
        <h1>Admin Panel</h1>
        <p class="booking-intro">Manage your site content below.</p>

        <div class="form-row">
            <a href="?section=announcements"><input type="submit" value="Announcements"></a>
            <a href="?section=services"><input type="submit" value="Services"></a>
            <a href="?section=hours"><input type="submit" value="Hours of Operation"></a>
        </div>

        <hr>

        <?php if ($section === 'announcements'): ?>
            <?php require_once 'partials/admin/announcements.php'; ?>
        <?php elseif ($section === 'services'): ?>
            <?php require_once 'partials/admin/service_admin.php'; ?>
        <?php elseif ($section === 'hours'): ?>
            <?php require_once 'partials/admin/hours.php'; ?>
        <?php endif; ?>

    </div>
</div>

<?php require_once 'partials/footer.php'; ?>