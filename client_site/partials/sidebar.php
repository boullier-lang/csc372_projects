<!--Mathew Boullier-->
<!--03/08/26-->
<!--PHP sidebar partial.-->


<?php 
	$announcementData = json_decode(file_get_contents('data/announcements.json'), true);
	$hoursData = json_decode(file_get_contents('data/hours.json'), true);
	
	$announcements = $announcementData['announcements'];
	$hours = $hoursData['hours'];

?>



<h1> Announcements </h1>
	<?php foreach($announcements as $x): ?>
		<h2><strong><?=$x['title']?></strong> - (<?=$x['date']?>) </h2>
		<p> <?=$x['message']?> </p>
	<?php endforeach;?>

<hr>

<h1> Hours of Operation </h1>
	<ul>
		<?php foreach ($hours as $x): ?>
			<li> <?=$x['day']?>: <?=$x['open']?> - <?=$x['close']?> </li>
		<?php endforeach;?>
	</ul>
