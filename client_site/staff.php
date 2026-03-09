<!-- Mathew Boullier -->
<!-- 3/8/26 -->
<!-- staff.html replacement -->


<!--I decided to take a modular approach to serving these webpages. I used a similar idea to-->
<!--Node/handlebars, using 'require_once' to serve partial parts of the pages.-->
<!--I find that this makes each file much easier to inspect, debug, etc. It keeps the parts of -->
<!--Node/Express that I enjoyed working with, but uses PHP instead.-->

<?php
    $pageTitle = 'Golden Mane Salon — Staff';
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
?>



<div id="main">

	<div id="left">
		STAFF!!!!!!!! STAFF!!!!!
	</div>
	
	<div id="right">
		This, is a work in progress...
	</div>

</div>


<?php require_once 'partials/footer.php'; ?>