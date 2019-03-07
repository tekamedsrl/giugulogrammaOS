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
       
            
            
            <?php 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            include("db.php");
            $project=$_GET["project"];
            ?>
            
            <?php
            $db = new Db();    
            $config = parse_ini_file('./config.ini'); 
            $studydir=$config['study_dir'];
            
            
            $query="SELECT * from us_study order by studyDateTime desc";
            if($project!="all") $query=$query." where researchID='".$project."'";
            
            
            $rows = $db -> select($query);
            $rn = count($rows,COUNT_NORMAL);
            ?>
            <div class="w3-row w3-center w3-padding-16">
                <h2>Reports</h2>
            </div>
            <hr>
            
            
            <?php
            $rlc=true;
            for ($i=0; $i<$rn; $i++) {
                if($rlc){
	            
	            $color="#bbbbbb";
                }else{
	            $color="#dddddd";
                }
                $rlc=!$rlc;
                echo "<div class='w3-row w3-green w3-center'><h2><a href='controller.php?action=researchreport&study=".$rows[$i]['studyInstanceUID']."'>".$rows[$i]['studyDateTime']."&nbsp;".$rows[$i]['patientID']."&nbsp;".$rows[$i]['researchID']."</a></h2></div>";
            }
            
            ?>
            <div style="text-align:center;font-family:Arial;">Tekamed-Daa&nbsp;&copy;2018 <a href="http://tekamed.it">Tekamed</a></div>
    </body>
    
</html>
