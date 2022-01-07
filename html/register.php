<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
		
<script type="text/javascript" src="../js/register_validation.js"></script> 
<link rel="stylesheet" href="..\css\register.css">
<!------ Include the above in your HEAD tag ---------->
</head>

<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
        <h1>Create Account</h1>
    </div>

    <!-- Login Form -->
    <form action="register.php" method="post" id="registerForm">
      <input type="hidden" name="register" value="yes"/>
      <input type="email" id="email" class="fadeIn second" name="email" placeholder="Email">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
      <input type="password" id="confirm_password" class="fadeIn third" name="login" placeholder="Confirm Password">
      <input type="submit" class="fadeIn fourth" value="Register" id="register_button">

    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="index.php">LogIn</a>
    </div>
  </div>
</div>
<?php
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);  
if ($conn->connect_error) echo($conn->connect_error); 

if(isset($_POST['register']) && isset($_POST['email']) && isset($_POST['password']))
{
  
  $email=$_POST['email'];
  $password=$_POST['password'];
  $salt=generate_salt();
  $password=hash('ripemd128',$password.$salt);
  $stmt=$conn->prepare("INSERT INTO users(email,password,salt) VALUES(?,?,?)");
  $stmt->bind_param("sss",$email,$password,$salt);
  if(!$stmt->execute())die("INSERT FAILED".$conn->error);
  header("location:index.php");
  exit;
}



$conn->close();

function generate_salt(){
  return bin2hex(random_bytes(8));
}
?>


<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
</body>
</html>