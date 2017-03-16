<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 16.3.2017
 * Time: 9:42
 */
include(join(DIRECTORY_SEPARATOR, array('..', '..', 'includes', 'init.php')));

if ($session->isLoggedIn()){
    redirectTo("index.php");
}

if (isset($_POST["submit"])){
    $username = strtolower(trim($_POST["username"]));
    $password = strtolower(trim($_POST["password"]));

    $user = new user();
    $currentuser = $user->getUserByUsername($username);
    if ($currentuser != '') {
        if (strtolower($currentuser->password) == $password ){
            $session->log_in();
        }
//        echo "user $username postoji u bazi";
    } else {
        echo "user $username ne postoji u bazi";
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
