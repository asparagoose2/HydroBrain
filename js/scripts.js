var changeFontSize = function () {
    console.log("here");    
    $($(".cell")).css('font-size', (($(".cell").width())*0.4));
}

var clickClick = function() {
    if ($(this).css("background-image") != "none")
        $(this).css("background-image","none");
    else
        $(this).css("background-image",'url("../images/beet.svg")');

}

$(".cell").each( function() {
    this.onclick = clickClick
    },);

changeFontSize();
window.onresize = changeFontSize
