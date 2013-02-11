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

  Search.prototype.add = function(fbid) {
    this.crushes.push(fbid);
    console.log(this.crushes);
    return $.ajax('/crushes', {
      type: 'POST',
      dataType: 'json',
      data: {
        to: fbid
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
      var fbid;
      fbid = $(this).attr('data-uid');
      if (_.contains(that.crushes, fbid)) {
        $(this).removeClass('picked');
        return that.remove(fbid);
      } else {
        $(this).addClass('picked');
        return that.add(fbid);
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
    if (!(this.friends != null) || !(this.crushes != null) || !(this.filterBy != null)) {
      return;
    }
    filtered = this.filter();
    return $('#friends').fadeOut(function() {
      $('#friends').html('');
      _.each(filtered, function(friend) {
        var photo;
        photo = "https://graph.facebook.com/" + friend.uid + "/picture?height=320&width=320&access_token=" + _this.access_token;
        return _this.renderOne(friend, _.contains(_this.crushes, friend.uid), photo);
      });
      $('#filters').fadeIn();
      return $('#friends').fadeIn(function() {
        return _this.bind();
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
