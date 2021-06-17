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

var buildMap = function () {
  var map = $("<div></div>");
  // Builds vertical pipes
  for (let i = 1; i <= 4; i++) {
    var pipe = $("<section></section>");
    pipe.addClass("pipe");
    pipe.addClass("vertical");
    pipe.attr("id", "Pipe" + i);
    pipe.appendTo(map);
  }

  // Builds horizontal pipes
  for (let i = 1; i <= 5; i++) {
    var pipe = $("<section></section>");
    pipe.addClass("pipe");

    // Builds cells in each horizontal pipe
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

// calculates how many days passed since dateMilis
var toDaysAgo = function (dateMilis) {
  return Math.floor((Date.now() - dateMilis) / 1000 / 60 / 60 / 24);
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
