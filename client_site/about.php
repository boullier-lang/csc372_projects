<?php
	session_start();
/*
	<!-- Mathew Boullier -->
	<!-- 3/8/26 -->
	<!-- about.html replacement -->


	<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
	<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
	<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
	<!--Node/Express that I enjoyed working with, but uses PHP instead.-->
	
	
	Updated 4/5/2026
	Includes new information for the user to review (HTML additions).
*/
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
			
			<br> 
			<h2> Location </h2>
			<p> Golden Mane Salon is located at 650 Bald Hill Road, apart of Sola Salons. </p>
			<br>
			<h2> Cancellation Policy </h2>
			<p> Cancellations must occur 24 hours prior to your appointment. If you cancel within 24 hours
				of your appointment, you will be charged 50% of your scheduled appointment. If you no-call-no-show,
				you will be charged 100% of your scheduled appointment. </p>
			<br>
			
			<h2> Socials </h2>
			<ul>
				<li> <a href="https://www.instagram.com/beautybykyy_?igsh=bnBsZ3dwMmh6aXFx&utm_source=qr"> Instagram </a> </p>
				</li>
			</ul>
			<br><br>
			
			<p> <em> “Where Luxurious Hair Happens” </em> </p>
		</div>
</div>

<?php require_once 'partials/footer.php'; ?>