<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');
if($hasPlugin=="true") {
    ?>
<object type='application/x-panda3d' data='<?echo$source?>.p3d' auto_start='1' width='100%' height='100%' style='position:absolute;' splash_img='<?echo$source?>-Poster.jpg'><object style='position:absolute;top:-1px' width='100%' height='100%' classid='CLSID:924B4927-D3BA-41EA-9F7E-8A89194AB3AC'><param name='data' value='<?echo$source?>.p3d'><param name='auto_start' value='1'><param name='splash_img' value='<?echo$source?>-Poster.jpg'></object></object>
<?}
else {
    ?>
<div style="color:#FFF;text-align:center;font-size:18px;position:absolute;top:50%;margin-top:-3em;">The Panda3D plugin does not appear to be installed! You will need it in order to run the demos. Please follow this <a href="http://www.panda3d.org/get" style="color:#F00;"target="_blank">link</a> to download it. Be sure to restart your browser once you have installed the plugin!
</div>
<?}?>