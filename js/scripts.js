
var changeFontSize = function () {
    console.log("here");    
    $($(".cell")).css('font-size', (($(".cell").width())*0.4));
}

changeFontSize();
window.onresize = changeFontSize
