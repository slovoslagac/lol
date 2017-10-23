<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 16.3.2017
 * Time: 9:42
 */
include(join(DIRECTORY_SEPARATOR, array('..', '..', 'includes', 'init.php')));

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
//    echo "$password<br>";

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
<!DOCTYPE html>
<html>
<head>
    <title>Admin login</title>
</head>
<body>
<h1>Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="username">Username</label>
    <input id="username" name="username" type="text">
    <br>
    <label for="password">Password</label>
    <input id="password" name="password" type="password">
    <br>
    <input type="submit" name="submit" id="submit" value="Login">
</form>

</body>

</html>
