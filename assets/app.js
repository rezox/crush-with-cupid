var Frontpage;

Frontpage = (function() {

  function Frontpage() {
    $('body').css('background', 'url("assets/img/background.jpg")').css('background-size', 'cover').css('background-repeat', 'no-repeat');
  }

  return Frontpage;

})();

var Search,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Search = (function() {

  function Search() {
    this.filter = __bind(this.filter, this);

    this.add = __bind(this.add, this);

    var _this = this;
    this.access_token = FB.getAuthResponse()['accessToken'];
    this.populate();
    FB.api('/me', function(response) {
      _this.filterBy = response.gender === 'female' ? 'male' : 'female';
      $("#filters #" + _this.filterBy).addClass('active');
      return _this.render();
    });
  }

  Search.prototype.reset = function() {
    this.friends = null;
    this.crushes = null;
    return this.pairs = null;
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
    $.ajax('/pairs', {
      dataType: "json",
      success: function(response) {
        _this.pairs = response;
        return _this.render();
      },
      error: function() {
        return _this.pairs = [];
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

  Search.prototype.add = function(fbid, elem) {
    this.crushes.push(fbid);
    console.log(this.crushes);
    return $.ajax('/crushes', {
      type: 'POST',
      dataType: 'json',
      data: {
        to: fbid
      },
      success: function(response) {
        if (response.paired != null) {
          elem.addClass('pair');
          return elem.find('.photo').append("<img src='assets/img/pair.png' />");
        }
      }
    });
  };

  Search.prototype.remove = function(fbid) {
    this.crushes.splice(_.indexOf(this.crushes, fbid), 1);
    console.log(this.crushes);
    return $.ajax('/crushes', {
      type: 'DELETE',
      dataType: 'json',
      data: {
        to: fbid
      }
    });
  };

  Search.prototype.bind = function() {
    var that;
    that = this;
    $('.pick').click(function() {
      var elem, fbid;
      fbid = $(this).attr('data-uid');
      elem = $(this).closest(".friend");
      if (elem.hasClass('pair')) {
        return;
      }
      if (_.contains(that.crushes, fbid)) {
        elem.removeClass('picked');
        return that.remove(fbid);
      } else {
        elem.addClass('picked');
        return that.add(fbid, elem);
      }
    });
    return $('#filters div, #filters #all, #filters i').click(function() {
      var filterBy;
      filterBy = $(this).attr('data-filter');
      if (filterBy !== that.filterBy) {
        $("#filters #" + that.filterBy).removeClass('active');
        $(this).addClass('active');
        that.filterBy = filterBy;
        return that.render();
      }
    });
  };

  Search.prototype.filter = function(friends) {
    var filtered,
      _this = this;
    filtered = this.friends;
    if (this.filterBy === 'heart') {
      filtered = _.filter(filtered, function(friend) {
        return _.contains(_this.crushes, friend.uid);
      });
    } else if (this.filterBy === 'male' || this.filterBy === 'female') {
      filtered = _.where(filtered, {
        sex: this.filterBy
      });
    }
    return filtered;
  };

  Search.prototype.render = function() {
    var filtered,
      _this = this;
    if (!(this.friends != null) || !(this.crushes != null) || !(this.filterBy != null) || !(this.pairs != null)) {
      return;
    }
    filtered = this.filter();
    return $('#friends').fadeOut(function() {
      $('#friends').html('');
      _.each(filtered, function(friend) {
        var photo;
        photo = "https://graph.facebook.com/" + friend.uid + "/picture?height=320&width=320&access_token=" + _this.access_token;
        return _this.renderOne(friend, _.contains(_this.crushes, friend.uid), _.contains(_this.pairs, friend.uid), photo);
      });
      $('#filters').fadeIn();
      return $('#friends').fadeIn(function() {
        return _this.bind();
      });
    });
  };

  Search.prototype.renderOne = function(friend, has_crush, is_pair, photo) {
    var content, pair, picked;
    picked = '';
    if (has_crush) {
      picked = 'picked';
    }
    pair = '';
    if (is_pair) {
      pair = 'pair';
    }
    content = ("<div class='friend " + picked + " " + pair + "'>") + "<div class='content'>" + "<div class='photo'>" + ("<img src='" + photo + "' />");
    if (is_pair) {
      content += "<img src='assets/img/pair.png' />";
    }
    content += "</div>" + ("<p>" + friend.name + "</p>") + ("<a data-uid='" + friend.uid + "' class='pick " + picked + "'><i class='icon-heart'></i>Crush</a>") + "</div>" + "</div>";
    return $('#friends').append(content);
  };

  return Search;

})();
