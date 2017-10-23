<!DOCTYPE html>
<html lang="en">

<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));

if ($session->isLoggedIn()) {
redirectTo("kasa.php");
}

if (isset($_POST["submit"])) {
$username = strtolower(trim($_POST["username"]));
$password = strtolower(trim($_POST["password"]));

$worker = new worker();
$currworker = $worker->getWorkerByUsername($username);

print_r($currworker);
echo "<br>";
print_r($session);
echo "<br>";

if ($currworker) {
//        if (strtolower($currworker->password) == strtolower($password)) {
//            echo "Sve je u redu";
$session->login($currworker);
print_r($session);
//            $session
//            if($session->isLoggedIn() == true) {echo "To je to";} else { echo "Opet je false";};
unset($password, $currworker, $username);
redirectTo("kasa.php");
//
//        } else {
//            echo "lozinka je pogresna pokusajte ponovo";
//        } else {
//        echo " za usera $username pogresna je lozinka";
//        }
//    } else {
//        echo "user $username ne postoji u bazi";
//         $session->log_out();
}
}


?>
<head>
    <meta charset="utf-8">
    <title>eSports Arena</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="index.php">
				eSports Arena				
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->



<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		
			<h1>Member Login</h1>		
			
			<div class="login-fields">
				
				<p>Molimo vas da unesete vaše podatke</p>
				
				<div class="field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="" placeholder="Korisničko ime" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Lozinka" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
			
									
				<button class="button btn btn-success btn-large" name="submit">Uloguj se</button>
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<div class="login-extra">
	<a href="#">Reset Password</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
