<?php 
session_start();

if(isset($_SESSION) && isset($_SESSION['loggedin'])){
  if($_SESSION['loggedin']==true){
    //go to main page
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="..\css\index.css">
<!------ Include the above in your HEAD tag ---------->
</head>

<body>
  <h1>email:test@gmail.com \\ Password:test1234</h1>
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
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="register.php">Register</a>
    </div>

  </div>
</div>

<?php 
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);  
if ($conn->connect_error) die($conn->connect_error); 
echo("<h1>OUT OF STATMENT</h1>");
if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password']))
{
  echo("IN IF STATMENT");
  $userPassword=get_post($conn,$_POST['password']);
  $userEmail=get_post($conn,$_POST['email']);
  $query  = "SELECT password,salt FROM users where email=$userEmail";
  
  $result = $conn->query($query);    
  if($result->num_rows >0){
    $row=$result->fetch_assoc();
    $encryptedPassword=$row['password'];
    $salt=$row['salt'];

    if(hash('ripemd128',$userPassword.$salt)==$encryptedPassword){
      session_start();
      $_SESSION['loggedin']==true;
      $_SESSION['email']=$userEmail;
      header("location: main.php");
      exit;
    }
    else{
      // print email or password wrong
    }

  }
  else{
    // print email or password wrong
  }
  $result->close();

}


  $conn->close();
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]); 
  }
?>

</body>
</html>