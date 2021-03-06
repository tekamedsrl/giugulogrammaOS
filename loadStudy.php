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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
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
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("db.php");
require_once 'mylibrary.php';
$db = new Db(); 
$suid= $db -> quote($_GET['study']);
$rows = $db -> select("SELECT * from us_videoclip where studyInstanceUID =".$suid);
$rn = count($rows,COUNT_NORMAL);
$rowStudy = $db -> select("SELECT * from us_study where studyInstanceUID =".$suid);
$suid= $_GET['study'];
$project=$rowStudy[0]['researchID'];
?>

<table>
<tr>
<td valign=top>
<b>Study data:</b><br><br>
<ul>
<b><li>Repository</b> <?php echo $project;?></li><br>
<b><li>Study Instance UID</b> <?php echo $suid;?></li><br>
<b><li>Patient ID</b> <?php echo $rowStudy[0]['patientID'];?></li><br>
<b><li>Study Date</b> <?php echo $rowStudy[0]['studyDateTime'];?></li><br>
<?php
if ($rowStudy[0]['patientName']=="asappo")
{
?>
    <div ng-app="myApp" ng-controller="myCtrl">
        
        <li><b>Patient Name</b> {{gname}} </li>
        
        <form>
            <span style="color:red;">Name</span><input type="text" ng-model="bname" />
            <input type="hidden" ng-model="bsid" />
            <input type="hidden" ng-model="bdb" />
            
            <input type="button" value="Submit" ng-click="insertData()" />
        </form>
    </div>
    <script>
     var app = angular.module('myApp',[]);
     app.controller('myCtrl',function($scope,$http){
         $scope.bsid = "<?php echo $suid ?>";
         
         $scope.insertData=function(){      
             $http.get("controller.php?action=updatename&name="+$scope.bname+"&sid="+$scope.bsid
           ).then(function(response){
                 $scope.gname = $scope.bname;
                 $scope.bdb=response.data;
                 
                 console.log("Data Inserted Successfully");
             },function(error){
                 alert("Sorry! Data Couldn't be inserted!");
                 $scope.gname = "";
                 console.error(error);
                 
             });
         }
     });
    </script>
<?php
}
else
{
?>
<b><li>Patient Name</b> <?php echo $rowStudy[0]['patientName'];?></li><br>
<?php
}
?>
</ul>
</td>
</tr>
<tr>
	<td colsplan=*><hr></td>
</tr>
<tr>
<td valign=top>
<b>Study videoclips:</b><br>
<Table cellspacing="10">
<tr><th></th><th colspan=5></th><th colspan=4 halign=center>Metadata<th></tr>
<tr><th></th><th>id</th><th alt='Progessive number of the videoclip'>ins. n.</th><th>R/L</th><th>J1/2/3</th><th>File </th><th style="color:blue;ba">CSA</th><th style="color:blue;ba">ECG </th><th style="color:blue;ba">JVP </th><th style="color:blue;ba">Doppler<th></tr>
<?php

for ($i=0; $i<$rn; $i++) {
	$did=0;
	$rl="";
	$jp="";
	$rl=$rows[$i]['RightOrLeftIJV'];
	$jp=$rows[$i]['Jposition123'];
	$vid=$rows[$i]['videoclipID'];
	$did=getDopplerId($suid,$rl,$jp);
	$q="Select count(*) as sample from doppler_sampling where iddoppler=".$did;
	$r=$db->select($q);
	$ndopp=$r[0]['sample'];
	$q="Select count(*) as sonograms from sonogram where videoclipID=".$vid;
	$r=$db->select($q);
	$ps=$r[0]['sonograms'];
	$q="Select count(*) as ecg from us_ecg where videoclipID=".$vid;
	$r=$db->select($q);
	$ecg=$r[0]['ecg'];
	$q="Select count(*) as jvp from us_jvp where videoclipID=".$vid;
	$r=$db->select($q);
	$jvp=$r[0]['jvp'];
	
	//Prepara il link ai plot
	$ajvp="";
	
	if($jvp>0)
	{
		$ajvp="<a href=controller.php?action=loadvideoJVP&video=$vid&study=$suid>Open plot</a>";
		$colorj="green";
	}
	else
	{
		$ajvp="<a href=controller.php?action=addJVP&study=$suid&video=$vid>load</a>";
		$colorj="red";
	}

	$adopp="";
	if($ndopp>0)
	{
		$isdecg=isDopplerECG($did);
		
		if($isdecg)
		{
			$colord="green";
			$adopp="<a href=controller.php?action=plotDoppler&doppler=$did&study=$suid>Open plot</a>";
		}else
		{
			$colord="red";
			$adopp="<a href=controller.php?action=addDopplerECG&study=$suid&doppler=$did>load ECG</a>";
		}
		

	}
	else
	{
		
		if($did>=1){
			$colord="red";
			$adopp="<a href=controller.php?action=addDoppler&study=$suid&doppler=$did>load</a>";
		}else
		{
			$colord="yellow";
			$adopp="No Doppler loaded";
		}
	}
	$asonogram="";
	
	if($ps>0)
	{
		$colorc="green";
		$asonogram="<a href=controller.php?action=loadvideo&video=$vid&study=$suid>Open plot</a>";
	}else
	{
		$colorc="red";
		$asonogram="<a href=controller.php?action=addCSA&video=$vid&study=$suid>load</a>";
	}
	$esonogram="";
	
	if($ps>0&&$ecg>0)
	{
		$colore="green";
		$esonogram="<a href=controller.php?action=loadvideoEcg&video=$vid&study=$suid>Open plot</a>";
	}else
	{
		$colore="red";
		$esonogram="<a href=controller.php?action=addECG&video=$vid&study=$suid>load</a>";
	}

	echo "<tr><td><li></td><td>".$rows[$i]['videoclipID']."</td><td>".$rows[$i]['instanceNumber']."</td><td>".$rl."</td><td>".$jp."</td><td>".  $rows[$i]['fileName']."</td><td style='border: 1px solid black;background-color:$colorc;'>$asonogram</td><td style='border: 1px solid black;background-color:$colore;'>$esonogram</td><td style='border: 1px solid black;background-color:$colorj;'>".$ajvp."</td><td style='border: 1px solid black;background-color:$colord;'>$adopp</td></tr>";
}

?>
</table>
</td>

</tr>

<tr>
<td>
<?php
$cvpid=getCVPid($suid);
if($cvpid>=0)
{
	echo "CVP Loaded:";
	echo "<a href=controller.php?action=addScreenshot&study=$suid&path=./studies&mod=screenshot&project=$project&cvpid=$cvpid>carica screenshot</a><br>";
	$rows=getScreenshot($cvpid);
	$rn=count($rows,COUNT_NORMAL);
	echo "<table>";
	for($i=0;$i<$rn;$i++)
	{
		echo "<tr>";
		$id=$rows[$i]['idscreenshot'];
		$cvpID=$rows[$i]['cvpID'];
		$data_shot=$rows[$i]['data_shot'];
		$fileName=$rows[$i]['fileName'];
		$isecg=isWavesForScreenshot("ecg",$id);	
		$iscvp=isWavesForScreenshot("cvp",$id);	
		$iswave=isWavesForScreenshot("waves",$id);
		echo "<td><li>$fileName</td>";
		if($isecg)
		{
			echo "<td style='border: 1px solid black;background-color:green;'>ECG loaded</td>";
		}else
		{
			
			$str="<td style='border: 1px solid black;background-color:red;'><a href='controller.php?action=addCruenta&study=$suid&type=cvpecg&idscreenshot=$id'>carica ecg</a></td>";
			echo $str;
		}
		if($iscvp)
		{
			echo "<td style='border: 1px solid black;background-color:green;'><a href='controller.php?action=plotCVP&study=$suid&idscreenshot=$id'>CVP loaded</a></td>";
		}else
		{
			
			$str="<td style='border: 1px solid black;background-color:red;'><a href='controller.php?action=addCruenta&study$suid&type=cvpcvp&idscreenshot=$id'>carica cvp</a></td>";
			echo $str;
		}
		if($iswave)
		{
			echo "<td style='border: 1px solid black;background-color:green;'>Waves acxvy loaded</td>";
		}else
		{
			
			$str="<td style='border: 1px solid black;background-color:red;'><a href='controller.php?action=addCruenta&study$suid&type=cvpwaves&idscreenshot=$id'>carica waves</a></td>";
			echo $str;
		}

		echo "</tr>";
	}
	echo "</table>";
}
else
{
	echo "";
	
}

?>
</td>
</tr>
<tr>
	<td colspan=*><hr></td>
</tr>
<tr>
    <td>
        <!--
        <a href='controller.php?action=loadreport&study=<?php echo $suid;?>'>Report</a> CCSVI criteria<br><br>
        -->
<!--<a href='controller.php?action=medicalreport&study=<?php echo $suid;?>'><b>Print</b> medical report</a><br><br>-->
<a href='controller.php?action=researchreport&study=<?php echo $suid;?>'>Print</a> study report<br><br>
</td>
</tr>
</table>
<div style="text-align:center;font-family:Arial;">Tekamed-Daa&nbsp;&copy;2018 <a href="http://tekamed.it">Tekamed</a></div>

</body>

</html>
