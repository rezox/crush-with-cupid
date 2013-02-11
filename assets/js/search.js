var Search,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Search = (function() {

  function Search() {
    this.filter = __bind(this.filter, this);

    var _this = this;
    this.access_token = FB.getAuthResponse()['accessToken'];
    this.populate();
    FB.api('/me', function(response) {
      return _this.gender = response.gender === 'female' ? 'male' : 'female';
    });
  }

  Search.prototype.reset = function() {
    this.friends = null;
    return this.crushes = null;
  };

  Search.prototype.populate = function() {
    var _this = this;
    this.reset();
    $.ajax('/crushes', {
      dataType: "json",
      success: function(response) {
        _this.crushes = response;
        return _this.render();
      },
      error: function() {
        return _this.crushes = [];
      }
    });
    return FB.api({
      method: 'fql.query',
      query: 'SELECT uid, name, sex FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())'
    }, function(response) {
      _this.friends = response;
      return _this.render();
    });
  };

  Search.prototype.crush = function(fbid) {
    return $.ajax('/crushes', {
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
      $(this).addClass('picked');
      return $(this).parent('.friend').addClass('picked');
    });
  };

  Search.prototype.filter = function(friends) {
    var filtered;
    filtered = this.friends;
    return filtered;
  };

  Search.prototype.render = function() {
    var filtered,
      _this = this;
    if (!(this.friends != null) || !(this.crushes != null) || !(this.gender != null)) {
      return;
    }
    filtered = this.filter();
    return $('#friends').fadeOut(function() {
      _.each(filtered, function(friend) {
        var photo;
        photo = "https://graph.facebook.com/" + friend.uid + "/picture?height=320&width=320&access_token=" + _this.access_token;
        return _this.renderOne(friend, _.contains(_this.crushes, friend.uid), photo);
      });
      $('#friends').isotope();
      return $('#friends').fadeIn(function() {
        _this.bind();
        return $('#friends').isotope({
          filter: "." + _this.gender
        });
      });
    });
  };

  Search.prototype.renderOne = function(friend, crush, photo) {
    var content, picked;
    picked = '';
    if (crush) {
      picked = 'picked';
    }
    content = ("<div class='friend " + friend.sex + " " + picked + "'>") + "<div class='content'>" + ("<img src='" + photo + "' />") + ("<p>" + friend.name + "</p>") + ("<a data-uid='" + friend.uid + "' class='pick " + picked + "'><i class='icon-heart'></i>Crush</a>") + "</div>" + "</div>";
    return $('#friends').append(content);
  };

  return Search;

})();
