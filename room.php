<?php

require_once("api/Utils/QueryHelper.php");
if(!isset($_GET["url"]) && !isset($_GET["pid"])) header( 'Location: 404.html' ) ;
$qH = new QueryHelper();
$x = $qH->validate_login($_GET["url"], $_GET["pid"]);
if($x == 0)  header( 'Location: 404.html' );

?>

<!DOCTYPE html>
<html>
	<head>
	
        <title>Whiteboard Interviewer</title>

   	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>


        <link rel="stylesheet" href="css/supersized.core.css" media="screen"/>

        
        <!-- Firepad -->
        <script src="https://cdn.firebase.com/v0/firebase.js"></script>
        <script src="editor/codemirror/lib/codemirror.js"></script>
        <script src="editor/codemirror/mode/meta.js"></script>
        <script src="editor/firepad.js"></script>
        <script id="langScript" src="editor/codemirror/mode/clike/clike.js"></script>
        <link rel="stylesheet" href="editor/codemirror/lib/codemirror.css" />
        <link rel="stylesheet" href="editor/firepad.css" />
                
        <!-- Video -->
	<script src="http://simplewebrtc.com/latest.js"></script>
	<script src="js/video.js"></script>
    	
        <style>

        a{ text-decoration:none; color:white; }
        body{ font-family:"Myriad Pro", "Calibri", "Sans-serif"; }
        body > *, #sidebar > div, #sidebar > video{ position: absolute; }        
        .firepad{ width:100%; height:100%;}
        .video{ background-color:black; width:80%; height:40%; right:10%;}
        #editor-container{height:100%; top:0; left:0; width:70%; background-color:white;}
        #langPanel{z-index:3; top:0; right:30%; padding: 5px 5px 5px 15px; background-color:rgba(0,0,0,0.7); color: white; text-align:center; border-bottom-left-radius:30px;}
        #remote video{width:100%;}
        #sidebar{ top:0; right:0; height:100%; width:30%; overflow:hidden; background-color:black; color:white; text-align:center; }

    	</style>
        
	</head>
    
	<body>

                <div id="editor-container"></div>

                <div id="langPanel">Language : <select id='languages'></select></div>

                <div id="sidebar">
                    <div id="remote" class="video" style="bottom:40%;"></div>
                    <video id="local" class="video" style="bottom:10%;"></video>
                    <a href="index.html"><h1 style="margin-top:20px;">whiteboard<span style="color:#AAA;">Interviewer</span></h1></a>

                </div>

      		<script src="js/supersized.min.js" type="text/javascript"></script>
		<script src="js/loadFullSizeBG.js" type="text/javascript"></script>
		<script src="editor/editor.js"></script>
        
	</body>
</html>
