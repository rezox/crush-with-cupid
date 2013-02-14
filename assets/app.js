var Frontpage;Frontpage=function(){function e(){$("body").css("background",'url("assets/img/background.jpg")').css("background-size","cover").css("background-repeat","no-repeat")}return e}();var Search,__bind=function(e,t){return function(){return e.apply(t,arguments)}};Search=function(){function e(){this.filter=__bind(this.filter,this),this.add=__bind(this.add,this);var e=this;this.access_token=FB.getAuthResponse().accessToken,this.populate(),FB.api("/me",function(t){return e.filterBy="all",t.gender==="female"?e.filterBy="male":t.gender==="male"&&(e.filterBy="female"),$("#filters #"+e.filterBy).addClass("active"),e.render()})}return e.prototype.reset=function(){return this.friends=null,this.crushes=null,this.pairs=null},e.prototype.populate=function(){var e=this;return this.reset(),$.ajax("/crushes",{dataType:"json",success:function(t){return e.crushes=t,e.render()},error:function(){return e.crushes=[]}}),$.ajax("/pairs",{dataType:"json",success:function(t){return e.pairs=t,e.render()},error:function(){return e.pairs=[]}}),FB.api({method:"fql.query",query:"SELECT uid, name, sex FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())"},function(t){return e.friends=t,e.render()})},e.prototype.add=function(e,t){var n=this;return this.crushes.push(e),$.ajax("/crushes",{type:"POST",dataType:"json",data:{to:e},success:function(r){if(r.paired!=null)return n.pairs.push(e),t.addClass("pair"),t.find(".photo").append("<img class='pair' src='assets/img/pair.png' />")}})},e.prototype.remove=function(e){return this.crushes.splice(_.indexOf(this.crushes,e),1),$.ajax("/crushes",{type:"DELETE",dataType:"json",data:{to:e}})},e.prototype.bind=function(){var e;return e=this,$(".pick").click(function(){var t,n;n=$(this).attr("data-uid"),t=$(this).closest(".friend");if(t.hasClass("pair"))return;return _.contains(e.crushes,n)?(t.removeClass("picked"),e.remove(n)):(t.addClass("picked"),e.add(n,t))}),$("#filters div, #filters #all, #filters i").click(function(){var t;t=$(this).attr("data-filter");if(t!==e.filterBy)return $("#filters #"+e.filterBy).removeClass("active"),$(this).addClass("active"),e.filterBy=t,e.render()})},e.prototype.filter=function(e){var t,n=this;t=this.friends;if(this.filterBy==="heart")t=_.filter(t,function(e){return _.contains(n.crushes,e.uid)});else if(this.filterBy==="male"||this.filterBy==="female")t=_.where(t,{sex:this.filterBy});return t},e.prototype.render=function(){var e,t=this;if(this.friends==null||this.crushes==null||this.filterBy==null||this.pairs==null)return;return e=this.filter(),$("#friends").fadeOut(function(){return $("#friends").html(""),_.each(e,function(e){var n;return n="https://graph.facebook.com/"+e.uid+"/picture?height=320&width=320&access_token="+t.access_token,t.renderOne(e,_.contains(t.crushes,e.uid),_.contains(t.pairs,e.uid),n)}),$("#filters").fadeIn(),$("#friends").fadeIn(function(){return t.bind()})})},e.prototype.renderOne=function(e,t,n,r){var i,s,o;return o="",t&&(o="picked"),s="",n&&(s="pair"),i="<div class='friend "+o+" "+s+"'>"+"<div class='content'>"+"<div class='photo'>"+("<img src='"+r+"' />"),n&&(i+="<img class='pair' src='assets/img/pair.png' />"),i+="</div>"+("<p>"+e.name+"</p>")+("<a data-uid='"+e.uid+"' class='pick "+o+"'><i class='icon-heart'></i>Crush</a>")+"</div>"+"</div>",$("#friends").append(i)},e}();