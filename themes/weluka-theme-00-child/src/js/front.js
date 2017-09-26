/* front.js；管理画面やWelukaページビルダーで動作させたくない。初期状態がhiddenなど。
load時にKICK*/
jQuery(function() {

  frontJsObj = new frontJs();


  var url = window.location;
  if (url.href.indexOf('weluka') == -1) { //front表示のみ(Welukaビルダーでは動作しない)
    //frontのみ
    //t-scroll.min.js
    jQuery('.c-img').addClass('zoomOut');
    Tu.tScroll({
      't-element': '.zoomOut'
    })


  } else {
    //ビルダーのみ

  }

});
/*end.load時にkick*/

/* subJsオブジェクト生成コンストラクタ */
var frontJs = function() {

  //アンカーを#から？でも使用可能。例）http://url.com/partner/?partner1
  this.sub_anchor = function() {
    var query = document.location.search.substring(1);
    if (query) {
      var obj = document.getElementById(query);
      if (obj) {
        y = obj.offsetTop;
        scrollTo(0, y);
      }
    }
  }

  /*Sectionの表示効果(http://www.north-geek.com/entry/js-scroll)*/



}
