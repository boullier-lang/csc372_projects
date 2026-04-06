<?php
/*
<!-- Mathew Boullier -->
<!-- 4/3/26 -->
<!-- account.php -->
Created to hold the control panel for the account (settings, logout, orders, admin). Uses partials/accounts to
grab the appropiate content.


*/
	session_start();
    $pageTitle = 'Golden Mane Salon — Account';
	$pageStyles = ['fields.css'];
	$pageScript='account.js';
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
	
	$page = $_GET['page'] ?? 'settings';
	$sql_rank="SELECT * FROM `accounts` WHERE `USER_ID`=?";
?>


<div id='main'>
	<div id="left">
		<a href="account.php?page=settings"><input type="submit" value="Settings"></a>
		<a href="account.php?page=orders"><input type="submit" value="Order History"></a>
		<?php if (pdo($pdo, $sql_rank, [$_SESSION['user_id']])->fetch()['RANK'] == 1): ?>
			<a href="admin.php"><input type="submit" value="Admin Panel"></a>
		<?php endif; ?>
		<a href="logout.php"><input type="submit" value="Logout"></a>
	</div>

	<div id="right">
		<?php if ($page === 'settings'): ?>
			<?php require_once 'partials/account/settings.php'; ?>
		<?php elseif ($page === 'orders'): ?>
			<?php require_once 'partials/account/orders.php'; ?>
		<?php elseif ($page === 'admin' && pdo($pdo, $sql_rank, [$_SESSION['user_id']])->fetch()['RANK'] == 1): ?>
			<?php require_once 'partials/account/admin.php'; ?>
		<?php endif; ?>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>