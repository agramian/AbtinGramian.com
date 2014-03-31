<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');?>
<video id="player" width="100%" height="100%" controls="controls" preload="none" poster="<?echo$source?>-Large.jpg">
    <!-- WebM/VP8 for Firefox4, Opera, and Chrome -->
    <source type="video/webm" src="<?echo$source?>.webm" />
    <!-- Ogg/Vorbis for older Firefox and Opera versions -->
    <source type="video/ogg" src="<?echo$source?>.ogv" /> 
    <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
    <source type="video/mp4" src="<?echo$source?>-High.mp4" />
    <!-- MP4 Older devices -->
    <source type="video/mp4" src="<?echo$source?>-Main.mp4" />           
    <!-- MP4 Mobile devices -->
    <source type="video/mp4" src="<?echo$source?>-Baseline.mp4" />
</video>
