// var objects = [
//     {"cell":10,"type":"beet"},
//     {"cell":20,"type":"brocoli"},
//     {"cell":40,"type":"beet"},
//     {"cell":25,"type":"beet"},
//     {"cell":32,"type":"cauliflower"}
// ];

var objects = [];

for (let index = 0; index < 50; index++) {
    objects[index] = {"cell":index+1,"type":"brocoli"};   
}


// var renderMap = function() {
//     objects.forEach((item) => {
//         var index = 0;
//         if(item["cell"]%10) {
//             index = (Math.floor(item["cell"]/10))*10 + (10-item["cell"]%10);
//         } else {
//             index = (Math.floor(item["cell"]/10))*10 + (10-item["cell"]%10) -20;
//         }
//         console.log(index);
//         $($($(".cell")[index]).children()[0]).attr("href", 'item.html?itemID=' + item["cell"]);
//     });
// }
var renderMap = function() {
    objects.forEach((item) => {
        var index = 0;
        if(item["cell"]%10) {
            index = (Math.floor(item["cell"]/10))*10 + (10-item["cell"]%10);
        } else {
            index = (Math.floor(item["cell"]/10))*10 + (10-item["cell"]%10) -20;
        }
        console.log(index);
        $($(".cell")[index]).css("background-image",'url("../images/'+item["type"]+'.svg'+'")');
    });
}

renderMap();

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

// $($('.sort')[0]).css({
//     style: 'btn-primary',
//     showIcon: true,
//     title: 'select test'
// });
