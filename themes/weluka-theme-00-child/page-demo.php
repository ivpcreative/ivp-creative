<?php
/*
Template Name:page-demo
*/
get_header(); ?>
<div class="main-outer container">
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

       <p><?php _e( 'Set as position', 'aqueduct' ); ?></p>
        <p><?php _e( 'first', 'aqueduct' ); ?></p>
        <p><?php _e( 'second', 'aqueduct' ); ?></p>
        <p><?php _e( 'third', 'aqueduct' ); ?></p>
        <p><?php _e( 'This is a test', 'aqueduct' ); ?></p>
          <p><?php _e( 'text', 'aqueduct' ); ?></p>
    </main><!-- #main -->
  </div><!-- #primary -->
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
