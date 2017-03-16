<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 16.3.2017
 * Time: 9:42
 */
include(join(DIRECTORY_SEPARATOR, array('..', '..', 'includes', 'init.php')));

print_r($session);

if (!$session->isLoggedIn()){
    redirectTo("login.php");
}

if(isset($_POST["logout"])){
    echo "Izlogovali smo se <br>";
    $session->logout();
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin index</title>
</head>


<body>
<h1>Index</h1>
<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
<input type="submit" name="logout" value="LogOut">


</form>
<p><a href="login.php" >Skoci na radnika</a></p>

</body>


</html>
