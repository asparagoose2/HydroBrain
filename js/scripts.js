var ITEM_PAGE_URL = "item.html?itemID=";
var data = {
  userId: 123,
  plants: [
    {
      id: 1,
      name: "",
      type: "eggplant",
      status: "string",
      cell: 3,
      priority: 1,
      datePlanted: 1623272400000,
      likes: [
        {
          id: 1,
          userId: 12,
          userName: "susu",
        },
        {
          id: 2,
          userId: 2,
          userName: "kuku",
        },
      ],
    },
    {
      id: 2,
      name: "tuti",
      type: "strawberry",
      status: "string",
      cell: 36,
      priority: 1,
      datePlanted: 1613272400000,
      likes: [],
    },
  ],
};
var objects = [
  { cell: 7, type: "beet" },
  { cell: 10, type: "brocoli" },
  { cell: 14, type: "cauliflower" },
  { cell: 19, type: "lettuce" },
  { cell: 21, type: "eggplant" },
  { cell: 28, type: "lettuce" },
  { cell: 48, type: "spinach" },
  { cell: 27, type: "strawberry" },
  { cell: 35, type: "tomato" },
  { cell: 22, type: "brocoli" },
  { cell: 23, type: "beet" },
  { cell: 24, type: "cabage" },
  { cell: 46, type: "beet" },
  { cell: 36, type: "brocoli" },
  { cell: 39, type: "cauliflower" },
  { cell: 33, type: "lettuce" },
  { cell: 17, type: "eggplant" },
  { cell: 15, type: "lettuce" },
  { cell: 5, type: "spinach" },
  { cell: 4, type: "strawberry" },
  { cell: 2, type: "tomato" },
  { cell: 3, type: "brocoli" },
  { cell: 1, type: "beet" },
  { cell: 42, type: "cabage" },
  { cell: 41, type: "cauliflower" },
];

var moveObject = function (obj, x, y) {
  $(obj).css("transform", "translate(" + x + "," + y + ")");
};

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

var buildMap = function () {
  var map = $("<div></div>");
  for (let i = 1; i <= 4; i++) {
    var pipe = $("<section></section>");
    pipe.addClass("pipe");
    pipe.addClass("vertical");
    pipe.attr("id", "Pipe" + i);
    pipe.appendTo(map);
  }
  for (let i = 1; i <= 5; i++) {
    var pipe = $("<section></section>");
    pipe.addClass("pipe");
    for (let j = 10; j >= 1; j--) {
      var cell = $("<section></section>");
      cell.attr("id", i);
      cell.addClass("cell");
      var link = $("<a></a>");
      link.attr("href", ITEM_PAGE_URL + j);
      link.text(j + (i - 1) * 10);
      cell.append(link);
      cell.appendTo(pipe);
    }
    pipe.appendTo(map);
  }

  map.appendTo($(".map")[0]);
};

var renderMap = function () {
  objects.forEach((item) => {
    var index = 0;
    if (item["cell"] % 10) {
      index = Math.floor(item["cell"] / 10) * 10 + (10 - (item["cell"] % 10));
    } else {
      index =
        Math.floor(item["cell"] / 10) * 10 + (10 - (item["cell"] % 10)) - 20;
    }
    $($(".cell")[index]).css(
      "background-image",
      'url("images/' + item["type"] + ".svg" + '")'
    );
  });
};

// calculates how many days passed since milis
var toDaysAgo = function (milis) {
  return Math.floor((Date.now() - milis) / 1000 / 60 / 60 / 24);
};

var renderList = function () {
  var list = $(".plantsList")[0];
  data.plants.forEach((plant) => {
    var listItem = $("<a></a>");
    listItem.href = ITEM_PAGE_URL + plant.id;
    var img = $("<img></img>");
    img.attr("src", "images/" + plant.type + ".svg");
    img.attr("alt", plant.type);
    listItem.append(img);
    var span = $('<span class="plantListName"></span>');
    span.text(plant.name ? plant.name : plant.type);
    span.text(span.text().charAt(0).toUpperCase() + span.text().slice(1));
    listItem.append(span);
    span = $('<span class="plantListInfo"></span>');
    span.text(toDaysAgo(plant.datePlanted) + " days ago");
    listItem.append(span);
    var li = $('<li class="plantListItem"></li>');
    listItem.appendTo(li);
    li.appendTo(list);
  });
};

var changeFontSize = function () {
  $($(".cell")).css("font-size", $(".cell").width() * 0.4);
};

var openNav = function () {
  document.getElementById("mySidenav").style.width = "20em";
  if ($(".sideContent").css("visibility", "visible")) {
    sideBarBtnToggle();
  }
};

var closeNav = function () {
  document.getElementById("mySidenav").style.width = "0";
};

$("#sideBarBtn").on("click", sideBarBtnToggle);
$("#plantBtn").on("click", () => {
  $($(".alert")[0]).removeClass("hide");
});
$("#harvestBtn").on("click", () => {
  $($(".alert")[0]).removeClass("hide");
});
$("body").on("click", closeNav);
$(".burgerMenu").click(function (e) {
  e.stopPropagation();
});

window.onresize = function () {
  changeFontSize();
  if (
    $(window).width() / parseFloat($("body").css("font-size")) <= 60 &&
    $(".sideContent").css("visibility") == "hidden"
  ) {
    sideBarBtnToggle();
  }
  if (
    $(window).width() / parseFloat($("body").css("font-size")) >= 80 &&
    $(".sideContent").css("visibility") == "hidden"
  ) {
    sideBarBtnToggle();
  }
};

changeFontSize();
buildMap();
renderMap();
renderList();
