<?php
$api_key  = 'kdy';
$place_id = 'place_id';

$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=reviews&key={$api_key}";

$response = file_get_contents($url);
$data     = json_decode($response, true);

$reviews  = $data['result']['reviews'] ?? [];

if (empty($reviews)): ?>
    <p>No reviews found.</p>
<?php else: ?>
    <?php foreach ($reviews as $r): ?>
        <div class="review-card">
            <div class="review-header">
                <strong><?= htmlspecialchars($r['author_name']) ?></strong>
                <span class="review-rating">
                    <?= str_repeat('★', $r['rating']) ?><?= str_repeat('☆', 5 - $r['rating']) ?>
                </span>
                <span class="review-date"><?= htmlspecialchars($r['relative_time_description']) ?></span>
            </div>
            <p><?= htmlspecialchars($r['text']) ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>