<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Description" content="Welcome to Abtin Gramian's site! Try drawing on the home page with your mouse or finger.  Check out the about, work, resume, and contact sections too." />
        <meta name="keywords" content="abtin, abtin gramian, abtingramian, abtin home, abtin gramian home, abtingramian home, abtin's site, abtin's website, abtin's web site, abtin gramian's site, abtin gramian's website, abtin gramian's web site, abtin drawing, abtin gramian drawing" />
        <meta name="google" content="notranslate" />
        <meta property="og:title" content="Abtin Gramian&#039;s site" />
        <meta property="og:description" content="Personal website and portfolio of Abtin Gramian. Try drawing on the home page and check out the about, work, resume, and contact sections too." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="http://www.abtingramian.com" />
        <meta property="og:image" content="http://www.abtingramian.com/images/faviconHome.gif" />
        <meta property="og:site_name" content="AbtinGramian.com" />
        <meta property="fb:admins" content="813713355" /> 
        <title>Abtin Gramian - Home</title>
        <link rel="shortcut icon" href="images/faviconHome.ico" type="image/x-icon">
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
            <div id="drawingDiv">
                <div align="center" id="homeWelcome"><br/><br/>Welcome to my site!<br/><br/>Use your mouse or finger to draw in this area.<br/>Click to change line color.<br/>Draw slowly for thicker lines and faster for thinner ones.</div>
            </div>
        </div>
        <!--end mainContent-->
    </body>
    <script src="scripts/homeScriptsLoader.min.js" type="text/javascript"></script>
</html>
