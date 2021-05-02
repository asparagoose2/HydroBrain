var objects = [
    {"cell":7,"type":"beet"},
    {"cell":10,"type":"brocoli"},
    {"cell":14,"type":"cauliflower"},
    {"cell":19,"type":"lettuce"},
    {"cell":21,"type":"eggplant"},
    {"cell":28,"type":"lettuce"},
    {"cell":48,"type":"spinach"},
    {"cell":27,"type":"strawberry"},
    {"cell":35,"type":"tomato"},
    {"cell":22,"type":"brocoli"},
    {"cell":23,"type":"beet"},
    {"cell":24,"type":"cabage"},
    {"cell":46,"type":"beet"},
    {"cell":36,"type":"brocoli"},
    {"cell":39,"type":"cauliflower"},
    {"cell":33,"type":"lettuce"},
    {"cell":17,"type":"eggplant"},
    {"cell":15,"type":"lettuce"},
    {"cell":5,"type":"spinach"},
    {"cell":4,"type":"strawberry"},
    {"cell":2,"type":"tomato"},
    {"cell":3,"type":"brocoli"},
    {"cell":1,"type":"beet"},
    {"cell":42,"type":"cabage"},

    {"cell":41,"type":"cauliflower"}
];

var moveObject = function(obj,x,y) {
    $(obj).css("transform","translate("+x+","+y+")");
}

var sideBarBtnToggle = function() {
    if($(".sideContent").css("visibility") == "hidden") {
        $(".sideContent").css("visibility","visible");
        moveObject($("#sideBarBtn"),"33vw","0%");
        if ($("#xBtn").width()) {
            $("#xBtn").attr("src","images/xBlack.svg");
        } else {
            $('img',"#sideBarBtn").attr("src","images/x.svg");
        }
    } else {
        $(".sideContent").css("visibility","hidden");
        moveObject($("#sideBarBtn"),"0%","0%");
        $('img',"#sideBarBtn").attr("src","images/rightChevron.svg");
    }
}

var renderMap = function() {
    objects.forEach((item) => {
        var index = 0;
        if(item["cell"]%10) {
            index = (Math.floor(item["cell"]/10))*10 + (10-item["cell"]%10);
        } else {
            index = (Math.floor(item["cell"]/10))*10 + (10-item["cell"]%10) -20;
        }
        $($(".cell")[index]).css("background-image",'url("../images/'+item["type"]+'.svg'+'")');
    });
}

var changeFontSize = function () {
    $($(".cell")).css('font-size', (($(".cell").width())*0.4));
}

var openNav = function() {
    document.getElementById("mySidenav").style.width = "20em";
    if($(".sideContent").css("visibility","visible")) {
        sideBarBtnToggle();
    }
}

var closeNav = function() {
    document.getElementById("mySidenav").style.width = "0";
}

$("#sideBarBtn").on("click", sideBarBtnToggle);
$("#plantBtn").on("click",()=> {
    $($(".alert")[0]).removeClass("hide");
});
$("#harvestBtn").on("click",()=> {
    $($(".alert")[0]).removeClass("hide");
});
$("body").on("click", closeNav);
$(".burgerMenu").click(function(e) {
    e.stopPropagation();
});

window.onresize = function() {
    changeFontSize();
    if($(window).width() / parseFloat($("body").css("font-size")) <= 60 && $(".sideContent").css("visibility") == "hidden") {
        sideBarBtnToggle();
    }
    if($(window).width() / parseFloat($("body").css("font-size")) >= 80 && $(".sideContent").css("visibility") == "hidden") {
        sideBarBtnToggle();
    }
}

changeFontSize();
renderMap();