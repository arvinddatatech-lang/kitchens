<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

// END ENQUEUE PARENT ACTION


function enqueue_slider_css_script(){
wp_enqueue_style( 'slider_slic', get_stylesheet_directory_uri() . '/slick.min.css', array(), '3.0');
wp_enqueue_style( 'slider_slick_the', get_stylesheet_directory_uri() . '/slick-theme.min.css', array(), '3.0');
wp_enqueue_script('slick_min', get_stylesheet_directory_uri() . '/slick.min.js', array(), '2.0', false);
wp_enqueue_script('jquery_min', get_stylesheet_directory_uri() . '/jquery.min.js', array(), '2.0', false);

wp_enqueue_style( 'js_shopfooter', get_stylesheet_directory_uri() . '/js_composer_front_custom.css', array(), '3.0');
if (is_front_page() || !is_home()) {
wp_enqueue_script('slider_script', get_stylesheet_directory_uri() . '/jquery.magnific-popup.js', array(), '2.0', true);
wp_enqueue_style( 'slider_css', get_stylesheet_directory_uri() . '/magnific-popup.css', array(), '3.0');
}
}
add_action('wp_enqueue_scripts','enqueue_slider_css_script');
function abhirawp_create_cf7_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cf7_entries';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        form_id int NOT NULL,
        submission_time datetime DEFAULT CURRENT_TIMESTAMP,
        data longtext NOT NULL,
		ip_data longtext NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
 }

 add_action('init', 'abhirawp_create_cf7_table');

 //register_activation_hook(__FILE__, 'abhirawp_create_cf7_table');

 add_action('wpcf7_before_send_mail', 'abhirawp_store_cf7_data');

  function abhirawp_store_cf7_data($contact_form) {
    global $wpdb;
    $submission = WPCF7_Submission::get_instance();
    if (!$submission) return;
    $data = $submission->get_posted_data();	
	$data['page-url'] = esc_url_raw($_SERVER['HTTP_REFERER']);	
    $form_id = $contact_form->id();
	$table = $wpdb->prefix . 'cf7_entries';
    $id = $wpdb->insert(
        $table,
        [
            'form_id' => $form_id,
            'data'    => json_encode($data),
			'ip_data'    => json_encode(get_IP_address()),
        ]
    );
    
  }


function get_IP_address()
{
    foreach (array('HTTP_CLIENT_IP',
                   'HTTP_X_FORWARDED_FOR',
                   'HTTP_X_FORWARDED',
                   'HTTP_X_CLUSTER_CLIENT_IP',
                   'HTTP_FORWARDED_FOR',
                   'HTTP_FORWARDED',
                   'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $IPaddress){
                $IPaddress = trim($IPaddress); // Just to be safe

                if (filter_var($IPaddress,
                               FILTER_VALIDATE_IP,
                               FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                    !== false) {

                    return $IPaddress;
                }
            }
        }
    }
}


add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
function woocommerce_template_single_add_to_cart() {
echo '<button type="submit" id="trigger_cf" class="button alt single_add_to_cart_buttons">Send us your enquiry</button>';
echo '<div id="product_inq" style="display:none">';
echo do_shortcode('[contact-form-7 id="c7c0b4b" title="Contact form 1"]');
echo '</div>';
?>
<script type="text/javascript">
        jQuery('#trigger_cf').on('click', function(){
        if ( jQuery(this).text() == 'Send us your enquiry' ) {
                    jQuery('#product_inq').css("display","block");
            jQuery("#trigger_cf").html('Close');
        } else {
            jQuery('#product_inq').hide();
            jQuery("#trigger_cf").html('Send us your enquiry');
        }
        });
    </script>
<?php
}
// function that runs when shortcode is called
function wpb_demo_shortcode($atts) {
      $attributes = shortcode_atts(
        array(
            'posttype' => 'post',
        ), 
        $atts
    );
   $post_type = esc_html($attributes['posttype']);
  $message ='';
  $args = array(
'post_type'=> $post_type ,
'orderby'    => 'ID',
'post_status' => 'publish',
'order'    => 'DESC',
'posts_per_page' => 6
);
$result = new WP_Query( $args );
if ( $result-> have_posts() ) :
  while ( $result->have_posts() ) : $result->the_post();
 $title = substr_replace(get_the_title() , '', 25);

  // $title = truncate( get_the_title() , 100 , $stopanywhere=false);
   $message .= "<li><a href='".get_the_permalink()."' class='generic-anchor footer-list-anchor'>".$title  ."</a></li>";
  endwhile;
  endif;
  wp_reset_postdata();   
return $message;
}
add_shortcode('getposts_6', 'wpb_demo_shortcode');
function wpb_menu_shortcode() {      
  $message ='';
    $array_menu = wp_get_nav_menu_items('Main Menu');   
    foreach ($array_menu as $m) {
        if (empty($m->menu_item_parent)) {
          $message .="<li><a class='generic-anchor footer-list-anchor' href='$m->url'>$m->title</a></li>";
        }
    }  
return $message;
}
add_shortcode('getmenu_main', 'wpb_menu_shortcode');

function link_settings_api_init() {    
    add_settings_section(
       'links_setting_section',
       'Social Links',
       'links_setting_section_callback_function',
       'general'
   );
    add_settings_field(
       'facebook_link',
       'Facebook Link',
       'facebook_function',
       'general',
       'links_setting_section'
   );
   add_settings_field(
        'twitter_link',
        'Twitter Link',
        'twitter_function',
        'general',
        'links_setting_section'
    );
    add_settings_field(
        'pinterest_link',
        'Pinterest Link',
        'pinterest_function',
        'general',
        'links_setting_section'
    );
    add_settings_field(
        'instagram_link',
        'Instagram Link',
        'instagram_function',
        'general',
        'links_setting_section'
    );
    add_settings_field(
        'youtube_link',
        'YouTube Link',
        'youtube_function',
        'general',
        'links_setting_section'
    );  
    
     add_settings_field(
        'phon_no',
        'Phon No',
        'phon_no_function',
        'general',
        'links_setting_section'
    );  
    register_setting( 'general', 'facebook_link' );
    register_setting( 'general', 'twitter_link' );
    register_setting( 'general', 'pinterest_link' );
    register_setting( 'general', 'instagram_link' );
    register_setting( 'general', 'youtube_link' );
    register_setting( 'general', 'phon_no' );
}
add_action( 'admin_init', 'link_settings_api_init' );
function links_setting_section_callback_function() {
    echo '<p>Add Social Media Links for HSPH</p>';
}
function facebook_function() {
$facebook_link = get_option( 'facebook_link', '' );
echo '<input id="facebook_link" style="width: 35%;" type="text" title="Facebook Link" name="facebook_link" value="' . sanitize_text_field($facebook_link) . '" />';
}
function twitter_function() {
$twitter_link = get_option( 'twitter_link', '' );
echo '<input id="twitter_link" style="width: 35%;" type="text" title="Twitter Link" name="twitter_link" value="' . sanitize_text_field($twitter_link) . '" />';
}
function pinterest_function() {
$pinterest_link = get_option( 'pinterest_link', '' );
echo '<input id="pinterest_link" style="width: 35%;" type="text" title="LinkedIn Link" name="pinterest_link" value="' . sanitize_text_field($pinterest_link) . '" />';
}
function instagram_function() {
$instagram_link = get_option( 'instagram_link', '' );
echo '<input id="instagram_link" style="width: 35%;" type="text" title="Instagram Link" name="instagram_link" value="' . sanitize_text_field($instagram_link) . '" />';
}
function youtube_function() {
$youtube_link = get_option( 'youtube_link', '' );
echo '<input id="youtube_link" style="width: 35%;" type="text" title="YouTube Link" name="youtube_link" value="' . sanitize_text_field($youtube_link) . '" />';
}
function phon_no_function() {
$phon_no = get_option( 'phon_no', '' );
echo '<input id="phon_no" style="width: 35%;" type="text" title="YouTube Link" name="phon_no" value="' . sanitize_text_field($phon_no) . '" />';
}
function menufooter_fn() {
    include_once('menufooter.php');
}
add_action( 'wp_footer', 'menufooter_fn' );

