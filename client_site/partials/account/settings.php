<?php 
/*
Mathew Boullier
Shows our account settings, such as name, email, password, and access to change these settings.
*/
if(!isset($_SESSION['user_id']))
{
	exit;
}
	$user_id_sql="SELECT NAME, EMAIL FROM accounts WHERE USER_ID = ?";
	$user = pdo($pdo,$user_id_sql,[$_SESSION['user_id']])->fetch();
	
	
	
	
	
	
	
?>

<h2>Account Settings</h2>
<p class="booking-intro">Manage your account details below.</p>

<fieldset class="booking-form">
    <legend>Personal Information</legend>

    <div class="form-row">
        <div class="form-field">
            <label>Name</label>
            <input type="text" id="name-input" value="<?= $user['NAME'] ?>" disabled>
        </div>
        <input type="submit" value="Change Name" id="name-btn">
    </div>

    <div class="form-row">
        <div class="form-field">
            <label>Email</label>
            <input type="text" id="email-input" value="<?= $user['EMAIL'] ?>" disabled>
        </div>
        <input type="submit" value="Change Email" id="email-btn">
    </div>

    <div class="form-row">
        <div class="form-field">
            <label>Password</label>
            <input type="password" id="password-input" value="12345678" disabled>
        </div>
        <input type="submit" value="Change Password" id="password-btn">
    </div>
</fieldset>

<fieldset class="booking-form">
    <legend>DANGER!!!!!!!</legend>
    <p class="booking-intro">Deleting your account is permanent and cannot be undone.</p>
    <input type="submit" id='delete-btn' value="Delete Account">
</fieldset>