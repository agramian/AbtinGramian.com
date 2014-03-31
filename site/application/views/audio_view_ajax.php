<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');
if (stripos($source, 'Video_Game_SFX') != false)
{?>
<div id="audioFiles" style="width:100%; height:100%;font-size: 20px;-webkit-text-size-adjust:none;">
            <div style="color:#FFF;float:left;width:100%;text-align:center;font-size: ">
                Click on a selection below to load it into the player:
            </div>
            <div style="float:left;width:50%;height:20%;text-align:center;color:#336600;">
                <a id="shot" onclick="changeSFXSource('<?echo$source?>',this.id)">Shot</a>
            </div>
            <div style="float:left;width:50%;height:20%;text-align:center;color:#1F63AE;">
                <a id="enemy" onclick="changeSFXSource('<?echo$source?>',this.id)">Enemy</a>
            </div>
            <div style="float:left;width:100%;height:20%;text-align:center;color:#FEDF0B;">
                <a id="bomb" onclick="changeSFXSource('<?echo$source?>',this.id)">Bomb</a>
            </div>
            <div style="float:left;width:50%;height:20%;text-align:center;color:#BB2224;">
                <a id="playerdeath" onclick="changeSFXSource('<?echo$source?>',this.id)">Player Death</a>
            </div>
            <div style="float:left;width:50%;height:20%;text-align:center;color:#663300;">
                <a id="gameover" onclick="changeSFXSource('<?echo$source?>',this.id)">Game Over</a>
            </div>
            <div style="color:#FFF;float:left;width:50%;height:20%;text-align:right;">Now Playing:&nbsp</div>
            <div id="nowPlaying" style="color:#336600;float:left;width:50%;text-align:left;">SHOT</div>
            <div style="float:left;width:100%;height:20%;height:30px;margin-top:10px;">
                <audio id="player" controls="controls" width="100%" height="30px" preload="none">
                    <source type="audio/ogg" src="<?echo$source?>shot.ogg" />
                    <source type="audio/mpeg" src="<?echo$source?>shot.mp3" />
                    <source type="audio/wav" src="<?echo$source?>shot.wav" />
                    <object width="100%" height="30px" type="application/x-shockwave-flash" data="scripts/mediaelement/build/flashmediaelement.swf">
                        <param name="movie" value="scripts/mediaelement/build/flashmediaelement.swf" />
                        <param name="flashvars" value="controls=true&file=<?echo$source?>shot.mp3" />
                    </object>
                </audio>
            </div>
    </div>
<?}
else {?>
 <audio id="player" controls="controls" width="100%" height="30px" preload="none">
    <source type="audio/ogg" src="<?echo$source?>" />
    <source type="audio/mpeg" src="<?echo$source?>" />
    <source type="audio/wav" src="<?echo$source?>" />
    <object width="100%" height="30px" type="application/x-shockwave-flash" data="scripts/mediaelement/build/flashmediaelement.swf">
        <param name="movie" value="scripts/mediaelement/build/flashmediaelement.swf" />
        <param name="flashvars" value="controls=true&file=<?echo$source?>" />
    </object>
</audio>
<?}?>