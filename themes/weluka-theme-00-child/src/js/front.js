/* front.js；管理画面やWelukaページビルダーで動作させたくない。初期状態がhiddenなど。
load時にKICK*/

jQuery(function() {

  frontJsObj = new frontJs();

  var url = window.location;

    //frontのみ
    //t-scroll.min.js
    jQuery('.ls-top').css('visibility','visible'); //表示
    jQuery('.ls-top').addClass('t-animated'); //開いた瞬間にアニメーションさせる。

/*
    jQuery('.ls-top').attr({
  'data-t-show': '1'
    });
*/
    Tu.tScroll({
      't-element': '.ls-top',
      't-animate': 'rollDown',
      't-delay': 2
    })

    Tu.tScroll({
      't-element': '.c-img',
      't-animate': ' rollUp'
    })

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
