<!-- Mathew Boullier -->
<!-- 3/8/26 -->
<!-- services.html replacement -->


<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
<!--Node/Express that I enjoyed working with, but uses PHP instead.-->

<?php
    $pageTitle = 'Golden Mane Salon — Services';
    $pageScript = 'services.js';
	$pageStyles = ['services.css'];
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
	require_once __DIR__ . '/require/ServiceCategory.php';
?>

<?php

    $json = file_get_contents('data/services.json');
    $data = json_decode($json, true);
    $categories = array_map(
        fn($cat) => new ServiceCategory($cat['category'], $cat['items']),
        $data['services']
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
								<span><?= $item->getPrice() ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>