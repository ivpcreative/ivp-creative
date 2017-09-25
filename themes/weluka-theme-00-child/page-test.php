<?php
/*
Template Name:page-test
*/
//get_header();
global $weluka_themename;
wp_head();

if ( have_posts() ) :
		get_template_part( 'content', get_post_format() );
?>
<?php
else:
	get_template_part( 'content', 'none' );

endif;
wp_footer();
?>
