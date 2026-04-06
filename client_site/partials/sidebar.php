<?php
/*
<!--Mathew Boullier-->
<!--03/08/26-->
<!--PHP sidebar partial.-->

Updated to include integration with databases instead of plain json.
*/
	$user_id_sql="SELECT NAME FROM accounts WHERE USER_ID = ?";

	//Connect to the database, and get announcements & hours of Operation
	$sql = "SELECT * FROM operation_hours";
	$hours = pdo($pdo, $sql)->fetchAll();
	//Now that we have all of our hours of operation, lets sort them by DAY
	$dayOrder = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];
	usort($hours, fn($a, $b) => ($dayOrder[$a['DAY']] ?? 8) <=> ($dayOrder[$b['DAY']] ?? 8));

	//Next, we redo what we did with announcements.
	$sql = "SELECT * FROM announcements";
	$announcements = pdo($pdo, $sql)->fetchAll();
?>

<div class="sidebar-visitor">
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Welcome back, <strong><?= pdo($pdo,$user_id_sql,[$_SESSION['user_id']])->fetch()['NAME'];?></strong>!</p>
    <?php else: ?>
        <p>Welcome, guest!</p>
    <?php endif; ?>
</div>
<hr>
<h2>Announcements</h2>
<?php foreach ($announcements as $x): ?>
    <h3><strong><?= $x['HEADER'] ?></strong> - (<?= $x['DATE'] ?>)</h3>
    <p><?= $x['MESSAGE'] ?></p>
<?php endforeach; ?>
<hr>
<h2>Hours of Operation</h2>
<ul>
<?php foreach ($hours as $x): ?>
    <li>
        <strong><?= $x['DAY'] ?>: </strong> 
        <?php if ($x['OPEN?'] == 1): ?>
            <?= $x['OPEN_TIME'] ?> - <?= $x['CLOSE_TIME'] ?>
        <?php else: ?>
            Closed
        <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>