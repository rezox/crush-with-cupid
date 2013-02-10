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

  Search.prototype.crush = function(fbid) {
    return $.ajax('/crush', {
      type: 'POST',
      dataType: 'json',
      data: {
        to: fbid
      }
    });
  };

  Search.prototype.bind = function() {
    var that;
    that = this;
    return $('.pick').click(function() {
      var uid;
      uid = $(this).attr('data-uid');
      that.crush(uid);
      return $(this).addClass('picked');
    });
  };

  Search.prototype.renderAll = function(data) {
    var _this = this;
    return $('#friends').fadeOut(function() {
      data.forEach(_this.renderOne);
      $('#friends').fadeIn();
      return _this.bind();
    });
  };

  Search.prototype.renderOne = function(data) {
    var content, picked;
    picked = '';
    if ((data.crush != null)) {
      picked = ' picked';
    }
    content = "<div class='friend' data-name='" + data.name + "''>				<div class='content'>					<img src='" + data.pic_square + "' />					<p>" + data.name + "</p>					<a data-uid='" + data.uid + "' class='pick" + picked + "'><i class='icon-heart'></i>Crush</a>				</div>			</div>";
    return $('#friends').append(content);
  };

  return Search;

})();
