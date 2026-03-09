<!-- Mathew Boullier -->
<!-- 3/8/26 -->
<!-- reviews.html replacement -->


<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
<!--Node/Express that I enjoyed working with, but uses PHP instead.-->
<?php
    $pageTitle = 'Golden Mane Salon — Reviews';
    $pageScript = 'reviews.js';
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
?>

	<div id="main">
		<div id="left">
			<h3>Enter Google API Key</h3>

			<input id="apikey" type="text" placeholder="Paste API Key here" size="50">
		</div>
		
		<div id="right">
		<p>This place is under construction, the Google API makes it very difficult to use it without it being from a backend. Also, I don't want to be in debt to the scary company that knows everything about me, so I'm not taking ANY chances!!!</p>
			<button id="load_reviews">Load Reviews</button>
			<button id="show_location"> Show Location </button>
			<div id="reviews"></div>
		</div>
		
	</div>

<?php require_once 'partials/footer.php'; ?>