<!DOCTYPE html>
<html>
    <style>
     a:link {
         text-decoration: none;
     }
     
     a:visited {
         text-decoration: none;
     }
     
     a:hover {
         text-decoration: underline;
     }
     
     a:active {
         text-decoration: underline;
     }
    </style>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
     
     .button {
    width:200px;
    border: 1;
    color: blue;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 22px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>    
<?php session_start();
    if($_SESSION['validated']!=true)
    {
        echo "<script>window.location.href = 'index.php';</script>";
    }
    ?>
<body>
    
    <!-- Main menu-->
        <div class="w3-row  w3-center w3-black">
            <div class="w3-col s2">
                <a href='main.php' style="color:white;">
                    <h2>Home</h2>
                </a>
            </div>
            <div class="w3-col s8">&nbsp;</div>
            <div class="w3-col s2">
                <a href='imagej.html' style="color:white;">
                    <h2>Install</h2>
                </a>
            </div>
        </div>
        <!-- Main menu-->
        </div>

        <br><br>
    <?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include("db.php");
    $db = new Db();    
    $rows = $db -> select("SELECT * from research_project");
    $rn = count($rows,COUNT_NORMAL);
    ?>
      <div class="w3-container w3-center">
          <h2>Choose a repository:</h2>
      </div>
      
      <div class="w3-row w3-center w3-green">   
          <?php
          for ($i=0; $i<$rn; $i++) {
              print ('<div class="w3-row w3-center"><h2>');
	      echo "<a href='controller.php?action=listStudies&project=".$rows[$i]['researchID']."'>".  $rows[$i]['description']."(<b>".$rows[$i]['researchID']."</b></a>)";
              print("</h2></div>");
          }
          ?>          
      </div>
      <br><br><br><br><br><br><br><br><br><br>
      <div style="text-align:center;font-family:Arial;">Tekamed-Daa&nbsp;&copy;2018 <a href="http://tekamed.it">Tekamed</a></div>
</body>

</html>
