<?php
// Handle delete
if (isset($_POST['delete_service'])) {
    pdo($pdo, "DELETE FROM services WHERE SERVICE_ID = ?", [$_POST['delete_service']]);
}

// Handle edit
if (isset($_POST['edit_id'])) {
    $name     = trim($_POST['edit_name']);
    $category = trim($_POST['edit_category']);
    $price    = trim($_POST['edit_price']);
    if ($name && $category && $price) {
        pdo($pdo, "UPDATE services SET NAME = ?, CATEGORY = ?, PRICE = ? WHERE SERVICE_ID = ?",
            [$name, $category, $price, $_POST['edit_id']]);
    }
}

// Handle new service
if (isset($_POST['new_name'])) {
    $name     = trim($_POST['new_name']);
    $category = trim($_POST['new_category']);
    $price    = trim($_POST['new_price']);
    if ($name && $category && $price) {
        pdo($pdo, "INSERT INTO services (NAME, CATEGORY, PRICE) VALUES (?, ?, ?)",
            [$name, $category, $price]);
    }
}

// Fetch and group by category
$rows = pdo($pdo, "SELECT * FROM services ORDER BY CATEGORY, NAME")->fetchAll();
$grouped = [];
foreach ($rows as $row) {
    $grouped[$row['CATEGORY']][] = $row;
}

$editing = $_GET['edit'] ?? null;
$categories = ['Styling', 'Blonding', 'Coloring', 'Treatment'];
?>

<h2>Services</h2>
<p class="booking-intro">Manage your services below.</p>

<?php foreach ($grouped as $category => $services): ?>
    <fieldset class="booking-form">
        <legend><?= htmlspecialchars($category) ?></legend>

        <?php foreach ($services as $s): ?>
            <?php if ($editing == $s['SERVICE_ID']): ?>
                <!-- Edit mode -->
				<form method="POST">
					<input type="hidden" name="edit_id" value="<?= $s['SERVICE_ID'] ?>">
					<div class="form-field">
						<label>Name</label>
						<input type="text" name="edit_name" value="<?= htmlspecialchars($s['NAME']) ?>">
					</div>
					<div class="form-field">
						<label>Category</label>
						<select name="edit_category">
							<?php foreach ($categories as $cat): ?>
								<option value="<?= $cat ?>" <?= $s['CATEGORY'] === $cat ? 'selected' : '' ?>>
									<?= $cat ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-field">
						<label>Price</label>
						<input type="number" step="0.01" name="edit_price" value="<?= htmlspecialchars($s['PRICE']) ?>">
					</div>
					<div class="form-row">
						<input type="submit" value="Save">
						<a href="?section=services"><input type="button" value="Cancel"></a>
					</div>
				</form>
            <?php else: ?>
                <!-- View mode -->
                <div class="form-row" style="align-items: center;">
                    <div class="form-field">
                        <label><?= htmlspecialchars($s['NAME']) ?></label>
                        <span>$<?= number_format($s['PRICE'], 2) ?>+</span>
                    </div>
                    <div class="form-row">
                        <a href="?section=services&edit=<?= $s['SERVICE_ID'] ?>">
                            <input type="button" value="Edit">
                        </a>
                        <form method="POST">
                            <input type="hidden" name="delete_service" value="<?= $s['SERVICE_ID'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </fieldset>
<?php endforeach; ?>

<fieldset class="booking-form">
    <legend>New Service</legend>
    <form method="POST">

	<div class="form-field">
		<label for="new_name">Name</label>
		<input type="text" id="new_name" name="new_name" placeholder="Service name">
	</div>
	<div class="form-field">
		<label for="new_category">Category</label>
		<select id="new_category" name="new_category">
			<?php foreach ($categories as $cat): ?>
				<option value="<?= $cat ?>"><?= $cat ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-field">
		<label for="new_price">Price</label>
		<input type="number" step="0.01" id="new_price" name="new_price" placeholder="0.00">
	</div>

        <input type="submit" value="Add Service">
    </form>
</fieldset>