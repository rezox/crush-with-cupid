var Choose;

Choose = (function() {

  function Choose() {
    this.populate();
  }

  Choose.prototype.populate = function() {
    var _this = this;
    return $.ajax('/friends', {
      dataType: "json",
      success: function(response) {
        return _this.renderAll(response);
      }
    });
  };

  Choose.prototype.renderAll = function(data) {
    return data.forEach(this.renderOne);
  };

  Choose.prototype.renderOne = function(data) {
    return $('#friends').append("<div class='span2' data-fbid='" + data.name + "''><img src='" + data.pic_square + "' /><p>" + data.name + "</p></div>");
  };

  return Choose;

})();
