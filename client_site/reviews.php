<?php
/*
<!-- Mathew Boullier -->
<!-- 3/8/26 -->
<!-- reviews.html replacement -->


<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
<!--Node/Express that I enjoyed working with, but uses PHP instead.-->

Updated 4/4/2026
Finally was able to build up the courage to fully add in the google API. I'm still terrified of being charged
1 morbillion dollars. But its okay. It works.
*/
	session_start();
    $pageTitle = 'Golden Mane Salon — Reviews';
    $pageStyles = ['reviews.css'];
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
?>
<div id="main">
    <div id="left">
        <?php require_once "partials/sidebar.php" ?>
    </div>
    <div id="right">
        <h1>Reviews</h1>
        <div id="reviews">
            <?php require_once 'partials/reviews_list.php'; ?>
        </div>
		
			<p> Golden Mane Salon currently has posting new reviews disabled. Therefore, we are unable to post reviews
		from this page. </p>
    </div>
	

</div>
<?php require_once 'partials/footer.php'; ?>