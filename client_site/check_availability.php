<?php
/**
//Mathew Boullier
//Made 5/6/2026
//This is used to check the availabity of a date for booking.
Called via fetch() from booking.php
 */
session_start();
require_once 'require/databaseConnection.php';
header('Content-Type: application/json');

$SLOT_DURATION_HOURS = 2;

// --- 1. Validate input ---
$date = trim($_GET['date'] ?? '');
if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode(['open' => false, 'message' => 'Invalid date.', 'slots' => []]);
    exit;
}

// Disallow today or past dates
if ($date <= date('Y-m-d')) {
    echo json_encode(['open' => false, 'message' => 'Please choose a future date.', 'slots' => []]);
    exit;
}

// --- 2. Get day of week (Monday, Tuesday, etc.) ---
$dayOfWeek = date('l', strtotime($date)); // e.g. "Monday"

// --- 3. Check operation_hours ---
$hours = pdo($pdo, "SELECT * FROM operation_hours WHERE DAY = ?", [$dayOfWeek])->fetch();

if (!$hours || $hours['OPEN?'] != 1) {
    echo json_encode([
        'open'    => false,
        'message' => "Sorry, we're closed on {$dayOfWeek}s. Please choose another day.",
        'slots'   => []
    ]);
    exit;
}

// --- 4. Parse open/close times ---
// OPEN_TIME / CLOSE_TIME stored as strings
$openTime  = strtotime($hours['OPEN_TIME']);
$closeTime = strtotime($hours['CLOSE_TIME']);

if (!$openTime || !$closeTime) {
    echo json_encode(['open' => false, 'message' => 'Could not read business hours.', 'slots' => []]);
    exit;
}

// Build all possible 2-hour slots for the day
$allSlots = [];
$cursor   = $openTime;
while (($cursor + $SLOT_DURATION_HOURS * 3600) <= $closeTime) {
    $allSlots[] = $cursor;
    $cursor += $SLOT_DURATION_HOURS * 3600;
}

// --- 5. Find booked slots for this date ---
// Pull every order that has an APPT_DATE on this calendar day
$booked = pdo($pdo,
    "SELECT appt_date FROM orders
     WHERE DATE(appt_date) = ? AND ORDER_STATUS != 'cancelled'",
    [$date]
)->fetchAll();

$bookedTimes = [];
foreach ($booked as $row) {
    // Extract just the time portion and convert to a Unix timestamp for comparison
    $bookedTimes[] = strtotime(date('H:i', strtotime($row['appt_date'])));
}

// --- 6. Filter out slots that overlap with a booked appointment ---
// A booked appointment at time T blocks [T, T + 2hrs).
// A candidate slot at time S is blocked if any booked T satisfies:
//   S < T + 2hrs  AND  T < S + 2hrs  (overlap condition)
$availableSlots = [];
foreach ($allSlots as $slot) {
    $blocked = false;
    foreach ($bookedTimes as $booked_t) {
        if ($slot < ($booked_t + $SLOT_DURATION_HOURS * 3600) &&
            $booked_t < ($slot + $SLOT_DURATION_HOURS * 3600)) {
            $blocked = true;
            break;
        }
    }
    if (!$blocked) {
        // Format as "10:00 AM" for display and hidden input
        $availableSlots[] = date('g:i A', $slot);
    }
}

// --- 7. Return ---
echo json_encode([
    'open'    => true,
    'message' => '',
    'slots'   => $availableSlots
]);