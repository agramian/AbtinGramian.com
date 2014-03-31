<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');?>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" height="100%" width="100%" id="<?echo$source?>">
    <param name="movie" value="<?echo$source?>.swf" />
    <param name="quality" value="high" />
    <param name="bgcolor" value="#FFFFFF" />
    <param name="play" value="true" />
    <param name="loop" value="true" />
    <param name="wmode" value="gpu" />
    <param name="scale" value="exactfit" />
    <param name="menu" value="true" />
    <param name="devicefont" value="false" />
    <param name="salign" value="" />
    <param name="allowScriptAccess" value="sameDomain" />
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="<?echo$source?>.swf" height="100%" width="100%">
        <param name="movie" value="<?echo$source?>.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#FFFFFF" />
        <param name="play" value="true" />
        <param name="loop" value="true" />
        <param name="wmode" value="gpu" />
        <param name="scale" value="exactfit" />
        <param name="menu" value="true" />
        <param name="devicefont" value="false" />
        <param name="salign" value="" />
        <param name="allowScriptAccess" value="sameDomain" />
    <!--<![endif]-->
        <a href="http://www.adobe.com/go/getflash">
            <img id="getFlashImg" style="position:absolute;display:block;border:0px;position:absolute; top:50%;left:50%;margin-left:-56px;margin-top:-16.5px;" src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
        </a>
    <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object>


