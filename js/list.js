var ITEM_PAGE_URL = "item.php?plantCell=";
var httpRequest = new XMLHttpRequest();
var data;
var urlSearchParams = new URLSearchParams(window.location.search);
var params = Object.fromEntries(urlSearchParams.entries());

$.ajax({
  url: "http://se.shenkar.ac.il/students/2020-2021/web1/dev_212/getPlantsList.php",
  method: "get",
  dataType: "JSON",
}).then((res) => {
  data = res;
  console.log(res);
  buildMap();
  renderMap();
  renderList();
});

var moveObject = function (obj, x, y) {
  $(obj).css("transform", "translate(" + x + "," + y + ")");
};

var buildMap = function () {
  var map = $("<div></div>");
  var plantCellParam = params.newCell
    ? parseInt(params.newCell)
    : parseInt(params.plantCell);
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
      cell.attr("id", j + (i - 1) * 10);
      cell.addClass("cell");
      if (plantCellParam === j + (i - 1) * 10) {
        cell.addClass("cellSelected");
      }
      var link = $("<a></a>");
      link.attr("href", ITEM_PAGE_URL + (j + (i - 1) * 10));
      link.text(j + (i - 1) * 10);
      cell.append(link);
      cell.appendTo(pipe);
    }
    pipe.appendTo(map);
  }
  $($(".map")[0]).html("");
  map.appendTo($(".map")[0]);
};

var renderMap = function () {
  data.forEach((item) => {
    var index = 0;
    if (item["cell"] % 10) {
      index = Math.floor(item["cell"] / 10) * 10 + (10 - (item["cell"] % 10));
    } else {
      index =
        Math.floor(item["cell"] / 10) * 10 + (10 - (item["cell"] % 10)) - 20;
    }
    $($(".cell")[index]).css(
      "background-image",
      'url("images/' + item["type_name"] + ".svg" + '")'
    );
  });
};

// calculates how many days passed since milis
var toDaysAgo = function (milis) {
  return Math.floor((Date.now() - milis) / 1000 / 60 / 60 / 24);
};

var renderList = function (sort, searchKey) {
  var oldData = data;
  if (sort) {
    switch (sort) {
      case "type":
        data.sort((a, b) => {
          return a["type_name"].localeCompare(b["type_name"]);
        });
        break;
      case "age":
        data.sort((a, b) => {
          return (
            new Date(b["planting_time"]).getTime() -
            new Date(a["planting_time"]).getTime()
          );
        });
        break;
      case "ready":
        data = data.filter((d) => {
          return d["status"] == "ready";
        });
        break;
      case "sick":
        data = data.filter((d) => {
          return d["status"] == "sick";
        });
        break;
      case "search":
        data = data.filter((d) => {
          return (
            d["status"] +
            " " +
            d["plant_name"] +
            " " +
            d["type_name"]
          ).includes(searchKey);
        });
        break;
    }
  }
  var list = $("<ul></ul>");
  list.addClass("plantsList");
  data.forEach((plant) => {
    var listItem = $("<a></a>");
    listItem.attr("href", ITEM_PAGE_URL + plant.cell);
    var img = $("<img></img>");
    img.attr("src", "images/" + plant.type_name + ".svg");
    img.attr("alt", plant.type);
    listItem.append(img);
    var span = $('<span class="plantListName"></span>');
    span.text(plant.name ? plant.plant_name : plant.type_name);
    span.text(span.text().charAt(0).toUpperCase() + span.text().slice(1));
    listItem.append(span);
    span = $('<span class="plantListInfo"></span>');
    span.text(toDaysAgo(new Date(plant.planting_time).getTime()) + " days ago");
    listItem.append(span);
    var li = $('<li class="plantListItem"></li>');
    listItem.appendTo(li);
    li.appendTo(list);
  });
  $($(".listSection")[0]).html("");
  list.appendTo($(".listSection")[0]);
  data = oldData;
};

var changeFontSize = function () {
  $($(".cell")).css("font-size", $(".cell").width() * 0.4);
};

$("#sideBarBtn").on("click", sideBarBtnToggle);
$("#plantBtn").on("click", () => {
  $($(".alert")[0]).removeClass("hide");
});
$("#harvestBtn").on("click", () => {
  $($(".alert")[0]).removeClass("hide");
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
