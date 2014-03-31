//MEDIA PLAYER SCRIPTS
var player;    

var scaleCheckInterval;
var intervalLength = 100;
var absValue=Math.abs;
var isiPhone = navigator.userAgent.toLowerCase().indexOf("iphone");
var isiPad = navigator.userAgent.toLowerCase().indexOf("ipad");
var isiPod = navigator.userAgent.toLowerCase().indexOf("ipod");
var isAndroid = navigator.userAgent.toLowerCase().indexOf("android");
var audioPlayerOptionsObj=new Object();
audioPlayerOptionsObj={

    // width of audio player
    audioWidth: "100%",
    // height of audio player
    audioHeight: 30,
    // initial volume when the player starts
    startVolume: 0.5,
    // useful for <audio> player loops
    loop: false,
    // enables Flash and Silverlight to resize to content size
    enableAutosize: true,
    // the order of controls you want on the control bar (and other plugins below)
    features: ['playpause','progress','current','duration','volume'],
    // Hide controls when playing and mouse is not over the video
    alwaysShowControls: false
}; 

var videoPlayerOptionsObj=new Object();
var videoPlayerOptionsObj={
    startVolume: 0.8,
    // useful for <audio> player loops
    loop: false,
    // enables Flash and Silverlight to resize to content size
    enableAutosize: true,
    // the order of controls you want on the control bar (and other plugins below)
    features: ['playpause','progress','current','duration','volume'],
    // Hide controls when playing and mouse is not over the video
    alwaysShowControls: false
};

function createVideoPlayer(loopVid,mediaDiv) {
    //explicitly set div dimensions to avoid rescaling issues
    var w = $(mediaDiv).width();
    var h = $(mediaDiv).height();
    $("#player").attr({"width":w,"height":h});
    
    videoPlayerOptionsObj.loop = loopVid;
    
    // video scaling for IE video problems
    if(gallery.isFullscreen()&&!optionsObj.trueFullscreen){
        clearInterval(scaleCheckInterval);
        scaleCheckInterval= setInterval(function(){checkVideoScale(mediaDiv);}, intervalLength);
    }
 
    if(isiPhone > -1 || isiPad > -1 || isiPod > -1 || isAndroid > -1)
    {
        return;
    }
 
    player = new MediaElementPlayer('#player',videoPlayerOptionsObj);
}

function createAudioPlayer() {     
    player = new MediaElementPlayer('#player',audioPlayerOptionsObj);
}

function changeSFXSource(path,source) {
    player.pause();
    player.setSrc( [
        {src: path + source + '.ogg', type: 'audio/ogg'},
        {src: path + source + '.mp3', type: 'audio/mpeg'},
        {src: path + source + '.wav', type: 'audio/wav'}
    ]);
    player.load();
    player.play();
    player.media.addEventListener('playing', resetPlayerTime);

    $("#nowPlaying").css("color",$("#"+source).parent().css("color"));
    $("#nowPlaying").html(source.toUpperCase());
}

function resetPlayerTime() {
    player.setCurrentTime(0);
    player.pause();
    player.media.removeEventListener('playing',resetPlayerTime);
}
function checkVideoScale(mediaDiv) {
    var w = $(mediaDiv).width();
    var h = $(mediaDiv).height();
    if(player && absValue($("#player").width() - w) > 5) {
        $("#player").attr({"width":w,"height":h});
        player.setPlayerSize(w,h);
    }
}