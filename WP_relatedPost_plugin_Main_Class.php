<?php
/*
  Plugin Name: WP Related Posts Plugin
  Plugin URI: http://sampathgamage3.com
  Description: Dynamic related posts link plugin for wordpress
  Author: Sampath Gamage
  Version: 1.0
  Author URI: http://sampathgamage3.com
 */

/* Global Settings */
global $wpdb;
 

/* 

Path info 
WPRP =  Wordpress Related Posts 

*/

$pathinfo = pathinfo(__FILE__);
define('PLUGIN_WPRP_NAME', 'WP Related Posts Plugin');
define('WPRP_FULL_PATH', $pathinfo['dirname']);  //full path
define('WPRP_PATH', basename($pathinfo['dirname']));  //folder name
define('WPRP_FILE', $pathinfo['basename']);  //file name



include_once 'class/WP_RelatedPosts_Theme_Front_ajax_class.php'; 
include_once 'class/WP_Related_Posts_class_data.php'; 



if (class_exists('wp_related_posts_themeplugin_main'))  
    $wp_related_posts_main = new wp_related_posts_themeplugin_main(); 
else  
    exit ('class "class_data" not found!');
 
class  wp_related_posts_themeplugin_main{
    
    function  __construct() {

        register_activation_hook(__FILE__, array(&$this, 'install'));
        register_deactivation_hook( __FILE__, array(&$this, 'uninstall'));

        add_action('init', array(&$this, 'init_action'));
        add_action('admin_menu', array(&$this, 'admin_menu'));

    } 

    function install() {
        
    }

    function uninstall () {
         
    }

    function init_action() {

        add_filter ('the_content', 'insertRelatedPosts');

        function insertRelatedPosts($content) {
           if(is_single()) {
              $content.= '<div style="border:1px dotted #000; text-align:center; padding:10px;" id="asd">';
              $content.= '<h4>ENJOYED THIS ARTICLE?</h4>';
              $content.= '<p><a data-postid="'. get_the_ID() .'" style="cursor:pointer;" id="similar3" class="similar3" name="Similar 3">See Related Articles</a></p>';
              $content.= '</div>';
              $content.= '</hr>';
              $content.= '<div style="border:1px dotted #000; text-align:center; padding:10px;display:none;" class="related_articles_pool"></div>';
           }
           return $content;


        }
     
    wp_enqueue_script('jquery');
    if (!is_admin()) {

            if (file_exists(ABSPATH . 'wp-content/plugins/' . WPRP_PATH . '/css/bootstrap.css'))
                wp_register_style('wp_ralated_posts_option_bootstrap_css', plugins_url('/css/bootstrap.css', __FILE__), false, '1.0', 'all');

            if (file_exists(ABSPATH . 'wp-content/plugins/' . WPRP_PATH . '/css/style.css'))
                wp_register_style('wp_ralated_posts_option_style_css', plugins_url('/css/style.css', __FILE__), false, '1.0', 'all');    

            if (file_exists(ABSPATH . 'wp-content/plugins/' . WPRP_PATH . '/js/script.js'))
                wp_register_script('wp_ralated_posts_option_sscript_js', plugins_url('/js/script.js', __FILE__), array('jquery'), '1.0', false);
            
            if (file_exists(ABSPATH . 'wp-content/plugins/' . WPRP_PATH . '/js/frontScript.js'))
                wp_register_script('wp_ralated_posts_option_frontScript_js', plugins_url('/js/frontScript.js', __FILE__), array('jquery'), '1.0', false);

            $user = (current_user_can('edit_dashboard')) ? "admin" : "user";
            wp_localize_script('wp_ralated_posts_option_frontScript_js', 'WPRPSAM', array('ajaxurl' => admin_url('admin-ajax.php'), 'PGNonce' => wp_create_nonce('wprp-ajax-ralated_posts-option-nonce'), 'user' => $user));

            wp_enqueue_script('wp_ralated_posts_option_sscript_js'); 
            wp_enqueue_style('wp_ralated_posts_option_bootstrap_css'); 
            wp_enqueue_style('wp_ralated_posts_option_style_css'); 
            wp_enqueue_script('wp_ralated_posts_option_frontScript_js');
        } else {

            if (isset($_GET['page'])) {
                if ($_GET['page'] == WPRP_PATH . "/" . WPRP_FILE) {
                    wp_enqueue_script('jquery-ui-core');
                    wp_enqueue_script('jquery-ui-accordion');
                    wp_enqueue_script('jquery-ui-draggable');
                    wp_enqueue_script('jquery-ui-draggable');
                    wp_enqueue_script('jquery-ui-droppable');
                    wp_enqueue_script('farbtastic');
                    wp_enqueue_script('media-upload');
                    wp_enqueue_script('thickbox');
                    wp_enqueue_style('thickbox');
                    wp_enqueue_script('jquery-ui-sortable');
                    wp_enqueue_script('jquery-ui-dialog');

                    if (file_exists(ABSPATH . 'wp-content/plugins/' . WPRP_PATH . '/css/admin.css'))
                        wp_register_style('wp_ralated_posts_option_admin_css', plugins_url('/css/admin.css', __FILE__), false, '1.0', 'all');
                    
                    if (file_exists(ABSPATH . 'wp-content/plugins/' . WPRP_PATH . '/css/ui_custom.css'))
                        wp_register_style('wp_ralated_posts_option_ui_custom_css', plugins_url('/css/ui_custom.css', __FILE__), false, '1.0', 'all');

                    if (file_exists(ABSPATH . 'wp-content/plugins/' . WPRP_PATH . '/js/script.js'))
                        wp_register_script('wp_ralated_posts_option_script_js', plugins_url('/js/script.js', __FILE__), array('jquery'), '1.0', false);

                    if (file_exists(ABSPATH . 'wp-content/plugins/' . WPRP_PATH . '/js/jquery-ui.min.js'))
                        wp_register_script('wp_ralated_posts_option_jquery_ui_js', plugins_url('/js/jquery-ui.min.js', __FILE__), array('jquery'), '1.0', false);

                    $user = (current_user_can('edit_dashboard')) ? "admin" : "user";
                    wp_localize_script('wp_kyros_sports_option_script_js', 'WPRPSAM', array('ajaxurl' => admin_url('admin-ajax.php'), 'PGNonce' => wp_create_nonce('wprp-ajax-ralated_posts-option-nonce'), 'user' => $user));

                    wp_enqueue_style('wp_ralated_posts_option_admin_css');
                    wp_enqueue_style('wp_ralated_posts_option_ui_custom_css'); 
                    wp_enqueue_script('wp_ralated_posts_option_script_js'); 
                    wp_enqueue_script('wp_ralated_posts_option_jquery_ui_js');
                }
            }
        }
    }

    function admin_menu() {

        
    }
    
    

}
 
 
/* ajax  */
if(class_exists('WP_RelatedPosts_Theme_class_ajax')) new WP_RelatedPosts_Theme_class_ajax();
if(class_exists('WP_RelatedPosts_Theme_Front_ajax_class')) new WP_RelatedPosts_Theme_Front_ajax_class();