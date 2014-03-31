<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');
if($platform=="Win") {?>
<object id='pongrePlayer' name='Pongre' classid='java:Launcher.class' type='application/x-java-applet' width='<?echo$width?>px' height='<?echo$height?>px'><param name='jnlp_href' value='<?echo$source?>PONGRE_WIN/pongre.jnlp' /><param name='mWidth' value='<?echo$width?>' /><param name='mHeight' value='<?echo$height?>' /><param name='separate_jvm' value='true' /></object>
<?} else if($platform=="Mac") {?>   
<applet id='pongrePlayer' name='Abtin Gramian\'s Pongre' code='Launcher' width='<?echo$width?>' height='<?echo$height?>'><param name='jnlp_href' value='<?echo$source?>PONGRE_MAC/pongre.jnlp' /><param name='codebase_lookup' value='false' /><param name='separate_jvm' value='true' /></applet>
<?}else {?>
<div style="color:#FFF;text-align:center;font-size:18px;position:absolute;top:50%;margin-top:-3em;">Unfortunately the operating system you are using is not supported by this game.</div>
<?}?>