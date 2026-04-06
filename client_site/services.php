<?php
/*
<!-- Mathew Boullier -->
<!-- 3/8/26 -->
<!-- services.html replacement -->


<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
<!--Node/Express that I enjoyed working with, but uses PHP instead.-->

Updated 4/2/2026
Now includes the services in a database instead of inside a json. We grab directly from the database.
*/
	session_start();
    $pageTitle = 'Golden Mane Salon — Services';
    $pageScript = 'services.js';
	$pageStyles = ['services.css'];
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
	require_once __DIR__ . '/require/serviceCategory.php';
?>

<?php

$sql  = "SELECT * FROM services";
$rows = pdo($pdo, $sql)->fetchAll();

// Group rows by category
$grouped = [];
foreach ($rows as $row) {
    $grouped[$row['CATEGORY']][] = $row;
}

// Now build your categories
$categories = array_map(
    fn($cat, $items) => new ServiceCategory($cat, $items),
    array_keys($grouped),
    array_values($grouped)
);
?>
<div id='main'>

	<div id="right">
		<div id="services">
			<?php foreach ($categories as $category): ?>
				<div class="service-category">
					<div class="category-header">
						<span><?= $category->getCategory() ?></span>
						<span class="arrow">▶</span>
					</div>
					<ul class="service-list open">
						<?php foreach ($category->getItems() as $item): ?>
							<li>
								<span><?= $item->getName() ?></span>
								<span>$<?= $item->getPrice() ?>+</span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
		<a href="booking.php"><button id="book-btn">BOOK NOW</button></a>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>