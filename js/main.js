var sideBarBtnToggle = function () {
  if ($(".sideContent").css("visibility") == "hidden") {
    $(".sideContent").css("visibility", "visible");
    moveObject($("#sideBarBtn"), "33vw", "0%");
    if ($("#xBtn").width()) {
      $("#xBtn").attr("src", "images/xBlack.svg");
    } else {
      $("img", "#sideBarBtn").attr("src", "images/x.svg");
    }
  } else {
    $(".sideContent").css("visibility", "hidden");
    moveObject($("#sideBarBtn"), "0%", "0%");
    $("img", "#sideBarBtn").attr("src", "images/rightChevron.svg");
  }
};

var openNav = function () {
  document.getElementById("mySidenav").style.width = "20em";
  if ($("main").css("visibility") == "visible") {
    if ($(".sideContent").css("visibility", "visible")) {
      sideBarBtnToggle();
    }
  }
};

var closeNav = function () {
  document.getElementById("mySidenav").style.width = "0";
  if ($("main").css("visibility") == "visible") {
    sideBarBtnToggle();
  }
};

$("body").on("click", closeNav);
$(".burgerMenu").click(function (e) {
  e.stopPropagation();
});
