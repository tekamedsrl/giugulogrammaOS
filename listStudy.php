<!--
Questo software è composto da una web application in PHP su MySQL. Lo scopo 
è quello di amministtrare i dati raccolti durante le indgini diagnostiche del 
Centro di Malattie Vascolari dell'università di Ferrara.
    Copyright (C) <2017>  <Francesco Sisini>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
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
        

       
            <div class="w3-container ">
            <?php 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            include("db.php");
            $project=$_GET["project"];
            ?>
            Active repository: <b><?php echo $project; ?> </b><br><br>
            </div>
            <div class="w3-row w3-center">
                <?php if($project!='all') echo "<h2>Choose image modality:</h2>";?>
            </div>
            <div class="w3-row w3-center w3-green w3-panel" style="text-align:left;">
            
                <?php
                $db = new Db();    
                $config = parse_ini_file('./config.ini'); 
                $studydir=$config['study_dir'];
                if($project!='all'){
	            echo "<h2><a href='controller.php?action=browse&project=$project&path=$studydir&mod=bmode'>B-mode videoclip</a></h2>";
	            echo "<h2><a href='controller.php?action=browse&project=$project&path=$studydir&mod=doppler'>Doppler screenshot</a></h2>";
	            echo "<h2><a href='controller.php?action=browse&project=$project&path=$studydir&mod=cvp'>B-mode for CVP</a><br></h2>";
                }
                         ?>
                </div>
                <?php
                
                
                $query="SELECT * from us_study";
                if($project!="all") $query=$query." where researchID='".$project."'";
                
                
                $rows = $db -> select($query);
                $rn = count($rows,COUNT_NORMAL);
                ?>
            

<br><br><br>
<hr>
<div class="w3-row w3-center">
    <h2>Existing studies for <?php echo $project; ?>:</h2>
</div>
    <?php
    for ($i=0; $i<$rn; $i++) {
	echo "<div class='w3-row w3-center w3-green'><h2><a href='controller.php?action=loadStudy&study=".$rows[$i]['studyInstanceUID']."'>".$rows[$i]['studyDateTime']."&nbsp;".$rows[$i]['patientID']."</a></h2></div>";
    }
    
    ?>


<div style="text-align:center;font-family:Arial;">Tekamed-Daa&nbsp;&copy;2018 <a href="http://tekamed.it">Tekamed</a></div>
 
</body>

</html>
