<?php
/*
<!--Mathew boullier-->
<!-- made 3/24/26 -->
<!-- book.php, basics for booking -->

Updated 4/4/2026
No longer requires name and email, and phone number is optional. Uses information from the user logged in and stores that.
Also now pushes orders to the database.

Updated 5/6/2026
Now has better date selection, and two hour long appointment windows. Saves the date to the database as well.
*/	
    session_start();
    $pageTitle  = 'Golden Mane Salon — Booking';
    $pageScript = 'booking.js';
    $pageStyles = ['fields.css'];
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';

    if (!isset($_SESSION['user_id'])) {
        echo "<meta http-equiv='refresh' content='0;url=login.php'>";
        exit;
    }
    $user = pdo($pdo, "SELECT NAME, EMAIL FROM accounts WHERE USER_ID = ?", [$_SESSION['user_id']])->fetch();
    $user_name  = $user['NAME'];
    $user_email = $user['EMAIL'];

    $saved_phone = isset($_COOKIE['booking_phone']) ? htmlspecialchars($_COOKIE['booking_phone']) : '';

    $confirmation = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['appt_date'])) {

    $errors = [];

    $services_raw = $_GET['services'] ?? [];
    $services_raw = array_filter($services_raw, fn($s) => $s !== '');

    if (empty($services_raw)) {
        $errors[] = 'Please select at least one service.';
    }

    if (empty(trim($_GET['appt_date'] ?? ''))) {
        $errors[] = 'Please select a date.';
    }

    if (empty(trim($_GET['appt_time'] ?? ''))) {
        $errors[] = 'Please select a time slot.';
    }

    if (!empty($errors)) {
		//Joins all errors together with <br> (using implode), then displays them on the screen.
		$confirmation = "<div class='booking-error'>"
			. implode('<br>', array_map(fn($e) => "<span>{$e}</span>", $errors))
			. "</div>";
    } else {
        $name      = $user_name;
        $email     = $user_email;
        $phone     = htmlspecialchars(trim($_GET['phone'] ?? ''));
        $appt_date = htmlspecialchars(trim($_GET['appt_date']));
        $appt_time = htmlspecialchars(trim($_GET['appt_time']));
        $notes     = htmlspecialchars(trim($_GET['notes'] ?? ''));

        $appt_datetime = date('Y-m-d H:i:s', strtotime("$appt_date $appt_time"));

        if (!empty($phone)) {
            setcookie('booking_phone', $phone, time() + 60 * 60 * 24 * 365, '/');
            $saved_phone = $phone;
        }

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

        pdo($pdo, "INSERT INTO orders (USER_ID, ORDER_STATUS, TOTAL, APPT_DATE) VALUES (?, 'pending', ?, ?)",
            [$_SESSION['user_id'], $total, $appt_datetime]);

        $order_id = $pdo->lastInsertId();

        foreach ($service_items as $svc) {
            pdo($pdo, "INSERT INTO order_items (ORDER_ID, SERVICE_ID, PRICE_CHARGED) VALUES (?, ?, ?)",
                [$order_id, $svc['SERVICE_ID'], $svc['PRICE']]);
        }
		
		//Makes the date more user friendly to look at
        $display_dt = date('l, F j, Y \a\t g:i A', strtotime($appt_datetime));

        $confirmation = "
            <div class='booking-confirm'>
                ✓ Thank you, <strong>{$name}</strong>!
                Your request for <strong>{$service_list}</strong> on
                <strong>{$display_dt}</strong> has been received.
                We'll follow up at {$email} within 24 hours.
            </div>";
    }
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

        <form action="booking.php" method="GET" class="booking-form" id="booking-form">

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

                <!-- Step 1: Date picker -->
                <div class="form-field">
                    <label for="appt_date_pick">Select a Date</label>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <input type="date" id="appt_date_pick"
                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                               style="max-width: 220px;">
                        <button type="button" id="check-date-btn">Check Availability</button>
                    </div>
                    <p id="date-error"></p>
                </div>

                <!-- Step 2: Time slots, revealed after a valid date is confirmed -->
                <div class="form-field" id="time-slot-section" style="display:none;">
                    <label>Available Time Slots</label>
                    <div id="time-slots-grid"></div>
                    <input type="hidden" name="appt_date" id="appt_date_hidden">
                    <input type="hidden" name="appt_time"  id="appt_time_hidden">
                    <p id="slot-error"></p>
                </div>

                <div class="form-field">
                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes"
                        placeholder="Allergies, hair history, special requests…"></textarea>
                </div>
            </fieldset>

            <button type="submit">Request Appointment</button>

            <p><strong>Notice:</strong> I accept cash, card, and Apple Pay during appointments, but a debit card must be on file
                to hold your appointment.</p>

        </form>
    </div>
</div>



<?php require_once 'partials/footer.php'; ?>