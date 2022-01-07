<?php 
session_start();

if(!isset($_SESSION) || $_SESSION['loggedin']==false){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>ENTERED!</h1>
</body>
</html>