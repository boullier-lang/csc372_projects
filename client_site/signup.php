<?php
/*
<!-- Mathew Boullier -->
4/3/2026
The signup page. Not much to talk about; validates emails, makes sure we enter stuff. The usual.
Once we are sure the user is ready to be inserted, we do so and log them in.
*/
	session_start();
    $pageTitle = 'Golden Mane Salon — Staff';
	$pageStyles = ['fields.css'];
    require_once 'partials/header.php';
    require_once 'partials/navbar.php';
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$name = trim($_POST['name']);
		$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
		$password = $_POST['password'];

		if (!$name || !$email || !$password) {
			$error = "All fields are required.";
		}
		else if(strlen($password) < 5)
		{
			$error="Passwords must be longer than 5 characters.";
		}
		else {
			//Check: Does our email exist in the database?
			$sql="SELECT * FROM `accounts` WHERE EMAIL=?";
			if(pdo($pdo,$sql,[$email])->fetch())
			{
				$error="That email is used in an existing account.";
			}
			else{
				$hashedPassword=password_hash($_POST['password'], PASSWORD_DEFAULT);
			
				$sql = "INSERT INTO `accounts` (`NAME`, `EMAIL`, `PASSWORD`) VALUES (?,?,?)";
				pdo($pdo, $sql, [$name,$email,$hashedPassword]);
				
				$_SESSION['logged_in'] = true;
				$_SESSION['user_id'] = $pdo->lastInsertId();
				$_SESSION['rank'] = 0;
				echo "<meta http-equiv='refresh' content='0;url=home_page.php'>";
				exit();
			}
			
			

		}
	}
	
	
?>


<div id='main'>
    <div id="left">
        <h2>Sign Up</h2>

		<?php if (!empty($error)): ?>
			<p style="color: red;"><?= $error ?></p>
		<?php endif; ?>
		
		<form action="signup.php" method="POST">
			<div class="form-field">
				<label for="username">Name</label>
				<input type="text" id="name" name="name" placeholder="Enter your name">
			</div>
			
			<div class="form-field">
				<label for="email">Email</label>
				<input type="text" id="email" name="email" placeholder="Enter your email">
			</div>
			<em> Please note: order receipts will be sent to this email. Please make sure it is correct. </em>
			
			<div class='form-field'>
				<label for="password">Password</label>
				<input type="password" id="password" name="password" placeholder="Enter your password">
			</div>
			
			<input type="submit" value="Signup">
		</form>
		
		<p> Have an account? <em><a href="login.php"> Login!</a></em></p>
		
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>