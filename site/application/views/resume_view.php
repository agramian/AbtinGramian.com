<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Description" content="View or download Abtin Gramian's resume." />
        <meta name="keywords" content="abtin resume, abtin gramian resume, abtingramian resume" />
        <meta name="google" content="notranslate" />
        <title>Abtin Gramian - Resume</title>
        <link rel="shortcut icon" href="images/faviconResume.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" media="all" href="styles/AGStyles.min.css" />
    </head>
    <?flush();?>
    <body>
        <div id="titleBar">
            <?include"titleBar.php"?>
        </div>
        <div id="container" class="container_24">
            <div id="navigationBar" class="grid_24">
                <?include"navigationBar.php"?>
            </div>
            <!--end navigationBar-->
        </div>
        <!--end container-->
        <div id="mainContent">
            <div id="container" class="container_24">
                <div class="grid_24" style="height:50px;"></div>
                <!--end blank div for formatting-->
                <div id="blankLeft" class="grid_1"> <br></div>
                <!--end blank div left for formatting-->
                <div id="resume" class="grid_22"></div>
                <!--end about text-->
                <div id="blankRight" class="grid_1"><br></div>
                <!--end blank div left for formatting-->
                <div class="grid_24" style="height:40px;"></div>
                <!--end blank div for formatting-->
            </div>
            <!--end container-->
        </div>
        <!--end mainContent-->
    </body>   
    <script src="scripts/resumeScriptsLoader.min.js" type="text/javascript"></script>
</html>