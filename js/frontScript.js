jQuery(document).ready(function() {
    
    // Start Js Ajax Function for Load Related Articles

    jQuery(document).on('click','.similar3',function(e){

          e.preventDefault(); 
          jQuery('.related_articles_pool').empty();
          var postID = jQuery(this).attr('data-postid');

          jQuery.ajax({
              url : WPRPSAM.ajaxurl,
              type : 'post',
              data : {
                action : 'wprp-get-related-posts',
                  pgnonce : WPRPSAM.PGNonce,
                  postID : postID,  
              },
              success : function( response ) {
                 jQuery('.related_articles_pool').append(response);
                 jQuery('.related_articles_pool').show();
              }
          }); 

   });

    // End Js Ajax Function for Load Related Articles

    
});


