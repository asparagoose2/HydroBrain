var toggleLikes = function (action, plantid) {
    console.log($("#11"));
    console.log(action);
    console.log(plantid);
    $.ajax({
      url: "http://se.shenkar.ac.il/students/2020-2021/web1/dev_212/alterLikes.php",
      method: "post",
      data: { action: action, plant_id: plantid },
    }).then((res) => {
      console.log(res);
    });
  };
  
  var likeOnClick = function (elem) {
    if (!elem.classList.contains("liked")) {
      elem.classList.add("liked");
      toggleLikes("insert", $(elem).attr("id"));
    } else {
      elem.classList.remove("liked");
      toggleLikes("delete", $(elem).attr("id"));
    }
  };