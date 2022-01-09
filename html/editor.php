<?php
session_start();

if(!isset($_SESSION['loggedin'])){
    header("location: index.php");
    exit;
}
else if($_SESSION['loggedin']==false){
header("location: index.php");
exit;
}

if(isset($_POST['title'])&& isset($_POST['text']) && isset($_POST['save'])){
    echo($_POST['title']);
    echo($_POST['text']);

    if($_POST['noteid']==0){
        require_once 'login.php';
        $conn = new mysqli($hn, $un, $pw, $db);  
        if ($conn->connect_error) echo($conn->connect_error); 

        $query  = "INSERT INTO notes(userid,title,note) VALUES(?,?,?)";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("i,s,s",$_SESSION['userid'],$_POST['title'],$_POST['text']);

        if(!$stmt->execute())die("Delete failed".$stmt->error);
        $stmt->close();
        $conn->close();
    }
    else{
        require_once 'login.php';
        $conn = new mysqli($hn, $un, $pw, $db);  
        if ($conn->connect_error) echo($conn->connect_error); 
        $query  = "update notes set (userid=?,title=?,note=?) where id = ?";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("i,s,s,i",$_SESSION['userid'],$_POST['title'],$_POST['text'],$_GET['noteid']);
        if(!$stmt->execute())die("Delete failed".$stmt->error);
        $stmt->close();
        $conn->close();
    }
    
}



?>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">  
    <link href="../css/editor_dark.css" rel="stylesheet" id="externalCssLink"> 
    </head>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
  <div class="container-fluid">
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../html/main.php">Home</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item me-2 mt-1">
        <a id="theme_button"><h3><i class="bi bi-brightness-high" id="theme_icon"></i></h3></a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="logout.php" id="logout">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar2">
  <div class="container-fluid">

    <div class="collapse navbar-collapse justify-content-left">
        <ul class="navbar-nav ">
            <li class="nav-item">
            <input type="text" id="note_title" placeholder="Title" size="20"/>
            </li>
        </ul>
    </div>

    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav center ms-5">
          <li class="nav-item mt-2 ms-1">
          <select>
              <option>Normal text</option>
              <option>Title</option>
              <option>Subtitle</option>
              <option>Heading 1</option>
              <option>Heading 2</option>
              <option>Heading 3</option>
          </select>
        </li>
      </ul>

      <ul class="navbar-nav center ">
          <li class="nav-item mt-2 ms-1">
          <select>
            <option value="Arial">Arial</option>
            <option value="Helvetica">Helvetica</option>
            <option value="Times New Roman">Times New Roman</option>
            <option value="Sans serif">Sans serif</option>
            <option value="Courier New">Courier New</option>
            <option value="Verdana">Verdana</option>
            <option value="Georgia">Georgia</option>
            <option value="Palatino">Palatino</option>
            <option value="Garamond">Garamond</option>
            <option value="Comic Sans MS">Comic Sans MS</option>
            <option value="Arial Black">Arial Black</option>
            <option value="Tahoma">Tahoma</option>
            <option value="Comic Sans MS">Comic Sans MS</option>
          </select>
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-2 ms-1">
          <select>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="18">18</option>
            <option value="24">24</option>
            <option value="36">30</option>
            <option value="48">48</option>
            <option value="60">60</option>
            <option value="72">72</option>
            <option value="96">96</option>
          </select>
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-3 ms-1">
          <a><h3><i class="bi bi-type-bold"></i></h3></a>
          
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-3 ms-1">
          <a><h3><i class="bi bi-type-italic"></i></h3></a>
          
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-3 ms-1">
          <a><h3><i class="bi bi-type-underline" ></i></h3></a>
          
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-3 ms-1">
          <a><h5><i class="bi bi-palette"></i></h5></a>
          
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-3 ms-1">
          <a><h3><i class="bi bi-text-left"></i></h3></a>
          
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-3 ms-1">
          <a><h3><i class="bi bi-text-center"></i></h3></a>
          
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-3 ms-1">
          <a><h3><i class="bi bi-text-right"></i></h3></a>
        </li>
      </ul>
      <ul class="navbar-nav center ">
          <li class="nav-item mt-3 ms-1">
          <a><h3><i class="bi bi-list-ul"></i></h3></a>
        </li>
      </ul>
      <ul class="navbar-nav center me-auto">
          <li class="nav-item mt-3 ms-1">
          <a><h3><i class="bi bi-list-ol"></i></h3></a>
        </li>
      </ul>

    </div>

    <div class="collapse navbar-collapse justify-content-right">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item mt-2 ms-1">
            <form action="editor.php" method="post">
            <button type="submit" id="save">Save</button>
            <input type="hidden" name="save" value="yes"/>
            <input type="hidden" name="noteid" value="<?php echo($_GET['noteid']);?>"/>
            <input type="hidden" name="title" value="" id="savetitle"/>
            <input type="hidden" name="text" value=" " id="savetext"/>
            </form>
            </li>
        </ul>
      </div>
  </div>
</nav>





    <body> 

    <div id="background_div">
            <div class="edit-content">
            <div class="editor" contenteditable="true" id="editor"></div>
            </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/theme.js"></script> 
    <script type="text/javascript" src="../js/editor.js"></script> 
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    </body>
</html>