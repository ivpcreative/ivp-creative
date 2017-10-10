<?php
/*
子function.php(子→親 の順でread)
 */
//同ディレクトリのstyle.css を読み込む
//https://github.com/wckansai2016/plugin-hands-on/blob/master/plugin_hands_on_4.md


function getOptionPass(){
  $cmp = 'src'; //dest:圧縮　/src:元
  return $cmp;
}

function add_file_links() {
      $cmp =  getOptionPass();
wp_enqueue_style( 'child-app-css', get_stylesheet_directory_uri() .'/'. $cmp .'/css/app.css' ); //CSS
wp_enqueue_style( 'child-t-scroll-css', get_stylesheet_directory_uri() .'/'. $cmp .'/css/t-scroll.min.css' ); //CSS
    //wp_enqueue_script( 'child-library-jquery-fixHeightSimple', get_stylesheet_directory_uri() . '/js/library/jquery-fixHeightSimple.js' ); // 行の高さをそろえるプラグイン
    wp_enqueue_script( 'child-library-jquery-rwdImageMaps', get_stylesheet_directory_uri() . '/'. $cmp .'/js/library/jquery.rwdImageMaps.min.js' ); // イメージマップをレスポンシブ対応させる
      wp_enqueue_script( 'child-library-jquery-t-scrool', get_stylesheet_directory_uri() . '/'. $cmp .'/js/library/t-scroll.min.js' ); // イメージマップをレスポンシブ対応させる
    //wp_enqueue_script( 'child-library-jquery-scroll', get_stylesheet_directory_uri() . '/'. $cmp .'/js/library/t-scroll.js' ); // 動きを出す
    wp_enqueue_script( 'child-common-js', get_stylesheet_directory_uri() . '/'. $cmp .'/js/common.js' ); //JS

}

/*初期状態がhidden等、管理画面やwelukaでは表示させないファイル*/
function add_file_links_front() {
  $cmp =  getOptionPass();
  wp_enqueue_script( 'child-front-js', get_stylesheet_directory_uri() . '/'. $cmp .'/js/front.js' ); //JS
    wp_enqueue_style( 'child-front-css', get_stylesheet_directory_uri() . '/'. $cmp .'/css/front.css' ); //JS
}

/*ユーザーが自由に記載できるCSS、JS。初期状態はカラ。*/
function add_file_links_free() {
      //wp_enqueue_style( 'child-free-css', get_stylesheet_directory_uri() .'/dest/css/free.css' ); //CSS
      //wp_enqueue_script( 'child-free-js', get_stylesheet_directory_uri() . '/dest/js/free.js' ); //JS
}


//'wp_enqueue_scripts'はワードプレスに登録してあるスクリプトを読み込むタイミングで実行する。
//→※wp_enqueue_scripts アクションフックは登録されているスクリプトを読み込むタイミングで実行されるものです。
//上の関数を実行
/*どのスタイルシートよりも遅く読ませるため、200 に設定*/
add_action( 'wp_enqueue_scripts', 'add_file_links',200 );
//管理が目のpost.php でも読み込ませる
add_action('admin_head-post.php', 'add_file_links',200 );

/*フロントのみ有効にしたいCSS/JS 重に初期状態がhiddenであるCSSやJS welukaサイトビルダーも非表示にしたい*/
$uri = $_SERVER["REQUEST_URI"];
if(!strstr($uri,'weluka_')){
add_action( 'wp_enqueue_scripts', 'add_file_links_front',300 );
}
/*ユーザーが自由に記載できるCSS、JS。初期はカラ。不要ならばコメントアウト*/
//add_action( 'wp_enqueue_scripts', 'add_file_links_free',400 );
//add_action('admin_head-post.php', 'add_file_links_free',400 );


/*リンクを絶対パスに変更*/
function delete_hostname_from_attachment_url( $url ) {
    $regex = '/^http(s)?:\/\/[^\/\s]+(.*)$/';
    if ( preg_match( $regex, $url, $m ) ) {
        $url = $m[2];
    }
    return $url;
}
add_filter( 'wp_get_attachment_url', 'delete_hostname_from_attachment_url' );
add_filter( 'attachment_link', 'delete_hostname_from_attachment_url' );

/*固定ページにカテゴリ・タグを追加*/
add_action('init', 'karakuri_add_category_to_page');
function karakuri_add_category_to_page()
{
	register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'karakuri_add_tag_to_page');
function karakuri_add_tag_to_page()
{
	register_taxonomy_for_object_type('post_tag', 'page');
}

/*-------------------------------------------*/
/*  <head>タグ内に自分の追加したいタグを追加する
/*-------------------------------------------*/
function add_wp_head_custom(){ ?>

<?php //get_template_part('header-sns');?>

<?php }
add_action( 'wp_head', 'add_wp_head_custom',1);

function add_wp_footer_custom(){ ?>
<!-- footerに書きたいコード -->
<?php }
add_action( 'wp_footer', 'add_wp_footer_custom', 1 );

function register_header_menu() {
  register_nav_menu('custom-header-menu',__( 'Custom Header Menu' ));
}
add_action( 'init', 'register_header_menu' );



/*-------------------------------------------*/
/*  ショートコードでカテゴリ一覧を呼び出す
/*-------------------------------------------*/


//　一覧記事取得関数 --------------------------------------------------------------------------------
// "num" = 表示記事数, "cat" = カテゴリスラング "body" = 記事本文の抜粋を表示するか？
// 呼び出し元での指定も可能 -> [getCategoryArticle num="x" cat="y" body="true"]
function getCatItems($atts, $content = null) {
	extract(shortcode_atts(array(
	  "num" => '3',
	  "cat" => 'blog',
      "body" => 'true'
	), $atts));

	// 処理中のpost変数をoldpost変数に退避
	global $post;
	$oldpost = $post;

    $cat_id = get_category_by_slug($cat);//スラッグをカテゴリIDに変換
    $cat_id = $cat_id->cat_ID;

    //echo $cat_id."<br />";
	// カテゴリーの記事データ取得
	$myposts = get_posts('numberposts='.$num.'&order=DESC&orderby=post_date&category='.$cat_id);

	if($myposts) {
		// 記事がある場合↓
		$retHtml = '<div class="p-postdisp p-postdisp--home">';
		// 取得した記事の個数分繰り返す
		foreach($myposts as $post) :
			// 投稿ごとの区切りのdiv
			//$retHtml .= '<div class="p-post p-post--home">';
      $retHtml .= '<li class="p-post p-post--home">';

      // 投稿年月日を取得
			$year = get_the_time('Y');	// 年
			$month = get_the_time('n');	// 月
			$day = get_the_time('j');	// 日
      //日付


			// 記事オブジェクトの整形
			setup_postdata($post);

			// サムネイルの有無チェック
			if ( has_post_thumbnail() ) {
				// サムネイルがある場合↓(サイズ指定を 'thumbnail' から 100×100 へ変更)
				$retHtml .= '<div class="p-postimg p-postimg--home">' . get_the_post_thumbnail($page->ID, array(200,100)) . '</div>';
			} else {
				// サムネイルがない場合↓※何も表示しない
				$retHtml .= '';
			}

			// 文章のみのエリアをdivで囲う
			$retHtml .= '<div class="p-poststring p-poststring--home">';
      $getDate = get_the_date();
      //$retHtml.= '<div class="p-postdate p-postdate--home">' . $getDate . '</div>';

			//$retHtml .= '<span>この記事は' . $year . '年' . $month . '月' . $day . '日に投稿されました</span>';

			// タイトル設定(リンクも設定する)
			$retHtml.= '<h4 class="p-posttitle p-posttitle--home">';
			$retHtml.= '<a href="' . get_permalink() . '">' . $getDate .'<br />'.  the_title("","",false) . '</a>';
			$retHtml.= '</h4>';

			// 本文を抜粋して取得

        if($body == 'true'){
			$getString = get_the_excerpt();
			$retHtml.= '<div class="p-postcoment p-postcoment--home">' . $getString . '</div>';
            }
			$retHtml.= '</div></li>';

		endforeach;

		$retHtml.= '</div>';
	} else {
		// 記事がない場合↓
		$retHtml='<p>記事がありません。</p>';
	}

	// oldpost変数をpost変数に戻す
	$post = $oldpost;

	return $retHtml;
}
// 呼び出しの指定
add_shortcode("getCategoryArticle", "getCatItems");

//
function shortcode_buttun($arg) {
    extract(shortcode_atts(array (
        'text' => 'お問い合わせ',
        'href' => './',
        'target' => '',
        'type' => 'default'
    ), $arg));
    if($target != '') $target = ' target="'.$target.'"';
  return '<button class="l-btn type-'.$type.'"><a href="'.$href.'"'.$target.'>'.$text.'</a></button>';
}

add_shortcode('button', 'shortcode_buttun');

function get_site_info() {

  $article_title = wp_title( ' | ', false, 'right' ) . get_bloginfo('name'); // 記事のタイトル
  $site_info = array();
	$site_info =  array(
		'article_url' => get_permalink(),//記事のURL
		'article_title' => $article_title, // 記事のタイトル
		'article_url_encode' => urlencode(get_permalink()), // 記事URLエンコード
    'article_title_encode' => urlencode($article_title.''), // 記事タイトルエンコード
		'url_encode' => urlencode(get_permalink()),
		'title_encode' => urlencode(get_the_title()),
		'tw_title_encode' => urlencode(get_the_title()."")
	 );
  return $site_info;
}

function short_snsinfo($arg){
   $site_info = get_site_info();
  extract(shortcode_atts(array ( //パラメタ初期値
    'sns' => 'tw',
  ),$arg));

  switch ($sns) {
    case 'fb':
    $snsLink = 'http://www.facebook.com/sharer.php?src=bm&u='.$site_info['url_encode'].'&t='.$site_info['article_title'];
      break;
    default: //twitter
    $snsLink = 'https://twitter.com/intent/tweet?url='.$site_info['url_encode'].'&text='.$site_info['article_title_encode'];
      break;
  }

return $snsLink;
}
add_shortcode('snsinfo', 'short_snsinfo');
//テスト用
function hogeFunc() {
			return "ショートコード作ってみたよ。";
		}
		add_shortcode('hoge', 'hogeFunc');


?>
