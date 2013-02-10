var Frontpage;

Frontpage = (function() {

  function Frontpage() {
    $('body').css('background', 'url("assets/img/background.jpg")').css('background-size', 'cover').css('background-repeat', 'no-repeat');
  }

  return Frontpage;

})();

var Search;

Search = (function() {

  function Search() {
    this.populate();
  }

  Search.prototype.populate = function() {
    var _this = this;
    return $.ajax('/friends', {
      dataType: "json",
      success: function(response) {
        return _this.renderAll(response);
      }
    });
  };

  Search.prototype.renderAll = function(data) {
    return data.forEach(this.renderOne);
  };

  Search.prototype.renderOne = function(data) {
    return $('#friends').append("<div class='friend' data-fbid='" + data.name + "''><div class='content'><img src='" + data.pic_square + "' /><p>" + data.name + "</p><a class='pick'><i class='icon-heart'></i>Crush</a></div></div>");
  };

  return Search;

})();
