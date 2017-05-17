<?php
/**
子function.php(子→親 の順でread)
 */
//同ディレクトリのstule.css を読み込む
//https://github.com/wckansai2016/plugin-hands-on/blob/master/plugin_hands_on_4.md
function add_file_links() {
    wp_enqueue_style( 'child-foundation-css', get_stylesheet_directory_uri() .'/css/foundation.css' ); //CSS
    wp_enqueue_style( 'child-layout-css', get_stylesheet_directory_uri() .'/css/layout.css' ); //CSS
    wp_enqueue_style( 'child-object-utility-css', get_stylesheet_directory_uri() .'/css/object/utility.css' ); //CSS
    wp_enqueue_style( 'child-object-component-css', get_stylesheet_directory_uri() .'/css/object/component.css' ); //CSS
    wp_enqueue_style( 'child-object-project-css', get_stylesheet_directory_uri() .'/css/object/project.css' ); //CSS

    wp_enqueue_style( 'child-sub-free-css', get_stylesheet_directory_uri() . '/css/sub-free.css' ); //CSS
    //wp_enqueue_script( 'child-library-jquery-fixHeightSimple', get_stylesheet_directory_uri() . '/js/library/jquery-fixHeightSimple.js' ); // 行の高さをそろえるプラグイン
    wp_enqueue_script( 'child-library-jquery-rwdImageMaps', get_stylesheet_directory_uri() . '/js/library/jquery.rwdImageMaps.min.js' ); // イメージマップをレスポンシブ対応させる
    wp_enqueue_script( 'child-common-js', get_stylesheet_directory_uri() . '/js/sub-common-js.js' ); //JS
    wp_enqueue_script( 'child-sub-free-js', get_stylesheet_directory_uri() . '/js/sub-free-js.js' ); //JS

}



//'wp_enqueue_scripts'はワードプレスに登録してあるスクリプトを読み込むタイミングで実行する。
//→※wp_enqueue_scripts アクションフックは登録されているスクリプトを読み込むタイミングで実行されるものです。
//上の関数を実行


/*どのスタイルシートよりも遅く読ませるため、200 に設定*/
add_action( 'wp_enqueue_scripts', 'add_file_links',200 );
//管理が目のpost.php でも読み込ませる
add_action('admin_head-post.php', 'add_file_links',200 );


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



/*-------------------------------------------*/
/*  ショートコードで治療法ページ共通のアンカーリンクを呼び出す
/*-------------------------------------------*/
function getTherapyAnc() {
/* ボタンを変数化*/
$ankerlink = <<<EOT
<ul class="list-line">
<li><a class="menu" href="#comment">治療法の解説</a></li>
<li><a class="menu" href="#flow">治療当日の流れ</a></li>
<li><a class="menu" href="#point">治療のポイント</a></li>
<li><a class="menu" href="#price">料金</a></li>
</ul>
EOT;

return $ankerlink ;
}
add_shortcode('therapy-anc', 'getTherapyAnc');

/*-------------------------------------------*/
/*  ショートコードでWEBボタンを呼び出す
/*-------------------------------------------*/
function getBtnWeb() {
/* ボタンを変数化*/
$ankerlink = <<<EOT
<a href="/mail_reservation/">
<img class="img-responsive img-webbtn" src="/wp-content/uploads/nav/ico-contact01.png" alt="" width="" height="">
</a>
EOT;

return $ankerlink ;
}
add_shortcode('btn-web', 'getBtnWeb');

/*-------------------------------------------*/
/*  ショートコードでカテゴリ一覧を呼び出す
/*-------------------------------------------*/


//　一覧記事取得関数 --------------------------------------------------------------------------------
// "num" = 表示記事数, "cat" = カテゴリスラング "body" = 記事本文の抜粋を表示するか？
// 呼び出し元での指定も可能 -> [getCategoryArticle num="x" cat="y" body="true"]
function getCatItems($atts, $content = null) {
	extract(shortcode_atts(array(
	  "num" => '2',
	  "cat" => '12',
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
		$retHtml = '<div class="getPostDispArea">';
		// 取得した記事の個数分繰り返す
		foreach($myposts as $post) :
			// 投稿ごとの区切りのdiv
			$retHtml .= '<div class="getPost">';

			// 記事オブジェクトの整形
			setup_postdata($post);

			// サムネイルの有無チェック
			if ( has_post_thumbnail() ) {
				// サムネイルがある場合↓
				$retHtml .= '<div class="getPostImgArea">' . get_the_post_thumbnail($page->ID, 'thumbnail') . '</div>';
			} else {
				// サムネイルがない場合↓※何も表示しない
				$retHtml .= '';
			}
			
			// 文章のみのエリアをdivで囲う
			$retHtml .= '<div class="getPostStringArea">';
			
			// 投稿年月日を取得
			$year = get_the_time('Y');	// 年
			$month = get_the_time('n');	// 月
			$day = get_the_time('j');	// 日
			
			//$retHtml .= '<span>この記事は' . $year . '年' . $month . '月' . $day . '日に投稿されました</span>';
			
			// タイトル設定(リンクも設定する)
			$retHtml.= '<h4 class="getPostTitle">';
			$retHtml.= '<a href="' . get_permalink() . '">' . the_title("","",false) . '</a>';
			$retHtml.= '</h4>';
		//日付
            $getDate = get_the_date();
            $retHtml.= '<div class="getPostDate">' . $getDate . '</div>';
			// 本文を抜粋して取得

        if($body == 'true'){
			$getString = get_the_excerpt();
			$retHtml.= '<div class="getPostContent">' . $getString . '</div>';
            }
			$retHtml.= '</div></div>';
			
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


?>