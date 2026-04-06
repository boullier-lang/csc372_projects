<?php
/*
Mathew Boullier
4/3/2026
Used to log the user in. Authenticates from the database, ensures they are actually apart of the database,
and logs them in using sessions.
*/
	session_start();
    $pageTitle = 'Golden Mane Salon — Staff';
	$pageStyles = ['fields.css'];
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
		$password = $_POST['password'];
		
		//Step 1: Get the attempted user from the database
		$sql = "SELECT * FROM `accounts` WHERE `EMAIL`=?";
		$attemptedUser=pdo($pdo,$sql,[$email])->fetch();
		//Step 2: Check, is user living in there already?
		if(!$attemptedUser)
		{
			$error="That email is not linked to any accounts. Sorry!";
		}
		//Step 2: Verify password
		else if(password_verify($password, $attemptedUser['PASSWORD']))
		{
			//Step 3: Login
			$_SESSION['logged_in'] = true;
			$_SESSION['user_id'] = $attemptedUser["USER_ID"];
			$_SESSION['rank'] = 0;
			echo "<meta http-equiv='refresh' content='0;url=home_page.php'>";
			exit();
		}
		else{
			//If we made it this far, the password is wrong.
			$error="Incorrect password.";
		}
	}
	
?>


<div id='main'>
    <div id="left">
        <h2>Login</h2>
		
		<?php if (!empty($error)): ?>
			<p style="color: red;"><?= $error ?></p>
		<?php endif; ?>
		
		<form action="login.php" method="POST">
			<div class="form-field">
				<label for="email">Email</label>
				<input type="text" id="email" name="email" placeholder="Enter your email">
			</div>
			
			<div class='form-field'>
				<label for="password">Password</label>
				<input type="password" id="password" name="password" placeholder="Enter your password">
			</div>
			
			<input type="submit" value="Login">
		</form>
		
		<p> Don't have an account? <em><a href="signup.php"> Sign Up now!</a></em></p>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>