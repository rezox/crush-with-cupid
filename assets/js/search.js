var Search,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Search = (function() {

  function Search() {
    this.filter = __bind(this.filter, this);

    this.add = __bind(this.add, this);

    var toggleBackToTop,
      _this = this;
    this.access_token = FB.getAuthResponse()['accessToken'];
    this.populate();
    toggleBackToTop = _.debounce(function(e) {
      if ($('#back-to-top').is(":visible")) {
        if ($(window).scrollTop() <= $('#friends').position().top) {
          return $('#back-to-top').hide("slide", {
            direction: "right"
          }, 500);
        }
      } else {
        if ($(window).scrollTop() >= $('#friends').position().top) {
          return $('#back-to-top').show("slide", {
            direction: "right"
          }, 500);
        }
      }
    }, 250);
    $(window).scroll(toggleBackToTop);
    $('#back-to-top').click(function() {
      $('html, body').animate({
        scrollTop: $('#filters').offset().top - 20
      }, 500);
      return this.searchBy = null;
    });
    FB.api('/me', function(response) {
      _this.filterBy = 'all';
      if (response.gender === 'female') {
        _this.filterBy = 'male';
      } else if (response.gender === 'male') {
        _this.filterBy = 'female';
      }
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
    var _this = this;
    this.crushes.push(fbid);
    return $.ajax('/crushes', {
      type: 'POST',
      dataType: 'json',
      data: {
        to: fbid
      },
      success: function(response) {
        if (response.paired != null) {
          _this.pairs.push(fbid);
          elem.addClass('pair');
          return elem.find('.photo').append("<img class='pair' src='assets/img/pair.png' />");
        }
      }
    });
  };

  Search.prototype.remove = function(fbid) {
    this.crushes.splice(_.indexOf(this.crushes, fbid), 1);
    return $.ajax('/crushes', {
      type: 'DELETE',
      dataType: 'json',
      data: {
        to: fbid
      }
    });
  };

  Search.prototype.bind = function() {
    var searchAction, that;
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
    searchAction = _.debounce(function() {
      var searchBy;
      searchBy = $('#search-query').val();
      console.log(searchBy);
      if (!(searchBy != null) || searchBy === '') {
        return;
      }
      $("#filters #" + that.filterBy).removeClass('active');
      that.filterBy = 'search';
      $("#filters #all").addClass('active');
      if (searchBy !== that.searchBy) {
        that.searchBy = searchBy;
        return that.render();
      }
    }, 500);
    $('#search-query').keypress(searchAction);
    $('#search-query').focus(searchAction);
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
    var filtered, regexp,
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
    } else if (this.filterBy === 'search') {
      if (this.searchBy != null) {
        regexp = new RegExp(this.searchBy, "i");
        filtered = _.filter(filtered, function(friend) {
          if (friend.name.search(regexp) > -1) {
            return true;
          }
          return false;
        });
      }
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
      $('#rundown').fadeIn();
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
      content += "<img class='pair' src='assets/img/pair.png' />";
    }
    content += "</div>" + ("<p>" + friend.name + "</p>") + ("<a data-uid='" + friend.uid + "' class='pick " + picked + "'><i class='icon-heart'></i>Crush</a>") + "</div>" + "</div>";
    return $('#friends').append(content);
  };

  return Search;

})();
