<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));



if(isset($_POST["registration"])){
    $name = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confpassword = $_POST["confirm_password"];
    $wrk = new  worker();
    $crypt_password = crypt($password);
    if ($wrk->getWorkerByEmail($email) == '') {
        if ($password == $confpassword) {
            $typeObject = $wrk->getOperator(); $type = $typeObject->id;
            $wrk->addWorker($name, $lastname, $email, $crypt_password, $type);
            unset($wrk);
            redirectTo("login.php");
        } else {
            echo "Registracija nije uspela, molimo pokušajte ponovo!";
        }
    } else {
        echo "Izabrani mail je vec u upotrebi";
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
                    <li class="">
                        <a href="login.php" class="">
                            Već imaš nalog? Uloguj se...
                        </a>

                    </li>
                    <li class="">
                        <a href="index.php" class="">
                            <i class="icon-chevron-left"></i>
                            Povratak na početnu stranu
                        </a>

                    </li>
                </ul>

            </div><!--/.nav-collapse -->

        </div> <!-- /container -->

    </div> <!-- /navbar-inner -->

</div> <!-- /navbar -->


<div class="account-container register">

    <div class="content clearfix">

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

            <h1>Registracija</h1>

            <div class="login-fields">

                <p>Obavezno popuniti sva polja:</p>

                <div class="field">
                    <label for="firstname">Ime:</label>
                    <input type="text" id="firstname" name="firstname" value="" placeholder="Ime" class="login"/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="lastname">Prezime:</label>
                    <input type="text" id="lastname" name="lastname" value="" placeholder="Prezime" class="login"/>
                </div> <!-- /field -->


                <div class="field">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="" placeholder="E-mail" class="login" required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Lozinka:</label>
                    <input type="password" id="password" name="password" value="" placeholder="Lozinka" class="login" required/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="confirm_password">Potvrda lozinke:</label>
                    <input type="password" id="confirm_password" name="confirm_password" value="" placeholder="Potvrda lozinke" class="login" oninput="check(this)"/>
                </div> <!-- /field -->


            </div> <!-- /login-fields -->

            <div class="login-actions">


                <button class="button btn btn-primary btn-large" name="registration" type="submit">Registruj se</button>

            </div> <!-- .actions -->

        </form>

    </div> <!-- /content -->

</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">
    Već imaš nalog? <a href="login.php">Uloguj se...</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

<script language='javascript' type='text/javascript'>
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Niste uneli iste lozinke');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }
</script>

</body>

</html>
