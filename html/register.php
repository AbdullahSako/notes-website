<?php
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);  
if ($conn->connect_error) echo($conn->connect_error); 
$errorEnabled=false;
if(isset($_POST['register']) && isset($_POST['email']) && isset($_POST['password']))
{
  $email=$_POST['email'];
  $password=$_POST['password'];
  //check if email is already registered
  $stmt=$conn->prepare("select email from users where email=?");
  $stmt->bind_param("s",$email);
  if(!$stmt->execute())die("select FAILED".$stmt->error);
  $row=$stmt->get_result();

  if($row->num_rows==0){
    //insert email, hashed password and salt
    $salt=generate_salt();
    $password=hash('ripemd128',$password.$salt);
    $stmt=$conn->prepare("INSERT INTO users(email,password,salt) VALUES(?,?,?)");
    $stmt->bind_param("sss",$email,$password,$salt);
    if(!$stmt->execute())die("INSERT FAILED".$conn->error);
    $row->close();
    header("location:index.php",true,301);
    exit;
  }
  else{
    $row->close();
    $errorEnabled=true;
  }
}
$conn->close();
function generate_salt(){
  //creates random string characters for salt
  return bin2hex(random_bytes(8));
}
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../js/theme.js"></script> 
<script type="text/javascript" src="../js/register_validation.js"></script> 
<link rel="stylesheet" href="..\css\register_dark.css">
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
      <h5 id="error">Email already exists</h5>
    </form>
    <?php
      if($errorEnabled==true){
        //show 'email already exists' error message
        echo("<script>$('#error').css('visibility','visible');</script>"); 
      }
    ?>
    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="index.php">LogIn</a>
    </div>
  </div>
</div>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
</body>
</html>