<?php 
if(!isset($_COOKIE['theme'])){
setcookie("theme","dark",time() + ( 365 * 24 * 60 * 60),"/");
}
session_start();
//check if user is already signed in
if(isset($_SESSION) && isset($_SESSION['loggedin'])){
  if($_SESSION['loggedin']==true){
    //redirect to main page
    header("location: main.php");
    exit;
  }
}

#connect to db
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);  
if ($conn->connect_error) die($conn->connect_error); 
$errorEnabled=false;

if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password']))
{
  $userPassword=$_POST['password'];
  $userEmail=$_POST['email'];
  $userid;
  //get hashed password and salt based on email
  $query  = "SELECT id,password,salt FROM users where email=?";
  $stmt=$conn->prepare($query);
  $stmt->bind_param('s',$userEmail);
  if(!$stmt->execute())die("select FAILED".$stmt->error);
  $result = $stmt->get_result();   
  if($result->num_rows >0){
    $row=$result->fetch_assoc();
    $encryptedPassword=$row['password'];
    $salt=$row['salt'];
    $userid=$row['id'];
    //check if password is correct
    if(hash('ripemd128',$userPassword.$salt)==$encryptedPassword){
      $_SESSION['loggedin']=true;
      $_SESSION['email']=$userEmail;
      $_SESSION['userid']=$userid;
      header("location: main.php");
      exit;
    }
    else{
      $errorEnabled=true; // to show an error if password is wrong
    }
  }
  else{
    $errorEnabled=true; // to show an error if email is wrong
  }
  $result->close();
}


  $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../js/theme.js"></script> 
<link rel="stylesheet" href="..\css\index_dark.css" id="externalCssLink">
</head>

<body>
  <h5 style="color:#ECB365;">email:test@gmail.com \\ Password:test1234</h5>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="..\icons\account_circle_black_24dp.svg" id="icon" alt="User Icon" />
    </div>

    <!-- Login Form -->
    <form action="index.php" method="post">
      <input type="hidden" name="login" value="yes"/>
      <input type="email" id="login" class="fadeIn second" name="email" placeholder="Email">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
      <input type="submit" class="fadeIn fourth" value="Log In">
      <h5 id="error">Email or password is incorrect</h5>
    </form>

    <?php
      if($errorEnabled){
        //show 'Email or password are incorrect' error
        echo("<script>$('#error').css('visibility','visible');</script>"); 
      }
    ?>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="register.php">Register</a>
    </div>

  </div>
</div>



</body>
</html>