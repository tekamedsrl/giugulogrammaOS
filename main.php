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
    <head>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style>
         .button {
             
             border: 1;
             color: black;
             padding: 15px 32px;
             text-align: center;
             text-decoration: none;
             display: inline-block;
             font-size: 28px;
             margin: 4px 2px;
             cursor: pointer;
         }
         a:link {
             text-decoration: none;
         }
         
         a:visited {
             text-decoration: none;
         }
        </style>
    </head>
    
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
            <div class="w3-col s2">
                <a href='main.php' style="color:white;">
                    <h4><?php echo $_SESSION['user']; ?></h4>
                </a>
            </div>
            
            <div class="w3-col s6">&nbsp;</div>
            <div class="w3-col s2">
                <a href='imagej.html' style="color:white;">
                    <h2>Install</h2>
                </a>
            </div>
        </div>
        <!-- Main menu-->
        
        <h1 style="text-align: center; font-size:24px; font-family: Times New Roman, Georgia, Serif;font-color:blue;">Upload real time and off-line CSA dataset to produce JVP diagram</h1> 
<br><br>
       <div style="width:100%;text-align:center;">
           <img src="img/map.jpg">
           
       </div>
       <br><br>
       <div class="w3-row  w3-center w3-green">
       <div style="text-align:center;">
           <form method="get" action="start.php">
               <button class=button type="submit">Start</button></div>
           </form>
           </div>
           <!--
                <div id="gnu-banner">
                <a href="https://www.gnu.org/">
                <img src="img/gnu.png" size=30% alt=" [A GNU head] " />
                <strong>GNU software</strong>
                </a>
                </div>
           -->
                      
           <br><br><br><br><br><br><br><br><br><br><br><br>
           <div style="text-align:center;font-family:Arial;">Tekamed-Daa&nbsp;&copy;2018 <a href="http://tekamed.it">Tekamed</a> </div>
          
               
           </div>
        </div><!-- /gnu-banner -->
        
        
        
    </body>
</html>

