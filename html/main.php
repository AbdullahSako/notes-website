<?php 
session_start();
//check if user is logged in in session if not send him to login page
if(!isset($_SESSION['loggedin'])){
    header("location: index.php");
    exit;
}
else if($_SESSION['loggedin']==false){
header("location: index.php");
exit;
}

if(isset($_POST['delete']) && isset($_POST['noteid'])){ //delete note
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);  
  if ($conn->connect_error) echo($conn->connect_error); 
  $query  = "delete from notes where id = ?";
  $stmt=$conn->prepare($query);
  $stmt->bind_param("s",$_POST['noteid']);
  if(!$stmt->execute())die("Delete failed".$stmt->error);
  $stmt->close();
  $conn->close();
}

?>
<html>

<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link href="../css/main_dark.css" rel="stylesheet" id="externalCssLink"> 

</head>
<!-- navigation bar that contains home,add note,logout and change theme buttons -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar"> 
  <div class="container-fluid">
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../html/main.php">Home</a><!-- Home -->
        </li>
      </ul>
      <ul class="navbar-nav center mb-lg-0">
          <li class="nav-item mt-4">
          <form action="editor.php" method="get">
          <input type="hidden" name="noteid" value="0"/>
          <button type="submit" id="plusicon"><h3><i class="bi bi-plus-lg"></h3></i></button><!-- add button -->
          </form>
        </li>
      </ul>
      
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item me-2 mt-1">
        <a id="theme_button"><h3><i class="bi bi-brightness-high" id="theme_icon"></i></h3></a> <!-- change theme -->
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="logout.php" id="logout">Logout</a><!-- Logout -->
        </li>
      </ul>
    



    </div>
  </div>
</nav>

<body>
<div class="social-box">
    <div class="container">
     	<div class="row">
			 

                <?php
                require_once 'login.php';
                $conn = new mysqli($hn, $un, $pw, $db);  
                if ($conn->connect_error) echo($conn->connect_error); 
                $query  = "SELECT id,title,substring(note,1,200) as note FROM notes where userid=?"; //get note id / title / 200 characters of the note(hidden characters included such as <span>) based on userid
                $stmt=$conn->prepare($query);
                $stmt->bind_param('i',$_SESSION['userid']);
                if(!$stmt->execute())die("select FAILED".$stmt->error);
                $result = $stmt->get_result();   
                if($result->num_rows >0){
                    while($row=$result->fetch_assoc()){   // print a box on screen with title, delete button and a few note characters
                        echo('<div class="col-lg-4 col-xs-12 text-center mb-2">');
                        echo('<div class="box h-100" id="box">');
                        echo('<form action="editor.php" method="get" id="boxform">'); // form to send note id to the editor to edit content
                        echo('<input type="hidden" name="noteid" value="'.$row['id'].'"/>');
                        echo('</form>');
                        echo('<i class="fa fa-behance fa-3x" aria-hidden="true"></i>');
                        echo('<div class="box-title" style="word-wrap: break-word;"'); //title
                        echo('<h3>'.$row['title'].'</h3>');
                        echo('</div>');
                        echo('<div class="box-text h-25" style="word-wrap: break-word; overflow:hidden; font-size:x-small;">');
                        echo('<span>'.$row['note'].'</span>'); // text
                        echo('</div>');
                        echo('<div class="box-btn">');
                        echo('<form action="main.php" method="post">'); //send note id in order to delete it
                        echo('<input class="mt-auto" type="submit" id="delete" value="Delete"\>');
                        echo('<input type="hidden" name="noteid" value="'.$row['id'].'"/>');
                        echo('<input type="hidden" name="delete" value="yes"/>');
                        echo('</form>');
                        echo('</div>');
                        echo('</div>');
                        echo('</div>');
                    }
                    $result->close();
                }
                ?>

		</div>		
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="../js/theme.js"></script> 
<script type="text/javascript" src="../js/main.js"></script> 
<!-- library that creates a hint arrow -->
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
</body>
</html>