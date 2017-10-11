<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
 //Welukaオプション用
 global $post, $welukaContainerClass, $welukaPageSetting, $welukaLayout, $welukaOnepageMode, $welukaRightSidebarNo, $welukaOutContainerType, $welukaThemeOptions;

 if( isset( $_GET['mode'] ) && $_GET['mode'] === 'cp' ) {
 	$welukaLayout = WelukaThemeOptions::LAYOUT_TWO_COL_RIGHT;
 } else {
 	//v1.0.6
 	$_const = 'WelukaThemeOptions::ARCHIVE_LAYOUT';
 	if ( defined ( $_const ) ) :
 		if( is_home() || is_front_page() ) :
 			$welukaLayout = get_weluka_theme_layout( WelukaThemeOptions::HOME_LAYOUT );
 		elseif( is_archive() || is_search() ) :	//v1.0.6
 			$welukaLayout = get_weluka_theme_layout( WelukaThemeOptions::ARCHIVE_LAYOUT );
 		elseif( is_page() && ! is_attachment() ) :	//v1.0.6
 			$welukaLayout = get_weluka_theme_layout( WelukaThemeOptions::PAGE_LAYOUT );
 		elseif( is_single() && ! is_attachment() ) :	//v1.0.6
 			$welukaLayout = get_weluka_theme_layout( WelukaThemeOptions::POST_LAYOUT );
 		else :
 			$welukaLayout = get_weluka_theme_layout( WelukaThemeOptions::COMMON_LAYOUT );
 		endif;
 	else :
 		if( is_home() || is_front_page() ) :
 			$welukaLayout = get_weluka_theme_layout( WelukaThemeOptions::HOME_LAYOUT );
 		else :
 			$welukaLayout = get_weluka_theme_layout( WelukaThemeOptions::COMMON_LAYOUT );
 		endif;
 	endif;
 }

 //v1.1 add modify
 if( ! is_singular( array( Weluka::$settings['cpt_ft'], Weluka::$settings['cpt_sd'] ) ) ) {
 	//v1.0.2
 	$welukaPageSetting	= get_weluka_page_setting();
 	$welukaOnepageMode = !empty( $welukaPageSetting['onepage'] ) ? $welukaPageSetting['onepage'] : 0;
 } else {
 	$welukaPageSetting	= array();
 	$welukaOnepageMode = 0;
 }
 //v1.1 add modify end

 //case top
 if( is_home() || is_front_page() ) {
 	if( !is_singular() ) {
 		$welukaPageSetting	= array();
 		$welukaOnepageMode	= 0;
 	}
 }
 //v1.0.2 end

 //ver1.0.1
 $welukaOutContainerType = !empty( $welukaPageSetting['out_container_type'] ) ? $welukaPageSetting['out_container_type'] : '';
 //ver1.0.1 addend
 $_hideHeader = !empty( $welukaPageSetting['hide_hd'] ) ? $welukaPageSetting['hide_hd'] : 0;

 // phpQueryをロードする
     require_once("phpQuery-onefile.php");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php wp_title(); ?></title>
	<?php wp_head(); ?>
</head>
<div class="navbar-header clearfix">
  <a class="navbar-toggle">
  <span class="icon-bar"></span>
  </a>
  </div>

<div class="cmenu-nav">
    <div class="cmenu-navigation-wrapper">            
  <?php wp_nav_menu( array( 'theme_location' => 'custom-header-menu', 'menu_class' => 'nav-menu') ); ?>
    </div> 
  </div>
  <div class="main-body">
  <body <?php body_class(); ?>>
