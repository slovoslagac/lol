<?php
include(join(DIRECTORY_SEPARATOR, array('..', '..', 'includes', 'init.php')));
if (!$session->isLoggedIn()){
    redirectTo("login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin login</title>
</head>
<body>
<h1>Radnik</h1>


</body>

</html>
