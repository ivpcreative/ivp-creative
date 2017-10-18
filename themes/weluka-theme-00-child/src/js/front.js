/* front.js；管理画面やWelukaページビルダーで動作させたくない。初期状態がhiddenなど。
load時にKICK*/

jQuery(function() {
         new WOW().init();


  frontJsObj = new frontJs();

  var url = window.location;

  jQuery(document).on('ready', function () {
    jQuery('.ls-home2--web').wrap( "<a class='link-home2-blog' href='/web'></a>" );
    jQuery('.ls-home2--wp').wrap( "<a class='link-home2-blog' href='/wp'></a>" );
    jQuery('.ls-home2--seo').wrap( "<a class='link-home2-blog' href='/seo'></a>" );

    jQuery('.p-home2-top--img01, .p-home2-top--logo, .p-home2-top--btn,.p-home2-top--tile02, .lc-home2-webvalue--tile02,.lc-home2-webvalue--tile01,.p-home2-top--img02,.lc-home2-top--tile01').addClass('wow slideInDown');
    jQuery('.p-home2-top--img01, .p-home2-top--logo, .p-home2-top--btn,.p-home2-top--tile02, .lc-home2-webvalue--tile02,.lc-home2-webvalue--tile01,.p-home2-top--img02,.lc-home2-top--tile01,.p-home2-service').attr('data-wow-duration','3s');
    jQuery('.p-home2-top--img01, .p-home2-top--logo, .p-home2-top--btn').attr("data-wow-delay","0.4s");
    jQuery('.p-home2-top--tile02, .lc-home2-webvalue--tile02').attr("data-wow-delay","0.7s");
    jQuery('.lc-home2-webvalue--tile01').attr("data-wow-delay","0.9s");
    jQuery('.p-home2-top--img02,.lc-home2-top--tile01').attr("data-wow-delay","1s");
    jQuery('.p-home2-service').addClass("wow bounceIn");

 });

  jQuery('.navbar-toggle').on('click', function () {
    jQuery("body").toggleClass("nav-is-open");
    jQuery('.navbar-toggle').toggleClass("activeNav rotateLeft rotateRight");
  });
});
    //frontのみ
    //t-scroll.min.js

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
