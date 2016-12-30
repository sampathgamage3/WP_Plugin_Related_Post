<?php
if(!class_exists('WP_Related_Posts_class_data')) :

class WP_Related_Posts_class_data {


    function getRelatedPosts($postID) {
        global $wpdb;
        	
        $post_categories = wp_get_post_categories( $postID, $args = array() );
        $category = get_category($post_categories[0])->slug;  

        $posts_array = array();
 
 
		 $args = array (
			'posts_per_page'   => 3,
			'offset'           => 0,
			'category'         => '',
			'category_name'    => $category,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => $postID,
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'post',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'author'	   => '',
			'author_name'	   => '',
			'post_status'      => 'publish',
			'suppress_filters' => true 
			  );
		 
		 $posts_array = get_posts( $args ); 
		 
		?>
           

      	<div class="row">
        	  <?php   foreach( $posts_array as $post ) :   ?>
                <div class="col-md-4">

                  <h2><?php echo $post->post_title; ?></h2>
                  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                  <img class="img-responsive" src="<?php echo $image[0]; ?>" alt=""> 
                  <p>
                  	<?php 
                      $content = $post->post_content;
                      $length_content = strlen($content);
                      echo ($length_content > 150 ? substr($content , 0, 150).'...':$content); 
                      ?>
                  </p>
                  <p><a class="btn btn-secondary" href="<?php echo get_permalink($post->ID); ?>" role="button">View More »</a></p>
                </div>
            
               <?php
            
            endforeach;
     
            // Reset Query
             wp_reset_query();
                ?> 
     	</div>

    <?php 	  
       exit();
    }

}
    
endif;
?>