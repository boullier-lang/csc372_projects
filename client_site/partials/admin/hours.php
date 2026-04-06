<?php
// Handle update
if (isset($_POST['save_hours'])) {
    foreach ($_POST['hours'] as $day => $row) {
        $open_time  = date('g:i a', strtotime($row['OPEN_TIME']));
        $close_time = date('g:i a', strtotime($row['CLOSE_TIME']));
        $is_open    = isset($row['OPEN']) ? 1 : 0;

        pdo($pdo, "UPDATE operation_hours SET OPEN_TIME = ?, CLOSE_TIME = ?, `OPEN?` = ? WHERE DAY = ?",
            [$open_time, $close_time, $is_open, $day]);
    }
}

// Fetch and sort hours
$hours = pdo($pdo, "SELECT * FROM operation_hours")->fetchAll();
$dayOrder = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];
usort($hours, fn($a, $b) => ($dayOrder[$a['DAY']] ?? 8) <=> ($dayOrder[$b['DAY']] ?? 8));
?>

<h2>Hours of Operation</h2>
<p class="booking-intro">Update your opening and closing times below.</p>

<form method="POST">
    <fieldset class="booking-form">
        <legend>Weekly Hours</legend>

        <?php foreach ($hours as $h): ?>

                <div class="form-field" style="flex: 0 0 120px;">
                    <label><?= htmlspecialchars($h['DAY']) ?></label>
                    <input type="checkbox"
                           name="hours[<?= $h['DAY'] ?>][OPEN]"
                           <?= $h['OPEN?'] == 1 ? 'checked' : '' ?>>
                    <small>Open</small>
                </div>

                <div class="form-field">
                    <label>Open Time</label>
                    <input type="time"
                           name="hours[<?= $h['DAY'] ?>][OPEN_TIME]"
                           value="<?= date('H:i', strtotime($h['OPEN_TIME'])) ?>">
                </div>

                <div class="form-field">
                    <label>Close Time</label>
                    <input type="time"
                           name="hours[<?= $h['DAY'] ?>][CLOSE_TIME]"
                           value="<?= date('H:i', strtotime($h['CLOSE_TIME'])) ?>">
                </div>

				<hr>
        <?php endforeach; ?>

    </fieldset>

    <input type="submit" name="save_hours" value="Save Hours">
</form>