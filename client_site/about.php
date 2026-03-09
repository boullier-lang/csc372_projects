<!-- Mathew Boullier -->
<!-- 3/8/26 -->
<!-- about.html replacement -->


<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
<!--Node/Express that I enjoyed working with, but uses PHP instead.-->

<?php
    $pageTitle = 'Golden Mane Salon — About';
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
?>

<div id="main">
    <!-- LEFT SIDE -->
    <div id="left">
		<?php require_once "partials/sidebar.php"?>
    </div>
    <!-- RIGHT SIDE -->
		<div id="right">
			<h1>About...</h1>
			I am a Rhode Island based Blonding Specialist. Whether you dream of Low maintenance, Naturally sun- kissed or a Bombshell Blonde transformation in a one on one luxurious suite experience. 
			My goal is to leave you loving & having a healthier relationship with your hair while still achieving your hair dreams!
			
			<br> <br><br>
			
			<p> <em> “Where Luxurious Hair Happens” </em> </p>
		</div>
</div>

<?php require_once 'partials/footer.php'; ?>