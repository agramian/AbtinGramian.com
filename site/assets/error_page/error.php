<? if(!isset($_SERVER["REDIRECT_STATUS"])) $_SERVER["REDIRECT_STATUS"]=403; header("HTTP/1.0 300 OK"); ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Abtin Gramian's Site - Error <? echo $_SERVER["REDIRECT_STATUS"] ?></title>
    <link rel="icon" href="error/images/faviconHome.jpg" type="image/jpg"> 
    <link rel="stylesheet" type="text/css" media="all" href="error/styles/errorPage.min.css" />
</head>
<body>
    <div id="titleBar">
        <div id="fullName" onclick="location.href='http://www.abtingramian.com'" >
            <div id="firstName"><img src="error/images/firstName.jpg"></div>
            <div id="lastName"><img src="error/images/lastName.jpg"></div>
        </div>
    </div>
    <div id="mainContent">
        <div id="errorMessage">
            <center>Error <? echo $_SERVER["REDIRECT_STATUS"] . " - "; 
                switch($_SERVER["REDIRECT_STATUS"]) {
                    case 400:
                        echo "Bad Request";
                        break;
                    case 401:
                        echo "Authorization Required";
                        break;
                    case 403:
                        echo "Forbidden";
                        break;
                    case 404:
                        echo "Page Not Found";
                        break;
                    case 405:
                        echo "Method Not Allowed";
                        break;
                    case 406:
                        echo "Not Acceptable(encoding)";
                        break;
                    case 407:
                        echo "Proxy Authentication Required";
                        break;
                    case 408:
                        echo "Request Timed Out";
                        break;
                    case 409:
                        echo "Conflicting Request";
                        break;
                    case 410:
                        echo "Gone";
                        break;
                    case 411:
                        echo "Content Length Required";
                        break;
                    case 412:
                        echo "Precondition Failed";
                        break;
                    case 413:
                        echo "Request Entity Too Long";
                        break;
                    case 414:
                        echo "Request URI Too Long";
                        break;
                    case 415:
                        echo "Unsupported Media Type";
                        break;
                    case 500:
                        echo "Internal Server Error";
                        break;
                    case 501:
                        echo "Not Implemented";
                        break;
                    case 502:
                        echo "Bad Gateway";
                        break;
                    case 503:
                        echo "Service Unavailable";
                        break;
                    case 504:
                        echo "Gateway Timeout";
                        break;
                    case 505:
                        echo "HTTP Version Not Supported";
                        break;                                                                                                
                }?></center>
        </div>
    </div>
<?php
   //while (list($var,$value) = each ($_SERVER)) {
     // echo "$var => $value <br />";
   //}
?>
</body>
</html>