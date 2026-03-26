<!--Mathew Boullier-->
<!--03/08/26-->
<!--PHP sidebar partial.-->
<?php
    // start session
    session_start();

    // Handle session termination FIRST, right after session_start()
    if (isset($_GET['end_session'])) {
        session_unset();
        session_destroy();
        setcookie('visitor_name', '', time() - 3600, '/');
        setcookie('visit_count', '', time() - 3600, '/');
        setcookie(session_name(), '', time() - 3600, '/');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    // Track last page visited in session
    $_SESSION['last_page'] = htmlspecialchars($_SERVER['PHP_SELF']);

    $visit_count = isset($_COOKIE['visit_count']) ? intval($_COOKIE['visit_count']) + 1 : 1;
    setcookie('visit_count', $visit_count);
    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $visitor_name = htmlspecialchars(trim($_GET['name']));
        setcookie('visitor_name', $visitor_name);
    } elseif (isset($_COOKIE['visitor_name'])) {
        $visitor_name = htmlspecialchars($_COOKIE['visitor_name']);
    } else {
        $visitor_name = null;
    }
    $display_count = htmlspecialchars($visit_count);
    $announcementData = json_decode(file_get_contents('data/announcements.json'), true);
    $hoursData        = json_decode(file_get_contents('data/hours.json'), true);
    $announcements = $announcementData['announcements'];
    $hours = $hoursData['hours'];
?>

<div class="sidebar-visitor">
    <?php if ($visitor_name): ?>
        <p>Welcome back, <strong><?= $visitor_name ?></strong>!</p>
    <?php else: ?>
        <p>Welcome, guest!</p>
    <?php endif; ?>
    <a href="?end_session=1" class="btn-end-session">End Session</a>
</div>
<hr>
<h2>Announcements</h2>
<?php foreach ($announcements as $x): ?>
    <h3><strong><?= $x['title'] ?></strong> - (<?= $x['date'] ?>)</h3>
    <p><?= $x['message'] ?></p>
<?php endforeach; ?>
<hr>
<h2>Hours of Operation</h2>
<ul>
    <?php foreach ($hours as $x): ?>
        <li><?= $x['day'] ?>: <?= $x['open'] ?> - <?= $x['close'] ?></li>
    <?php endforeach; ?>
</ul>