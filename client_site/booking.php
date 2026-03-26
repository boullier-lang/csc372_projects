<!--Mathew boullier-->
<!-- made 3/24/26 -->
<!-- book.php, basics for booking -->

<?php
    $pageTitle = 'Golden Mane Salon — Booking';
	$pageScript = 'booking.js';
	$pageStyles = ['booking.css'];
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
	require_once __DIR__ . '/require/ServiceCategory.php';
	
	$json = file_get_contents('data/services.json');
    $data = json_decode($json, true);
    $categories = array_map(
        fn($cat) => new ServiceCategory($cat['category'], $cat['items']),
        $data['services']
    );
 
	$confirmation="";
 
     //Process form submission.
 if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['name'])) {

    $name       = htmlspecialchars(trim($_GET['name']));
    $email      = htmlspecialchars(trim($_GET['email']));
    $phone      = htmlspecialchars(trim($_GET['phone']));
    $appt_date  = htmlspecialchars(trim($_GET['appt_date']));
    $notes      = htmlspecialchars(trim($_GET['notes']));

    $services_raw = $_GET['services'] ?? [];
    $services     = array_map('htmlspecialchars', $services_raw);
    $service_list = !empty($services) ? implode(', ', $services) : 'Not specified';

    $time_pref = htmlspecialchars($_GET['time_pref'] ?? 'No preference');

    $confirmation = "
            <div class='booking-confirm'>
                ✓ Thank you, <strong>{$name}</strong>!
                Your request for <strong>{$service_list}</strong> on
                <strong>{$appt_date}</strong> ({$time_pref}) has been received.
                We'll follow up at {$email} within 24 hours.
            </div>
        ";
}
 
 
 
	//Flattens the categories map into one long array.
    $allServices = [];
    foreach ($categories as $cat) {
        foreach ($cat->getItems() as $item) {
            $allServices[] = [
                'name'  => html_entity_decode($item->getName()),
                'price' => html_entity_decode($item->getPrice()),
            ];
        }
    }
	
	
?>

<div id="main">
    <!-- LEFT SIDE -->
    <div id="left">
		<?php require_once "partials/sidebar.php"?>
    </div>
    <!-- RIGHT SIDE -->
		<div id="right">
			<h1>Booking</h1>
			
			  <?php echo $confirmation; ?>
			
			<form action="booking.php" method="GET" class="booking-form">
	 
				<fieldset>
					<legend>Your Details</legend>
	 
					<div class="form-row">
						<div class="form-field">
							<label for="name">Full Name</label>
							<input type="text" id="name" name="name"
								   placeholder="Jane Smith" required>
						</div>
	 
					<div class="form-field">
							<label for="email">Email Address</label>
					
							<input type="email" id="email" name="email"
								   placeholder="jane@example.com" required>
					</div>
	 
					<div class="form-row">
						<div class="form-field">
							<label for="phone">Phone Number</label>

							<input type="tel" id="phone" name="phone" 
								placeholder="(401) 555-0000" required>
						</div>
	 
					</div>
				</fieldset>
	 
				<fieldset>
					<legend>Appointment Details</legend>
	 

				<div class="form-row">
                    <div class="form-field" style="flex:1">
                        <label for="appt_date">Preferred Date</label>
                        <input type="date" id="appt_date" name="appt_date" required>
                    </div>
                </div>


                <div class="form-field">
				
				
                    <label>Services</label>
 
                    <div id="service-rows">
                        <!-- First row rendered by PHP; JS clones it for extras -->
                        <div class="service-row">
                            <select name="services[]" class="service-select" onchange="updateTotal()">
                                <option value="" data-price="0" disabled selected>Choose a service…</option>
                                <?php foreach ($allServices as $svc): ?>
                                    <option value="<?= htmlspecialchars($svc['name']) ?>"
                                            data-price="<?= htmlspecialchars($svc['price']) ?>">
                                        <?= htmlspecialchars($svc['name']) ?> — <?= htmlspecialchars($svc['price']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Remove button hidden on the first row -->
                            <button type="button" class="booking-row-dismiss" onclick="removeServiceRow(this)" style="display:none">✕</button>
                        </div>
                    </div>
 
                    <button type="button" onclick="addServiceRow()">+ Add another service</button>
 
                    <!-- Projected price summary -->
                    <div id="price-summary" style="display:none" class="price-summary">
                        Projected total: <strong id="price-total">$0</strong>
                        <span class="price-note">(subject to consultation)</span>
                    </div>
                </div>
 

                <div class="form-field">
                    <label>Preferred Time of Day</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="time_pref" value="Morning">
                            Morning
                        </label>
                        <label>
                            <input type="radio" name="time_pref" value="Midday">
                            Midday
                        </label>
                        <label>
                            <input type="radio" name="time_pref" value="Afternoon">
                            Afternoon
                        </label>
                        <label>
                            <input type="radio" name="time_pref" value="No preference" checked>
                            No Preference
                        </label>
                    </div>
                </div>
 
                <div class="form-field">
                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes"
                              placeholder="Allergies, hair history, special requests…"></textarea>
                </div>
            </fieldset>
 
            <button type="submit">Request Appointment</button>
 
        </form>
		</div>
</div>

<?php require_once 'partials/footer.php'; ?>