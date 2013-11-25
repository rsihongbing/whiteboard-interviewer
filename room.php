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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        
   		<!-- Bootstrap -->
    	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    	<link rel="stylesheet" href="css/supersized.core.css" media="screen"/>

        <!-- Firepad -->
        <script src="https://cdn.firebase.com/v0/firebase.js"></script>
        <script src="editor/codemirror/lib/codemirror.js"></script>
        <script src="editor/codemirror/mode/meta.js"></script>
        <script src="editor/firepad.js"></script>
        <script id="langScript" src="editor/codemirror/mode/clike/clike.js"></script>
        <link rel="stylesheet" href="editor/codemirror/lib/codemirror.css" />
        <link rel="stylesheet" href="editor/firepad.css" />
        <!--<script src="editor/userList.js"></script>  -->
        
        <!-- Video -->
		<script src="http://simplewebrtc.com/latest.js"></script>
		<script src="js/video.js"></script>
    	
        <style>
        .navbar { margin-top: 10px; }
        .navbar button { margin: 8px 6px 8px 2px; }
        .video{ background-color:black; }
		#leftMenu {	background-color: #eeeeee; }
  		#textEditor { font-family: courier; border:0; height:600px; }
.cols{float:left; position:relative;}
#remote video{width:100%;}
    	</style>
        
	</head>
    
	<body>
		<div class="container">
			<nav class="navbar navbar-default navbar-inverse" role="navigation">
            
			  <!-- Brand and toggle get grouped for better mobile display -->
			  <div class="navbar-header">
			    <a class="navbar-brand" href="index.html">Whiteboard Interviewer</a>
			  </div>

			  <!-- Collect the nav links, forms, and other content for toggling -->
			  <div class="collapse navbar-collapse navbar-ex1-collapse">
			    <ul class="nav navbar-nav">
			      <li class="active"><a href="#">Intro</a></li>
			      <li><a href="#">Team</a></li>
			      <li><a href="#">Contact</a></li>
			    </ul>
			  </div><!-- /.navbar-collapse -->
			</nav>

			<!-- put content here -->
		    <div style="background-color:rgba(255,255,255,0.75); padding:50px; border-radius:25px; overflow:hidden; height:550px; width:1150px;">

  <div class="row" style="position:relative;">
					<div style="position:absolute; top:30px; left:0; height:400px; width:300px; overflow:hidden;">
                            <div id="remote" class="video" style="position:absolute; top:0; left:0; width:100%; height:100%;"></div>
                            <video id="local" class="video" style="position:absolute; top:250px; left:100px; width:100px; height: 100px; z-index:2;"></video>
                        </div>

					<div style="position:absolute; top:0; left:350px; z-index:3; width:700px;">
                        <div style="margin:5px; text-align:center;">Language Mode : <select id='languages'></select></div>
                        <div id="editor-container"></div>
                    </div>

				</div>
                
			</div> <!-- /container -->

		</div><!-- /container -->
		
		<!-- Load JS Assets Last, rather than in HEAD. Prevents DOM blocking -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<!-- library for full screen background -->
		<script src="js/supersized.min.js" type="text/javascript"></script>
		<!-- Loads full screen background" -->
		<script src="js/loadFullSizeBG.js" type="text/javascript"></script>
		<script src="js/createSession.js"></script>
		<script src="editor/editor.js"></script>
        
	</body>
</html>
