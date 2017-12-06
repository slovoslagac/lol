<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


if ($session->isLoggedIn()) {
    redirectTo("kasa.php");
}

if (isset($_POST["submit"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $worker = new worker();
    $currworker = $worker->getWorkerByEmail($username);

    if ($currworker) {
        if (password_verify($password, $currworker->password)) {
            $session->login($currworker);
            $session->setSessionTime();
            unset($password, $currworker, $username);
            redirectTo("kasa.php");

        } else {
            logAction("Neuspelo logovanje - pogresna lozinka", "user:$username, pass :$password, realpass : $currworker->password, $currworker->name", "error.txt");
        }

    } else {
        logAction("Neuspelo logovanje - ne postoji radnik sa tim username.", "user:$username, pass :$password, ", "error.txt");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>eSports Arena</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>




<div class="account-container">

    <div class="content clearfix">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="good_form">

            <h1>Member Login</h1>

            <div class="login-fields">

                <p>Molimo vas da unesete vaše podatke</p>

                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="" placeholder="Vaš e-mail"
                           class="login username-field" autofocus/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="" placeholder="Lozinka"
                           class="login password-field"/>
                </div> <!-- /password -->

            </div> <!-- /login-fields -->

            <div class="login-actions">


                <button class="button btn btn-success btn-large" name="submit">Uloguj se</button>

            </div> <!-- .actions -->


        </form>

    </div> <!-- /content -->

</div> <!-- /account-container -->


<div class="login-extra">
    Nemaš nalog? <a href="signup.php">Kreiraj novi...</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
