<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Description" content="Contact Abtin Gramian and like the site on Facebook." />     
        <meta name="keywords" content="abtin contact, abtin gramian contact, abtingramian contact" />
        <meta name="google" content="notranslate" />       
        <title>Abtin Gramian - Contact</title>
        <link rel="shortcut icon" href="images/faviconContact.ico" type="image/x-icon">
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
                <div id="blankLeft" class="grid_1"><br></div>
                <!--end blank div left for formatting-->
                <div id="contactPageContent" class="grid_22">
                    <p>abtin.gramian@gmail.com</p>
                    <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.abtingramian.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
                    <form id="contactForm">
                        <p>
                            <div id="messageInfo"></div>
                            <div class="caption">Message Type:</div>
                            <input type="radio" name="messageType" value="email" checked="checked" />Email
                            <input type="radio" name="messageType" value="text" />Text
                            <br>
                            <div class="caption" id="senderContactCaption">Your Email Address:</div>
                            <input id="senderContact" type="text" class="text" />
                            <div class="caption">Message Title:</div>
                            <input id="messageTitle" type="text" class="text" />
                            <br>
                            <div class="caption">Your Message:</div>
                            <textarea id="message"></textarea>
                        </p>
                        <p>
                            <input class="btn" type="button" value="Send Email" id="sendMessage" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" />
                        </p>
                    </form>
                </div>
                <!--end about text-->
                <div id="blankRight" class="grid_1"><br></div>
                <!--end blank div left for formatting-->
                <div class="grid_24" style="height:30px;"></div>
                <!--end blank div for formatting-->
            </div>
            <!--end container-->
        </div>
        <!--end mainContent-->
    </body>
    <script src="scripts/contactScriptsLoader.min.js" type="text/javascript"></script>
</html>