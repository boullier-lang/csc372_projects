<?php
/*
<!--Mathew Boullier-->
<!--03/08/26-->
<!--PHP navbar partial.-->

Updated 4/5/2026,
now includes link highlighting depending on what page we have selected.
*/

$current_page = basename($_SERVER['PHP_SELF']);
?>

<div id="main-navbar">
	<div id="nav-logo">
		<img src="resources/logo.png" alt="Golden Mane logo" height="128" width="128">
	</div>
	<ul id="nav-links">
		<li><a href="home_page.php" <?= $current_page === 'home_page.php' ? 'class="active"' : '' ?>>HOME</a></li>
		<li><a href="services.php" <?= $current_page === 'services.php' ? 'class="active"' : '' ?>>SERVICES</a></li>
		<li><a href="about.php" <?= $current_page === 'about.php' ? 'class="active"' : '' ?>>ABOUT</a></li>
		<li><a href="gift-cards.php" <?= $current_page === 'gift-cards.php' ? 'class="active"' : '' ?>>GIFT-CARDS</a></li>
		<li><a href="reviews.php" <?= $current_page === 'reviews.php' ? 'class="active"' : '' ?>>REVIEWS</a></li>
		<?php if (isset($_SESSION['user_id'])): ?>
			<li><a href="account.php" <?= $current_page === 'account.php' ? 'class="active"' : '' ?>>ACCOUNT</a></li>
		<?php else: ?>
			<li><a href="login.php" <?= $current_page === 'login.php' ? 'class="active"' : '' ?>>LOGIN</a></li>
		<?php endif; ?>
	</ul>
</div>