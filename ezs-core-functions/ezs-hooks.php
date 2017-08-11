<?php
/**
 * All the hooked function used in plugin.
 */

wp_enqueue_script( 'ezs',  plugins_url( 'js/ezs.js', dirname(__FILE__) ), array(), false, true );
wp_enqueue_style('ezs-style', plugins_url( 'styles/ezs-style.css', dirname(__FILE__) ));
wp_enqueue_script( 'google-hangouts', 'https://apis.google.com/js/platform.js' );




//init plugin
function easysummit_ezs_plugin_init() {
  load_plugin_textdomain( 'hrh-ez', false, dirname( plugin_basename( __FILE__ ) ) ); 
}
add_action( 'plugins_loaded', 'easysummit_ezs_plugin_init' );





//function ez_add_styles_and_scripts */
function easysummit_ez_add_styles_and_scripts(){
    wp_enqueue_style('ezs-style', plugins_url( 'styles/ezs-style.css', dirname(__FILE__) ));
    wp_enqueue_script( 'ezs', plugins_url( 'js/ezs.js', dirname(__FILE__) ), array(), false, true );
	wp_enqueue_script( 'google-hangouts', 'https://apis.google.com/js/platform.js' );

}
add_action( 'admin_enqueue_scripts', 'easysummit_ez_add_styles_and_scripts', 9 );

// Add Options Page when plugin activated.
function easysummit_ez_create_menu(){

    $rtmanager = add_menu_page( __( 'Easy Summit','hrh-ez' ), __( 'Easy Summit','hrh-ez' ), 'administrator', 'hrhctm', 'easysummit_ezs_front_page', plugins_url('easysummit/images/icon.ico') );
}
add_action('admin_menu','easysummit_ez_create_menu');

// Add ajaxurl
function easysummit_ezs_ajaxurl() { 
?><script type="text/javascript">
    var easysummit_ezs_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script><?php

}
add_action('admin_head','easysummit_ezs_ajaxurl');

// Form slug from Post Type title ( Invoked by ajax call )
function easysummit_ezs_sanitize_post_title(){

    if( !empty($_POST['title']) ){
        
        if( function_exists('sanitize_title') ){
            echo $slug = sanitize_title( $_POST['title'] );
            die(1);
        }
    }    
}
add_action('wp_ajax_ezs_sanitize_title', 'easysummit_ezs_sanitize_post_title');
add_action('wp_ajax_nopriv_ezs_sanitize_title', 'easysummit_ezs_sanitize_post_title');

// Validate Image Size
function easysummit_ezs_validate_menu_icon(){

    if( !empty($_POST['menu_url']) ){

        $url = $_POST['menu_url'];

        if(!filter_var($url, FILTER_VALIDATE_URL)){
            echo '<p>'.__('URL is not valid','hrh-ez').'</p>';
            die(1);
        }else{
         
            $size = @getimagesize($url);
            
            if( is_array($size) ){
                
                $width  = $size[0];
                $height = $size[1];
                
                $width  = ($width <= 200)  ? true : false;
                $height = ($height <= 300) ? true : false;
                if( !($width && $height) ){
                    
                    echo 'Dimension of image not as per requirement.';
                    die(1);
                }                    
            }
        }
    }
    echo '';
    die(1);
}
add_action('wp_ajax_ezs_menu_icon', 'easysummit_ezs_validate_menu_icon');
add_action('wp_ajax_nopriv_ezs_menu_icon', 'easysummit_ezs_validate_menu_icon');

// Associated Taxonomies To newly created Post Types
function easysummit_ezs_associate_taxonomies(){

    $post_type_form = get_option( 'ez_ezshn', null );
    if( is_array($post_type_form) && !empty($post_type_form) ){

        foreach( $post_type_form as $key=>$val ){

            $taxonomies = empty($val['tax_association']) ? null : array_values($val['tax_association']);

            if($taxonomies){
                foreach($taxonomies as $tax){
                     register_taxonomy_for_object_type( $tax, $val['slug'] );
                }
            }
        }
    }

    $custom_tax = get_option( 'ezs_custom_tax', null );

    if(!empty($custom_tax)){

        global $wp_post_types;
        foreach( $custom_tax as $key=>$val ){

            $post_types = empty($val['associate_posts']) ? null : array_values($val['associate_posts']);

            if($post_types){
                foreach( $post_types as $post_type ){

                    if( !in_array( $val['slug'], $wp_post_types[$post_type]->taxonomies ) ){

                        array_push( $wp_post_types[$post_type]->taxonomies, $val['slug'] );

                    }                    
                }
            }
        }
    }

}
add_action( 'init' , 'easysummit_ezs_associate_taxonomies',11 );

//show custom content only on custom pages
function easysummit_add_single_event( $content ) {


$utctime = current_time( 'mysql' ); 
list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $utctime );

$global_event_date= $GLOBALS['post']->_event_date;
$global_event_date_replay= $GLOBALS['post']->_event_date_replay;
$global_event_date_download= $GLOBALS['post']->_event_date_download;
$timezone = get_option('timezone_string');

//subject and title combined for ad to calendar
$id = $GLOBALS['post']->ID;
$title = get_the_title( $id );
$subject = $GLOBALS['post']->_event_subject;
$calendar_title = $title.': '.$subject;

//before event function
if($utctime < $global_event_date and $utctime < $global_event_date_replay  and $utctime < $global_event_date_download){



$dateformated = mysql2date('F j, Y g:i a', $global_event_date) ;

$event_play = 
'<span class="eventdate">Event Date '.$dateformated.
'</span><br>'
.$addtocalendar.
'<br /><br />'
.$GLOBALS['post']->_event_promotion;}


//current event function
if($utctime > $global_event_date && $utctime < $global_event_date_replay && $utctime < $global_event_date_download){
$event_play = $GLOBALS['post']->_event_code.
			'<br>'
			.$GLOBALS['post']->_event_code_qa;}

//replay event function
if( $utctime > $global_event_date && $utctime > $global_event_date_replay && $utctime < $global_event_date_download){
$event_play = $GLOBALS['post']->_event_code_replay.	
			'<br>'
			.$GLOBALS['post']->_event_code_replay_2;}
			
//download event function
if( $utctime > $global_event_date && $utctime > $global_event_date_replay && $utctime > $global_event_date_download){
$event_play = $GLOBALS['post']->_event_purchase.
			'<br>'
			.$GLOBALS['post']->_event_download	;}
			
			
//affiliate or home offer
$affiliatelink = $GLOBALS['post']->_event_affiliate;

if ($affiliatelink <>"")
{$offerlink = $GLOBALS['post']->_event_affiliate;}
else
{$offerlink = 'javascript:showOne(\'div1\');showDiv(\'div1\')';}


$get_option_site_info = get_option( '_site_info', null );
$site_info = $get_option_site_info;
$site_info_esc = esc_html($site_info);
$site_info_dec = html_entity_decode($site_info_esc);


$post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );
$post_type = get_post_type( $post_id );   
$mypost_type = $post_type;

$post_type_custom = get_option( 'ez_ezshn', null );
$mypost_type_custom = $post_type_custom;
        foreach( $mypost_type_custom as $value){
           
			 if(in_array($mypost_type , $value))
    {	
	
         $offer = get_the_content();
					 
					$content = '
	<div style="clear:both"></div>	
		<div style="width:100%;margin:0;padding:0;">
		<div style="width:60%;min-width:300px;float:left;margin:0;padding:0;"><h2 id="subject">'.$GLOBALS['post']->_event_subject.'</h2>
			<div id="custom-post-entry"><span class="eventthumbnail" style="min-width:300px;">'.$post_thumbnail.'</span>
			<div class="mobileclear"></div>
			<p style="min-width:300px;text-align:justify;">'.$GLOBALS['post']->_event_description.'</p>
			</div>
	
		<div style="clear:both"></div>			
		
 <div id="ez-offer">
		<div id="offer-link"><a href="'.$offerlink .'" onfocus="this.blur();"><span class="offer">Offer</span></a>
		</div>   
	 
      <div id="div1" style="display:none;" class="container-popup">
	  
	       <div class="popup" style="overflow:scroll">
	 '
	 .$GLOBALS['post']->_event_subject.
	 '<br>'
	 .$offer.
	 '

 <div style="clear:both"></div>
 
       <a href="javascript:showOne(\'\');showDiv(\'\')" onfocus="this.blur();">Close</a>
           </div>
      </div>
  				
	</div> 
	</div>
		<div style="width:40%;min-width:300px;float:left;margin:0;padding:0;"><div class="ez-event">'.$event_play.'</div>	</div>
		</div>
	
	<div id="site_info">'.$site_info_dec.'</div>	
';		 
	 
   	}
 
												}
return $content;

wp_reset_query();
wp_reset_postdata();
 
	       
}
add_filter( 'the_content', 'easysummit_add_single_event' );		









 
//Site wide footer
add_shortcode( 'footer', 'easysummit_ez_footer' );
function easysummit_ez_footer( $atts )
{ ob_start();

$get_option_email_code = get_option( '_email_code', null );
$email_code = $get_option_email_code;
$email_code_esc = esc_html($email_code);
$email_code_dec = html_entity_decode($email_code_esc);


$get_option_myseries = get_option( '_myseries', null );
$get_option_blogname = get_option( 'blogname', null );
$get_option_siteurl = get_option( 'siteurl', null );

$get_option_myreplay =get_option( '_myreplay', null );
$get_option_mynext = get_option( '_mynext', null );


$post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );


$feature_replay_post_thumbnail = get_the_post_thumbnail( $get_option_myreplay, 'medium' );
$feature_replay_post_url = get_permalink ( $get_option_myreplay );
$feature_replay_post_title = get_the_title ( $get_option_myreplay );

$feature_soon_post_thumbnail = get_the_post_thumbnail( $get_option_mynext, 'medium' );
$feature_soon_post_url = get_permalink ( $get_option_mynext );
$feature_soon_post_title = get_the_title( $get_option_mynext );


echo '<div style="clear:both"></div>

<div id="footertiles" style="width:100%;margin-top:3%">
<hr>
<div style="min-width:200px;width:24%;float:left;">
<div class="footer"><h4>Featured Series</h4></div>

<div style="margins:0;padding:0;text-align:center;">';


$myseriesoption = get_option( '_myseries', null );
$type = $myseriesoption;
$args=array(  'post_type' => $type,  'post_status' => 'publish',  'posts_per_page' => 5,  'caller_get_posts'=> 1);
$my_query = null;
$my_query = new WP_Query($args);

$post_series_icon_image = get_option( '_myseries', null );



$post_series_icon = get_option( 'ez_ezshn', null );
  
    
    if( is_array($post_series_icon) && !empty($post_series_icon) ){

      echo '<div style="clear:both"></div>
<ul class="ulimagegallery">'; 
		foreach( $post_series_icon as $key=>$val ){

$val_slug = $val['slug'];
$icon_image = $post_series_icon_image;


if ($val_slug == $icon_image){echo '<li class="liimagegallery">					 
							 <div class="divimagegallery">';
		  
		 
		  
		   echo '<a href="';
		   echo get_site_url();
		   echo '/';
		   echo $val['slug'];
		   echo'/">';
		   
		    
		  echo '<img src="';
		  echo $val['menu_icon'];
		  echo '" alt=featured>';
		  
		  echo '<br />';
		   echo $val['name'];

		   
		   echo'</a>';
		   
		   echo '</div></li>';}

	   
		   
           }
		
		echo '</ul>';
		
		
    }


echo '</div>
</div>

<div style="min-width:200px;margin-left:1%;width:24%;float:left">
<div class="footer"><h4>Featured Event</h4>
<div class="imgattached"><a href="'.$feature_replay_post_url.'">'.$feature_replay_post_thumbnail.'<br />'.$feature_replay_post_title.'</a></div>
</div></div>

<div style="min-width:200px;margin-left:1%;width:24%;float:left">
<div class="footer"><h4>Up Next</h4>
<div class="imgattached"><a href="'.$feature_soon_post_url.'">'.$feature_soon_post_thumbnail.'<br />'.$feature_soon_post_title.'</a></div>
</div></div>

<div style="min-width:200px;margin-left:1%;width:24%;float:left">
<div class="footer"><h4>Newsletter</h4>'.$email_code_dec.'
</div></div>
		
		</div>	

	<div style="clear:both"></div>';






wp_reset_query();
wp_reset_postdata();
return ob_get_clean(); }


 
 
//series gallery
add_shortcode( 'seriesgallerylist', 'easysummit_series_gallery_list' );
function easysummit_series_gallery_list( $atts )
{ ob_start();
 $post_type_form = get_option( 'ez_ezshn', null );
    if( is_array($post_type_form) && !empty($post_type_form) ){

      echo '<div style="clear:both"></div>
<ul class="ulimagegallery">'; 
		foreach( $post_type_form as $key=>$val ){
         echo '<li class="liimagegallery">					 
							 <div class="divimagegallery">';
		   echo '<a href="';
		   echo get_site_url();
		   echo '/';
		   echo $val['slug'];
		   echo'/">';
		   
		   echo '<h2 class="series">';
		   echo $val['name'];
		   echo '</h2>';
		   
		   echo '<img src="';
		   echo $val['menu_icon'];
		   echo '">';
		   
		   echo'</a>';
		   
		   echo '</div></li>';
           }
		
		echo '</ul>';
		
		
    }

wp_reset_query();
wp_reset_postdata();  // Restore global post data stomped by the_post().
return ob_get_clean(); }

//featured events gallery
add_shortcode( 'indexgallery', 'easysummit_index_gallery' );
function easysummit_index_gallery( $atts )
{ ob_start(); 
$myseriesoption = get_post_types();
$type = $myseriesoption;
$args=array(  
'post_type' => $type,  
'post_status' => 'publish',  
'posts_per_page' => 25,  
'caller_get_posts'=> 1,
'meta_key' => '_featured_gallery',
'meta_value' => '1'
);
$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
echo '<div style="clear:both"></div>
<ul class="ulimagegallery">'; 
  while ($my_query->have_posts()) : $my_query->the_post();
     	
	           if ( has_post_thumbnail() ) :
	//affiliate or home offer
//get_the_ID()
//the_post_thumbnail()
//the_permalink()	
$meta =  get_post_meta( get_the_ID(), '_event_promotion', true );	
               		echo '<li class="liimagegallery">					 
							 <div class="divimagegallery"> ';
 						     
					
			echo '<div id="'.get_the_ID().'1" style="display:none;text-align:justify">';
			echo '<a style="cursor: pointer;cursor: hand;" onclick="toggle_visibility_promo(\''.get_the_ID().'2\');toggle_visibility_promo(\''.get_the_ID().'1\');">';
			echo $meta;
			
			echo '</a>';
	
						echo '</div>';
			
	
	
	
            echo'<div id="'.get_the_ID().'2" style="text-align:justify">';
			echo '<a style="cursor: pointer;cursor: hand;" onclick="toggle_visibility_image(\''.get_the_ID().'1\');toggle_visibility_promo(\''.get_the_ID().'2\');">';echo the_post_thumbnail();
			echo '<h3 class="h3">'.get_the_title().'</h3></a>';
			
 			echo '</div>';
			echo '</div>
						</li>'; 
				endif;			
	endwhile;
echo '</ul>'; 
}
wp_reset_query();
wp_reset_postdata();  // Restore global post data stomped by the_post().
return ob_get_clean(); }
 
//Offer gallery
add_shortcode( 'eventsoffer', 'easysummit_events_offer' );
function easysummit_events_offer( $atts )
{ ob_start();
//get_the_ID()
//the_post_thumbnail()
//the_permalink()	
$post_type_form = get_option( 'ez_ezshn', null );

    if( is_array($post_type_form) && !empty($post_type_form) && post_type ){

		       foreach( $post_type_form as $key=>$val ){        
				  $slug = $val['slug'];
				  $type = $slug;
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
echo '<div style="clear:both"></div>';
echo '<h2 class="h2name" style="padding:1%">'.$type.'</h2>';
echo '<ul class="ulimagegallery">';
while ($my_query->have_posts()) : $my_query->the_post();

 $post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );

 $utctime = current_time( 'mysql' ); 
 list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $utctime );

 $event_date = get_post_meta( get_the_ID(),'_event_date',true );
 $replay_date = get_post_meta( get_the_ID(),'_event_date_replay',true );
 $download_date = get_post_meta( get_the_ID(),'_event_date_download',true );

     $new_event_date = $event_date;
     $new_event_date_replay = $replay_date;
     $new_event_date_download = $download_date; 
	
	 $event_affiliate = get_post_meta(get_the_ID(),'_event_affiliate',true);
          
    
//if( $utctime > $new_event_date && $utctime < $new_event_date_replay && $utctime < $new_event_date_download){
	
	echo '<li class="liimagegallery">					 
							 <div class="divimagegallery">';
	
//affiliate or home offer

if ($event_affiliate <>"")
{$offerlink = $event_affiliate;}
else
{$the_permalink = get_permalink();
$offerlink = $the_permalink.'?option=div1';}


		   echo '<a href="'.$offerlink.'">';
		   
		   echo '<h3 class="name">';
		   echo the_title();
		   echo '</h3>';
		   
		   echo $post_thumbnail;
		   
		   echo'</a>';

		   echo '</div></li>';

//}  
endwhile;
		echo '</ul>';
		}
	}
}
wp_reset_query();
wp_reset_postdata();
return ob_get_clean(); }
 
//live gallery
add_shortcode( 'eventslive', 'easysummit_events_live' );
function easysummit_events_live( $atts )
{ ob_start();
$post_type_form = get_option( 'ez_ezshn', null );
krsort($post_type_form, SORT_STRING);
    if( is_array($post_type_form) && !empty($post_type_form) ){

		       foreach( $post_type_form as $key=>$val ){        
				 				 
				  
                  $key = (int) $key;				  
				  $slug = $val['slug'];
				  $name = $val['name'];
				  
				  $id = $key; 
				  $type = $slug;
				  $name_name = $name;

			  
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1, 
  'hide_empty' => 0
  );

krsort($args, SORT_STRING); 
$my_query = null;
$my_query = new WP_Query($args);


if( $my_query->have_posts() ) {
while ($my_query->have_posts()) : $my_query->the_post();
 $post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );

 $utctime = current_time( 'mysql' ); 
 list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $utctime );

 $event_date = get_post_meta( get_the_ID(),'_event_date',true );
 $replay_date = get_post_meta( get_the_ID(),'_event_date_replay',true );
 $download_date = get_post_meta( get_the_ID(),'_event_date_download',true );

     $new_event_date = $event_date;
     $new_event_date_replay = $replay_date;
     $new_event_date_download = $download_date; 
if( $utctime > $new_event_date && $utctime < $new_event_date_replay && $utctime < $new_event_date_download){
echo '<div class="h2'.$id.' " >';
echo '<h2 class="h2name">'.$name_name.'</h2>';
echo '<ul class="ulimagegallery">';
echo '<li class="liimagegallery">					 
 <div class="divimagegallery">';

		   echo '<a href="';
		   echo the_permalink();
		   echo'">';
		   
		   echo '<h3 class="h3">';
		   echo the_title();
		   echo '</h3>';
		   
		   echo $post_thumbnail;
		   
		   echo'</a>';

		   echo '</div></li>';
echo '</ul></div>';
}  
endwhile;
		
		
		}
	}
}
wp_reset_query();
wp_reset_postdata();
return ob_get_clean(); }  


//next gallery
add_shortcode( 'eventsnext', 'easysummit_events_next' );
function easysummit_events_next( $atts )
{ ob_start();
$post_type_form = get_option( 'ez_ezshn', null );
krsort($post_type_form, SORT_STRING);
    if( is_array($post_type_form) && !empty($post_type_form) ){

		       foreach( $post_type_form as $key=>$val ){        
				 				 
				  
                  $key = (int) $key;				  
				  $slug = $val['slug'];
				  $name = $val['name'];
				  
				  $id = $key; 
				  $type = $slug;
				  $name_name = $name;

			  
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1, 
  'hide_empty' => 0
  );

krsort($args, SORT_STRING); 
$my_query = null;
$my_query = new WP_Query($args);

if( $my_query->have_posts() ) {
while ($my_query->have_posts()) : $my_query->the_post();
 $post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );

 $utctime = current_time( 'mysql' ); 
 list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $utctime );

 $event_date = get_post_meta( get_the_ID(),'_event_date',true );
 $replay_date = get_post_meta( get_the_ID(),'_event_date_replay',true );
 $download_date = get_post_meta( get_the_ID(),'_event_date_download',true );

     $new_event_date = $event_date;
     $new_event_date_replay = $replay_date;
     $new_event_date_download = $download_date; 
if( $utctime < $new_event_date && $utctime < $new_event_date_replay && $utctime < $new_event_date_download){
echo '<div class="h2'.$id.' " >';
echo '<h2 class="h2name">'.$name_name.'</h2>';
echo '<ul class="ulimagegallery">';
echo '<li class="liimagegallery">					 
<div class="divimagegallery">';

		   echo '<a href="';
		   echo the_permalink();
		   echo'">';
		   
		   echo '<h3 class="h3">';
		   echo the_title();
		   echo '</h3>';
		   
		   echo $post_thumbnail;
		   
		   echo'</a>';

		   echo '</div></li>';
echo '</ul></div>';
}  
endwhile;
		}
	}
}
wp_reset_query();
wp_reset_postdata();
return ob_get_clean(); } 


//replay gallery
add_shortcode( 'eventsreplay', 'easysummit_events_replay' );
function easysummit_events_replay( $atts )
{ ob_start();
$post_type_form = get_option( 'ez_ezshn', null );
krsort($post_type_form, SORT_STRING);
    if( is_array($post_type_form) && !empty($post_type_form) ){

		       foreach( $post_type_form as $key=>$val ){        
				 				 
                  $key = (int) $key;				  
				  $slug = $val['slug'];
				  $name = $val['name'];
				  
				  $id = $key; 
				  $type = $slug;
				  $name_name = $name;

			  
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1, 
  'hide_empty' => 0
  );

krsort($args, SORT_STRING); 
$my_query = null;
$my_query = new WP_Query($args);


if( $my_query->have_posts() ) {
while ($my_query->have_posts()) : $my_query->the_post();
 $post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );

 $utctime = current_time( 'mysql' ); 
 list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $utctime );

 $event_date = get_post_meta( get_the_ID(),'_event_date',true );
 $replay_date = get_post_meta( get_the_ID(),'_event_date_replay',true );
 $download_date = get_post_meta( get_the_ID(),'_event_date_download',true );

     $new_event_date = $event_date;
     $new_event_date_replay = $replay_date;
     $new_event_date_download = $download_date; 
if( $utctime > $new_event_date && $utctime > $new_event_date_replay && $utctime < $new_event_date_download){
echo '<div class="h2'.$id.' " >';
echo '<h2 class="h2name">'.$name_name.'</h2>';
echo '<ul class="ulimagegallery">';
echo '<li class="liimagegallery">					 
<div class="divimagegallery">';

		   echo '<a href="';
		   echo the_permalink();
		   echo'">';
		   
		   echo '<h3 class="h3">';
		   echo the_title();
		   echo '</h3>';
		   
		   echo $post_thumbnail;
		   
		   echo'</a>';

		   echo '</div></li>';
echo '</ul></div>';
}  
endwhile;
		
		
		}
	}
}
wp_reset_query();
wp_reset_postdata();
return ob_get_clean(); }  


//download gallery
add_shortcode( 'eventsdownload', 'easysummit_events_download' );
function easysummit_events_download( $atts )
{ ob_start();
//get_the_ID()
//the_post_thumbnail()
//the_permalink()	
$post_type_form = get_option( 'ez_ezshn', null );
krsort($post_type_form, SORT_STRING);
    if( is_array($post_type_form) && !empty($post_type_form) ){
		       foreach( $post_type_form as $key=>$val ){        
				  
                  $key = (int) $key;				  
				  $slug = $val['slug'];
				  $name = $val['name'];
				  
				  $id = $key; 
				  $type = $slug;
				  $name_name = $name;

			  
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1, 
  'hide_empty' => 0
  );

krsort($args, SORT_STRING); 
$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
while ($my_query->have_posts()) : $my_query->the_post();
 $post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );

 $utctime = current_time( 'mysql' ); 
 list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $utctime );

 $event_date = get_post_meta( get_the_ID(),'_event_date',true );
 $replay_date = get_post_meta( get_the_ID(),'_event_date_replay',true );
 $download_date = get_post_meta( get_the_ID(),'_event_date_download',true );

     $new_event_date = $event_date;
     $new_event_date_replay = $replay_date;
     $new_event_date_download = $download_date; 
if( $utctime > $new_event_date && $utctime > $new_event_date_replay && $utctime > $new_event_date_download){
echo '<div class="h2'.$id.' " >';
echo '<h2 class="h2name">'.$name_name.'</h2>';
echo '<ul class="ulimagegallery">';
echo '<li class="liimagegallery">					 
		 <div class="divimagegallery">';
	
		   echo '<a href="';
		   echo the_permalink();
		   echo'">';
		   
		   echo '<h3 class="h3">';
		   echo the_title();
		   echo '</h3>';
		   
		   echo $post_thumbnail;
		   
		   echo'</a>';

		   echo '</div></li>';
echo '</ul></div>';
}  
endwhile;
		
		
		}
	}
}
wp_reset_query();
wp_reset_postdata();
return ob_get_clean(); }

 
//featured series calendar list
//calendar
add_shortcode( 'seriescalendar', 'easysummit_series_calendar' );
function easysummit_series_calendar( $atts )
{ ob_start();
$myseriesoption = get_option( '_myseries', null );
$type = $myseriesoption;
$args=array(  'post_type' => $type,  'post_status' => 'publish',  'posts_per_page' => 50,  'caller_get_posts'=> 1);
$my_query = null;
$my_query = new WP_Query($args);

if( $my_query->have_posts() ) {
echo '<div style="width:100%;">';

$post_series_icon_image = get_option( '_myseries', null );
$post_series_icon = get_option( 'ez_ezshn', null );
    
    if( is_array($post_series_icon) && !empty($post_series_icon) ){

      echo '<div style="clear:both"></div>
<ul class="ulimagegallery">'; 
		foreach( $post_series_icon as $key=>$val ){

$val_slug = $val['slug'];
$icon_image = $post_series_icon_image;

if ($val_slug == $icon_image){echo '<li class="liimagegallery seriescalendarimage" style="float:none !important;margin:auto !important;text-align:center !important;">					 
							 <div class="divimagegallery">';
		   echo '<a href="';
		   echo get_site_url();
		   echo '/';
		   echo $val['slug'];
		   echo'/">';
		   
		   echo '<h2 class="series">';
		   echo $val['slug'];
		   echo '</h2>';
		   
		   echo '<img src="';
		   echo $val['menu_icon'];
		   echo '">';
		   
		   echo'</a>';
		   
		   echo '</div></li>';}
           }
		echo '</ul>';
    }
echo '</div>';


echo '
<div style="width:100%;clear:both"></div>
<div style="width:100%;margin:auto;">
<ul style="width:95%;margin:auto;">'; 
  while ($my_query->have_posts()) : $my_query->the_post();
$post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );
echo '<div style="clear:both;"></div>
<li class="calendar hover"><a href="';
echo get_the_permalink();
echo '">';
echo '<div style="text-align:center">';
echo '<h2>'.get_the_title().'</h2>';
$my_event_date = get_post_meta( get_the_ID(),'_event_date',true );
$dateformated = mysql2date('F j, Y g:i a', $my_event_date) ;
echo'<span style="font-size:12pt;"><em>';
echo $dateformated;
echo '</em></span><div style="clear:both;"></div>';
echo '<div style="text-align:left;line-height:1em;height:100%;overflow:auto;">';
echo '<span class="calendarthumbnail">';
echo $post_thumbnail;
echo '</span>';

$event_promotion = get_post_meta( get_the_ID(),'_event_promotion',true );
echo $event_promotion;
echo '</div>';
echo '<div style="clear:both;"></div>';
echo'<div style="width:100%;text-align:right;font-size:.5em">Read More</div>';
echo '</div>';
echo '</a></li>'; 
endwhile;
echo '</ul></div>';	
}
wp_reset_query();  // Restore global post data stomped by the_post().
return ob_get_clean(); } 



?>