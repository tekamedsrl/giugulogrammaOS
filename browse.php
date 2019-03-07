<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'mylibrary.php';
$path=$_GET['path'];
$project=$_GET['project'];
$mod=$_GET['mod'];
$cvpid=W_GET('cvpid');
$dirs=scandir($path);
$rn = count($dirs,COUNT_NORMAL);
$suid="";
?>
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
            <div class="w3-row w3-center">
               <h2> Choose:</h2>
            </div>
            <?php
            if($mod=='screenshot')
            {
	        $action='addScreenshot';
	        $suid=$_GET['study'];
            }else
            {
	        $action='browse';
            }
            
            for($i=0;$i<$rn;$i++)
            {
                if($i%2==0)
                    $color="w3-white";
                else
                    $color="w3-green";
                if(is_dir($path.'/'.$dirs[$i]))
	        {
                    print("<div class='w3-row w3-center'>");
		    echo "<a href='controller.php?action=$action&study=$suid&cvpid=$cvpid&mod=$mod&project=$project&path=$path/$dirs[$i]'>$dirs[$i]</a><br><hr><br>";
                    print("</div>");
	        }else
	        {
                    print("<div class=' w3-row w3-center $color'>");
	            echo "<h2><a href='controller.php?action=$action&study=$suid&cvpid=$cvpid&mod=$mod&project=$project&path=$path/$dirs[$i]'>$dirs[$i]</a><br></a></h2>";
                    print("</div>");
	        }
            }
            ?>
            <div style="text-align:center;font-family:Arial;">Tekamed-Daa&nbsp;&copy;2018 <a href="http://tekamed.it">Tekamed</a></div>
    </body>
</html>
