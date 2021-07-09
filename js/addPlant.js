$.ajax({
  url: "http://localhost/getPlantsList.php",
  method: "get",
  dataType: "JSON",
}).then((res) => {
  data = res;
  console.log(res);
  buildMap();
  renderMap();
  $("#" + $("#cell").val()).addClass("cellSelected");
});

// changing icon and image according to sekected type
$("#type").change((event) => {
  $("#plantIcon").attr("src", "images/" + typeMap[event.target.value] + ".svg");
  $("#plantPhoto").attr(
    "src",
    "images/" + typeMap[event.target.value] + ".jpg"
  );
  $("#floatingInput").val(
    typeMap[event.target.value].charAt(0).toUpperCase() +
      typeMap[event.target.value].slice(1)
  );
});

// saving the old value of input "#cell"
$("#cell").on("focusin", function () {
  $("#cell").data("val", $("#cell").val());
});

// changing the new cell to be selected and deselectiong the old cell
$("#cell").change((event) => {
  $("#" + $("#cell").data("val")).removeClass("cellSelected");
  $("#" + event.target.value).addClass("cellSelected");
  $("#cell").blur();
});
