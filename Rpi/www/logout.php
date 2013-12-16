<?php
//logout.php
session_start();
session_unset();
session_destroy();

header("Location: index.php");

?>



<!DOCTYPE html>
<html>
<head>
</head>
<body>

<h1>logging out...</h1>

</body>
</html>

