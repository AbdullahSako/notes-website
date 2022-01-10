<?php
session_start();
//check if user is logged in or not
if(!isset($_SESSION['loggedin'])){
    header("location: index.php");
    exit;
}
else if($_SESSION['loggedin']==false){
header("location: index.php");
exit;
}

if(isset($_POST['title'])&& isset($_POST['text']) && isset($_POST['save'])){ //save note

    if($_POST['noteid']==0){ //noteid=0 means create new note else save existing one based on noteid
        require_once 'login.php';
        $conn = new mysqli($hn, $un, $pw, $db);  
        if ($conn->connect_error) echo($conn->connect_error); 

        $query  = "INSERT INTO notes(userid,title,note) VALUES( ? , ? , ? )"; //insert userid,title and note into db
        $stmt=$conn->prepare($query);
        $stmt->bind_param("iss",$_SESSION['userid'],$_POST['title'],$_POST['text']);

        if(!$stmt->execute())die("Insert failed".$stmt->error);
        $stmt->close();
        $conn->close();

        header("location: main.php"); //redirect to main when done
        exit;
    }
    else{
        require_once 'login.php';
        $conn = new mysqli($hn, $un, $pw, $db);  
        if ($conn->connect_error) echo($conn->connect_error); 
        $query  = "update notes set userid=?,title=?,note=? where id = ?"; //update title and note based on noteid sent from main
        $stmt=$conn->prepare($query);
        $stmt->bind_param("issi",$_SESSION['userid'],$_POST['title'],$_POST['text'],$_POST['noteid']);
        if(!$stmt->execute())die("Update failed".$stmt->error);
        $stmt->close();
        $conn->close();

        header("location: main.php"); //redirect to main when done
        exit;
    }
    
}



?>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">  <!-- bootstrap icon -->
    <link href="../css/editor_dark.css" rel="stylesheet" id="externalCssLink"> 
    </head>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar"> <!-- navigation bar that contains home,change theme and logout button -->
  <div class="container-fluid">
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../html/main.php">Home</a> <!-- Home -->
        </li>
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item me-2 mt-1">
        <a id="theme_button"><h3><i class="bi bi-brightness-high" id="theme_icon"></i></h3></a> <!-- change theme -->
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="logout.php" id="logout">Logout</a> <!-- Logout -->
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php 
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);  
if ($conn->connect_error) echo($conn->connect_error); 

$note="";
$title="";
if($_GET['noteid']!=0){ // get title and note as the page loads
  $query  = "select title,note from notes where id=?";
  $stmt=$conn->prepare($query);
  $stmt->bind_param("i",$_GET['noteid']);

  if(!$stmt->execute())die("select failed".$stmt->error);
  $result = $stmt->get_result(); 
  $row=$result->fetch_assoc();

  $note=$row['note'];
  $title=$row['title'];
  

  $result->close();
}

$conn->close();
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar2"> <!-- navigation bar that contains title text box and save button -->
  <div class="container-fluid">

    <div class="collapse navbar-collapse justify-content-left">
        <ul class="navbar-nav ">
            <li class="nav-item">
            <input type="text" id="note_title" placeholder="Title" size="20" value="<?php echo($title);?>"> <!-- Title -->
            </li>
        </ul>
    </div>

    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      
      
    </div>
      
    <div class="collapse navbar-collapse justify-content-right">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item mt-2 ms-1">
            <form action="editor.php" method="post"> <!-- Get noteid , title and note to save to db -->
            <button type="submit" id="save">Save</button>
            <input type="hidden" name="save" value="yes"/>
            <input type="hidden" name="noteid" value="<?php echo($_GET['noteid']);?>"/> <!-- Save -->
            <input type="hidden" name="title" value="" id="savetitle"/> <!-- value empty as it will be filled before being sent using js -->
            <input type="hidden" name="text" value=" " id="savetext"/> <!-- value empty as it will be filled before being sent using js -->
            </form>
            </li>
        </ul>
      </div>
  </div>
</nav>





    <body> 
    <div id="background_div">
      <div class="edit-content">
      <div class="editor" contenteditable="true" id="editor"><?php echo($note)?></div> <!-- Note -->
      </div>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    <!-- quill text editor library  -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

    <script type="text/javascript" src="../js/theme.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/editor.js"></script>
    <!-- library that creates hint arrow --> 
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    </body>
</html>