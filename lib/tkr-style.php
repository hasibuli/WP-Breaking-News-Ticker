<?php function wpbnt_dynamicCSS()
{ ?>
<style type="text/css">
.wpbnt_body {
  background: <?php $wpbnt_bg_color = get_option('wpbnt_bg_color'); if(!empty($wpbnt_bg_color)) {echo $wpbnt_bg_color;} else {echo "#2d81c8";}?>;
  border-radius:<?php $wpbnt_border_radius = get_option('wpbnt_border_radius'); if(!empty($wpbnt_border_radius)) {echo $wpbnt_border_radius;} else {echo "15";}?>px;
}
.wpbnt_body ul{margin:0; padding:0;}
.fade,.slide {
    background: <?php $wpbnt_bg_color = get_option('wpbnt_bg_color'); if(!empty($wpbnt_bg_color)) {echo $wpbnt_bg_color;} else {echo "#2d81c8";}?>;
}
.nhtColor {
	display:none !important;
}
.typing{
	padding-left:18px;
}
.fade > li,.slide > li,.typing > li {
    list-style: none inside none;
}
.label{color:<?php $wpbnt_label_color = get_option('wpbnt_label_color'); if(!empty($wpbnt_label_color)) {echo $wpbnt_label_color;} else {echo "#FFF";}?>;
font-weight:bold; font-size:15px;}
.wpbnt_body ul li a{color:<?php $wpbnt_hover_color = get_option('wpbnt_hover_color'); if(!empty($wpbnt_hover_color)) {echo $wpbnt_hover_color;} else {echo "#FFF";}?>;
border:0 none !important;}
</style>
<?php 
}
add_action('wp_footer','wpbnt_dynamicCSS', 100);
?>
