$("#sortAge").click((e) => {
  renderList("age");
});

$("#sortType").click((e) => {
  renderList("type");
});

$("#filterReady").click((e) => {
  renderList("ready");
});

$("#filterSick").click((e) => {
  renderList("sick");
});
$("#search").on("input", (e) => {
  console.log("search");
  renderList("search", $("#search").val());
});
