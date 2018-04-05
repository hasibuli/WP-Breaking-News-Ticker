<?php
/*
Plugin Name: WP Breaking News Ticker
Plugin URI: http://www.e2soft.com/blog/wp-breaking-news-ticker/
Description: WP Breaking News Ticker is a wordpress plugin to show your breaking news or news headline on your website!  Use this shortcode <strong>[WPBNT-Ticker]</strong> in the post/page" where you want to display news head line.
Version: 1.0.1
Author: Ranu Akter
Author URI: http://www.e2soft.com/
Copyright: 2018 E2Soft Solution http://www.e2soft.com
License URI: license.txt
*/


#######################	WP Breaking News Ticker ###############################

/**
	Register Stylesheet and Javascript.
**/
function register_wpbnt_style()
{
	wp_enqueue_script( 'wpbnt-js', plugins_url('/js/wpbnt.js', __FILE__), array('jquery') );
	wp_enqueue_style( 'wpbnt-style', plugins_url('/css/wpbnt.css', __FILE__) );
}
add_action('wp_enqueue_scripts', 'register_wpbnt_style');

/**
	Register Admin Stylesheet and Javascript.
**/
function register_wpbnt_admin_style()
{
	wp_enqueue_style( 'wpbnt-admin', plugins_url('/css/wpbnt-admin.css', __FILE__) );
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
	wp_enqueue_script( 'cp-active', plugins_url('/js/cp-active.js', __FILE__), array('jquery'), '', true );
}
add_action( 'admin_enqueue_scripts', 'register_wpbnt_admin_style' ); 


/**
	Get post for create breaking news.
**/
function wpbnt_post_loop() 
{ ?>

<div class="wpbnt_body">
<div class="label">
  <?php 
	  	$wpbnt_label = get_option('wpbnt_label'); 
	  	if(!empty($wpbnt_label)) {echo $wpbnt_label;} else {echo "Breaking News:";}
	  ?>
</div>
<ul class="<?php $wpbnt_effect = get_option('wpbnt_effect');
				 if(!empty($wpbnt_effect)) {echo $wpbnt_effect;} else {echo "typing";}?>">
<?php    
	/**
		Get post data.
	**/	
	$wpbnt_post_category = get_option('wpbnt_post_category');
	$wpbnt_number_post = get_option('wpbnt_number_post'); 
	$wpbnt_order = get_option('wpbnt_order');
	
	/**
		Post query.
	**/		
	$wpbnt_args = array(
							'post_type' => 'post',
							'category_name' => $wpbnt_post_category,
							'showposts' => $wpbnt_number_post,
							'orderby' => 'date',
							'order' => $wpbnt_order
						  );
	$wpbnt_query = new WP_Query($wpbnt_args);
	while ($wpbnt_query->have_posts()) : $wpbnt_query->the_post(); 
	?>
<li><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
  <?php the_title(); ?>
  </a></li>
<?php
	endwhile; 
	wp_reset_query();
	echo '</ul></div>';
}

/**
	Create breaking news loop.
**/
function wp_breaking_news_ticker()
{
	return wpbnt_post_loop();
}
add_shortcode('WPBNT-Ticker', 'wpbnt_post_loop');


/**
	Define breaking news style type.
**/
function wpbnt_slide_script(){?>
<script>
jQuery(document).ready(function() {
    jQuery('.fade').inewsticker({
		speed       : 3000,
		effect      : 'fade',
		dir         : 'ltr',
		font_size   : 13,
		color       : '#fff',
		font_family : 'arial',
		delay_after : 1000		
	});
	jQuery('.slide').inewsticker({
		speed       : 2500,
		effect      : 'slide',
		dir         : 'ltr',
		font_size   : 13,
		color       : '#fff',
		font_family : 'arial',
		delay_after : 1000						
	});
	jQuery('.typing').inewsticker({
		speed           : 100,
		effect          : 'typing',
		dir             : 'ltr',
		font_size       : 13,
		color           : '#fff',
		font_family     : 'arial',
		delay_after : 1000,

				
	});
});	
</script>
<?php }
add_action('wp_footer', 'wpbnt_slide_script');


/**
	Get all php file.
**/
foreach ( glob( plugin_dir_path( __FILE__ )."lib/*.php" ) as $php_file )
    include_once $php_file;

/**
	Redirect to plugin settings page.
**/

register_activation_hook(__FILE__, 'wpbnt_plugin_activate');
add_action('admin_init', 'wpbnt_plugin_redirect');

function wpbnt_plugin_activate() {
    add_option('wpbnt_plugin_do_activation_redirect', true);
}

function wpbnt_plugin_redirect() {
    if (get_option('wpbnt_plugin_do_activation_redirect', false)) {
        delete_option('wpbnt_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("options-general.php?page=wp-breaking-news-ticker");
        }
    }
}
