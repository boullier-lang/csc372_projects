<?php
/*
<!-- Mathew Boullier -->
<!-- 3/8/26 -->
<!-- home_page.html replacement -->


<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
<!--Node/Express that I enjoyed working with, but uses PHP instead.-->

*/
	session_start();
    $pageTitle = 'Golden Mane Salon — Home';
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
        <div class="photo-grid">
            <img src="resources/img_one.jpg" alt="Hair Style 1">
            <img src="resources/img_two.jpg" alt="Hair Style 2">
            <img src="resources/img_three.jpg" alt="Hair Style 3">
            <img src="resources/img_four.jpg" alt="Hair Style 4">
            <img src="resources/img_five.jpg" alt="Hair Style 5">
            <img src="resources/img_six.jpg" alt="Hair Style 6">
        </div>
		<a href="booking.php"><button id="book-btn">BOOK NOW</button></a>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>