function ogreResize() {
    alert("ogreresize");

    if(currentPlatform=="Win"){
        alert("Whore "+$("#gameDiv").width()+","+$("#gameDiv").height());
        getGameSrc("#gameDiv",gallery.getData().mediaPath,true,"Win",$("#gameDiv").width(),$("#gameDiv").height());
    }
    else if(currentPlatform=="Mac") {
        pongrePlayer.setSize($("#gameDiv").width(),$("#gameDiv").height());
    }                           
}
