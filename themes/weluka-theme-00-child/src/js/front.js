/* front.js；管理画面やWelukaページビルダーで動作させたくない。初期状態がhiddenなど。
load時にKICK*/

jQuery(function() {

  frontJsObj = new frontJs();

  var url = window.location;

  jQuery(document).on('ready', function () {
    jQuery('.ls-home2--web').wrap( "<a class='link-home2-blog' href='/web'></a>" );
    jQuery('.ls-home2--wp').wrap( "<a class='link-home2-blog' href='/wp'></a>" );
    jQuery('.ls-home2--seo').wrap( "<a class='link-home2-blog' href='/seo'></a>" );

  });

  jQuery('.navbar-toggle').on('click', function () {
    jQuery("body").toggleClass("nav-is-open");
    jQuery('.navbar-toggle').toggleClass("activeNav rotateLeft rotateRight");
  });


  jQuery(window).on('load resize', function () {
    var winSize = screen.width;
    if(winSize <= 768){

    }
    else{
    jQuery('.ls-top').css('visibility','visible'); //表示
    jQuery('.ls-top').addClass('t-animated'); //開いた瞬間にアニメーションさせる。


    //home2

    jQuery('.lc-home2-webvalue--tile01').css('visibility','visible');
    jQuery('.lc-home2-webvalue--tile02').css('visibility','visible');
    jQuery('.ls-home2-pc--top').css('visibility','visible'); //表示
    jQuery('.p-home2-top--img01, .p-home2-top--logo, .p-home2-top--btn').addClass('fadeFirst fadeDown t-animated');
    jQuery('.p-home2-top--tile02, .lc-home2-webvalue--tile02').addClass('fadeSecond fadeDown t-animated');
    jQuery('.lc-home2-webvalue--tile01').addClass('fadeThird fadeDown t-animated');
    jQuery('.p-home2-top--img02').addClass('fadeFourth fadeDown t-animated');
    jQuery('.lc-home2-top--tile01').addClass('fadeFifth fadeDown t-animated');

//home
    Tu.tScroll({
      't-element': '.ls-top',
      't-animate': 'rollDown',
      't-delay': 1
    })

    Tu.tScroll({
      't-element': '.c-img',
      't-animate': ' rollUp'
    })

//home2
    Tu.tScroll({
      't-element': '.fadeFirst',
      't-animate': 'fadeDown',
      't-duration':2,
      't-delay': 0.4
    })

    Tu.tScroll({
      't-element': '.fadeSecond',
      't-animate': 'fadeDown',
      't-duration':2,
      't-delay': 0.7
    })

    Tu.tScroll({
      't-element': '.fadeThird',
      't-animate': 'fadeDown',
      't-duration':2,
      't-delay': 0.9
    })

     Tu.tScroll({
      't-element': '.fadeFourth',
      't-animate': 'fadeDown',
      't-duration':2,
      't-delay': 1
    })

    Tu.tScroll({
      't-element': '.fadeFifth',
      't-animate': 'fadeDown',
      't-duration':2,
      't-delay': 1
    })

    Tu.tScroll({
      't-element': '.lc-home2-service',
      't-animate': 'zoomOut',
      't-duration':0.7
    })
  }
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
