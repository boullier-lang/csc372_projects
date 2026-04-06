<?php
/*
<!--Mathew boullier-->
<!-- made 3/24/26 -->
<!-- book.php, basics for booking -->

Updated 4/4/2026
No longer requires name and email, and phone number is optional. Uses information from the user logged in and stores that.
Also now pushes orders to the database.
*/	

	session_start();
    $pageTitle  = 'Golden Mane Salon — Booking';
    $pageScript = 'booking.js';
    $pageStyles = ['fields.css'];
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
	
	if (!isset($_SESSION['user_id'])) {
        header('Location: login.php?redirect=booking.php');
        exit;
    }
    $user = pdo($pdo, "SELECT NAME, EMAIL FROM accounts WHERE USER_ID = ?", [$_SESSION['user_id']])->fetch();
    $user_name  = $user['NAME'];
    $user_email = $user['EMAIL'];

    $saved_phone = isset($_COOKIE['booking_phone']) ? htmlspecialchars($_COOKIE['booking_phone']) : '';

    $confirmation = "";

	if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['appt_date'])) {
		$name      = $user_name;
		$email     = $user_email;
		$phone     = htmlspecialchars(trim($_GET['phone'] ?? ''));
		$appt_date = htmlspecialchars(trim($_GET['appt_date']));
		$notes     = htmlspecialchars(trim($_GET['notes']));

		if (!empty($phone)) {
			setcookie('booking_phone', $phone, time() + 60 * 60 * 24 * 365, '/');
			$saved_phone = $phone;
		}

		$time_pref    = htmlspecialchars($_GET['time_pref'] ?? 'No preference');
		$services_raw = $_GET['services'] ?? [];

		// Look up each selected service by name to get its ID and price
		$service_items = [];
		$total = 0;

		foreach ($services_raw as $service_name) {
			$svc = pdo($pdo, "SELECT SERVICE_ID, NAME, PRICE FROM services WHERE NAME = ?", [htmlspecialchars($service_name)])->fetch();
			if ($svc) {
				$service_items[] = $svc;
				$total += $svc['PRICE'];
			}
		}

		$service_list = !empty($service_items)
			? implode(', ', array_column($service_items, 'NAME'))
			: 'Not specified';

		if (!empty($service_items)) {
			// Step 1: Insert the order
			pdo($pdo, "INSERT INTO orders (USER_ID, ORDER_STATUS, TOTAL) VALUES (?, 'pending', ?)",
				[$_SESSION['user_id'], $total]);

			$order_id = $pdo->lastInsertId();

			// Step 2: Insert each order item
			foreach ($service_items as $svc) {
				pdo($pdo, "INSERT INTO order_items (ORDER_ID, SERVICE_ID, PRICE_CHARGED) VALUES (?, ?, ?)",
					[$order_id, $svc['SERVICE_ID'], $svc['PRICE']]);
			}
		}

		$confirmation = "
			<div class='booking-confirm'>
				✓ Thank you, <strong>{$name}</strong>!
				Your request for <strong>{$service_list}</strong> on
				<strong>{$appt_date}</strong> ({$time_pref}) has been received.
				We'll follow up at {$email} within 24 hours.
			</div>";
	}

    $allServices = pdo($pdo, "SELECT * FROM services")->fetchAll();
?>

<div id="main">
    <div id="left">
        <?php require_once "partials/sidebar.php" ?>
    </div>
    <div id="right">
        <h1>Booking</h1>

        <?php echo $confirmation; ?>

        <form action="booking.php" method="GET" class="booking-form">

            <fieldset>
                <legend>Your Details</legend>
                <p>Booking as <strong><?= htmlspecialchars($user_name) ?></strong> (<?= htmlspecialchars($user_email) ?>)</p>
                <div class="form-row">
                    <div class="form-field">
                        <label for="phone">Phone Number <span style="font-weight: 400; color: #888;">(optional)</span></label>
                        <input type="tel" id="phone" name="phone"
                               placeholder="(401) 555-0000"
                               value="<?= $saved_phone ?>">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Appointment Details</legend>

                <div class="form-row">
                    <div class="form-field">
                        <label for="appt_date">Preferred Date</label>
                        <input type="date" id="appt_date" name="appt_date" required>
                    </div>
                </div>

                <div class="form-field">
                    <label>Services</label>
                    <div id="service-rows">
                        <div class="service-row">
                            <select name="services[]" class="service-select" onchange="updateTotal()">
                                <option value="" data-price="0" disabled selected>Choose a service…</option>
                                <?php foreach ($allServices as $svc): ?>
                                    <option value="<?= htmlspecialchars($svc['NAME']) ?>"
                                            data-price="<?= htmlspecialchars($svc['PRICE']) ?>">
                                        <?= htmlspecialchars($svc['NAME']) ?> — $<?= number_format($svc['PRICE'], 2) ?>+
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="booking-row-dismiss" onclick="removeServiceRow(this)" style="display:none">✕</button>
                        </div>
                    </div>

                    <button type="button" onclick="addServiceRow()">+ Add another service</button>

                    <div id="price-summary" style="display:none" class="price-summary">
                        Projected total: <strong id="price-total">$0</strong>
                        <span class="price-note">(subject to consultation)</span>
                    </div>
                </div>

                <div class="form-field">
                    <label>Preferred Time of Day</label>
                    <div class="radio-group">
                        <label><input type="radio" name="time_pref" value="Morning"> Morning</label>
                        <label><input type="radio" name="time_pref" value="Midday"> Midday</label>
                        <label><input type="radio" name="time_pref" value="Afternoon"> Afternoon</label>
                        <label><input type="radio" name="time_pref" value="No preference" checked> No Preference</label>
                    </div>
                </div>

                <div class="form-field">
                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes" placeholder="Allergies, hair history, special requests…"></textarea>
                </div>
            </fieldset>

            <button type="submit">Request Appointment</button>
			
			<p> <strong> Notice: </strong> I accept cash, card, and apple pay during appointments, but a debit card must be on file
				to hold your appointment. </p>

        </form>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>