<?php
/*
<!-- Mathew Boullier -->
<!-- 3/8/26 -->
<!-- gift-cards.html replacement -->


<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
<!--Node/Express that I enjoyed working with, but uses PHP instead.-->

*/

	session_start();
    $pageTitle = 'Golden Mane Salon — Gift-Cards';
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
?>

<div id="main">


	<div id="left">
		<h1> E-Gift Cards </h1>
		
		<!-- -->
		<p> Give the gift of gorgeous hair with our E-Gift Cards; perfect for any occasion. Whether they’re craving a fresh cut, vibrant color, 
		or a little well-deserved pampering, our digital gift cards make it easy to treat someone special in just a few clicks. Delivered instantly and redeemable on their schedule, 
		it’s a thoughtful way to share confidence, style, and self-care... because this is where luxurious hair happens.<p>
		
		
		<button id="buy_giftcard"> PURCHASE </button>
	</div>

</div>

<?php require_once 'partials/footer.php'; ?>