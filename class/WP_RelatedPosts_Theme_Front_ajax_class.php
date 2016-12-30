<?php
if(!class_exists('WP_RelatedPosts_Theme_Front_ajax_class')) :

class WP_RelatedPosts_Theme_Front_ajax_class {

        function __construct() {
                    
            add_action( 'wp_ajax_wprp-get-related-posts', array(&$this, 'wprp_get_related_posts'));/*  */
            add_action( 'wp_ajax_nopriv_wprp-get-related-posts', array(&$this, 'wprp_get_related_posts'));/*  */ 
            
        }

        private function checkAuth () {
            //nonce check
            $nonce = $_POST['pgnonce'];
            if ( ! wp_verify_nonce( $nonce, 'wprp-ajax-ralated_posts-option-nonce' )) die ( 'Invalid Request!');

            //check user permissions 
            if(!current_user_can('edit_dashboard')) die ( 'You don\'t have sufficient permissions to continue with the operation!');
            

            return true;
        }

        private function FrontcheckAuth () {
            //nonce check
            $nonce = $_POST['pgnonce'];
            if ( ! wp_verify_nonce( $nonce, 'wprp-ajax-ralated_posts-option-nonce' )) die ( 'Invalid Request!');

             
            return true;
        }
        
        private function _exit (){
            exit();
        }

      
        function wprp_get_related_posts(){ 

            $callFunc = new WP_Related_Posts_class_data();
            $this->FrontcheckAuth();

            $postID = $_POST['postID'];

            $results = $callFunc->getRelatedPosts($postID); 

            return $results; 
            
            exit();
        }

    }
    
endif;
?>