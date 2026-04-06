<?php
// Handle delete
if (isset($_POST['delete_announcement'])) {
    pdo($pdo, "DELETE FROM announcements WHERE ANNOUNCEMENT_ID = ?", [$_POST['delete_announcement']]);
}

// Handle edit
if (isset($_POST['edit_id']) && isset($_POST['edit_header']) && isset($_POST['edit_message'])) {
    $header  = trim($_POST['edit_header']);
    $message = trim($_POST['edit_message']);
    if ($header && $message) {
        pdo($pdo, "UPDATE announcements SET HEADER = ?, MESSAGE = ? WHERE ANNOUNCEMENT_ID = ?", 
            [$header, $message, $_POST['edit_id']]);
    }
}

// Handle new announcement
if (isset($_POST['new_header']) && isset($_POST['new_message'])) {
    $header  = trim($_POST['new_header']);
    $message = trim($_POST['new_message']);
    $date    = date('n/j/Y');
    if ($header && $message) {
        pdo($pdo, "INSERT INTO announcements (HEADER, MESSAGE, DATE) VALUES (?, ?, ?)", [$header, $message, $date]);
    }
}

// Fetch announcements
$announcements = pdo($pdo, "SELECT * FROM announcements ORDER BY ANNOUNCEMENT_ID DESC")->fetchAll();

// Which announcement is being edited?
$editing = $_GET['edit'] ?? null;
?>

<h2>Announcements</h2>
<p class="booking-intro">Manage current announcements below.</p>

<fieldset class="booking-form">
    <legend>Current Announcements</legend>
    <?php if (empty($announcements)): ?>
        <p class="booking-intro">No announcements yet.</p>
    <?php else: ?>
        <?php foreach ($announcements as $a): ?>
            <div class="form-row" style="align-items: center;">

                <?php if ($editing == $a['ANNOUNCEMENT_ID']): ?>
                    <!-- Edit mode -->
                    <form method="POST">
                        <input type="hidden" name="edit_id" value="<?= $a['ANNOUNCEMENT_ID'] ?>">
                        <div class="form-field">
                            <label>Header</label>
                            <input type="text" name="edit_header" value="<?= htmlspecialchars($a['HEADER']) ?>">
                        </div>
                        <div class="form-field">
                            <label>Message</label>
                            <textarea name="edit_message"><?= htmlspecialchars($a['MESSAGE']) ?></textarea>
                        </div>
                        <div class="form-row">
                            <input type="submit" value="Save">
                            <a href="?section=announcements"><input type="button" value="Cancel"></a>
                        </div>
                    </form>
                <?php else: ?>
                    <!-- View mode -->
                    <div class="form-field">
                        <label><?= htmlspecialchars($a['DATE']) ?></label>
                        <strong><?= htmlspecialchars($a['HEADER']) ?></strong>
                        <p><?= htmlspecialchars($a['MESSAGE']) ?></p>
                    </div>
                    <div class="form-row">
                        <a href="?section=announcements&edit=<?= $a['ANNOUNCEMENT_ID'] ?>">
                            <input type="button" value="Edit">
                        </a>
                        <form method="POST">
                            <input type="hidden" name="delete_announcement" value="<?= $a['ANNOUNCEMENT_ID'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </div>
                <?php endif; ?>

            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</fieldset>

<fieldset class="booking-form">
    <legend>New Announcement</legend>
    <form method="POST">
        <div class="form-row">
            <div class="form-field">
                <label for="new_header">Header</label>
                <input type="text" id="new_header" name="new_header" placeholder="Announcement title">
            </div>
        </div>
        <div class="form-row">
            <div class="form-field">
                <label for="new_message">Message</label>
                <textarea id="new_message" name="new_message" placeholder="Announcement body…"></textarea>
            </div>
        </div>
        <input type="submit" value="Post Announcement">
    </form>
</fieldset>