<?php



/*

Plugin Name: Easy Summit

Plugin URI: http://easysummit.com

Description:Create Webinars

Version: 2.0.2

Author: Web Master Christian

Author URI: http://hotrockhosting.com

License: A "Slug" license name e.g. GPL2

*/



// Includes PHP files located in 'ezs-core-functions' folder

foreach( glob ( plugin_dir_path(__FILE__). "ezs-core-functions/*.php" ) as $lib_filename ) {

    require_once( $lib_filename );

}





/**

 * Forms post types and custom taxonomies.

 * 

 * @since 1.0

 * 

 */

add_action( 'init', 'easysummit_ezs_form_new_post_types',9 ); 

function easysummit_ezs_form_new_post_types(){



        $post_type_form = get_option( 'ez_ezshn', null );



        if( $post_type_form!==null && is_array($post_type_form) ){



            foreach($post_type_form as $value){



                /* Taxonomy Associated */

                $taxonomy_assc = empty($value['tax_association']) ? array() : array_values($value['tax_association']);

                /* Menu icon for post type. */

                $menu_icon     = empty($post_type_form['menu_icon']) ? null : $post_type_form['menu_icon'];



                register_post_type( $value['slug'], array(

                        'labels' => array(

                        'name' => _x($value['name'], 'post type general name', 'hrh-ez'),

                        'singular_name' => _x($value['name'], 'post type singular name', 'hrh-ez'),

                        'add_new' => _x('Add New', $value['name'], 'hrh-ez'),

                        'add_new_item' => __('Add New '.$value['name'], 'hrh-ez'),

                        'edit_item' => __('Edit '.$value['name'], 'hrh-ez'),

                        'new_item' => __('New '.$value['name'], 'hrh-ez'),

                        'view_item' => __('View '.$value['name'], 'hrh-ez'),

                        'search_items' => __('Search '.$value['name'], 'hrh-ez'),

                        'not_found' => __('No '.$value['name'].' found.', 'hrh-ez'),

                        'not_found_in_trash' => __('No '.$value['name'].' found in Trash.', 'hrh-ez'),

                        'parent_item_colon' => array( null, __('Parent '.$value['name'].':', 'hrh-ez') ),

                        'all_items' => __( 'All '.$value['name'], 'hrh-ez' ) ),

                        'description' => __( $value['name'], 'hrh-ez' ),

                        'publicly_queryable' => null, 

                        'exclude_from_search' => null,

                        'capability_type' => 'post', 

                        'capabilities' => array(),

                        'map_meta_cap' => null,

                        '_builtin' => false, 

                        '_edit_link' => 'post.php?post=%d', 

                        'hierarchical' => false,

                        'public' => true, 

                        'rewrite' => true,

                        'has_archive' => true, 

                        'query_var' => true,

                        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author'  ),

                        'register_meta_box_cb' => null,

                        'taxonomies' => $taxonomy_assc,

                        'show_ui' => null, 

                        'menu_position' => null, 

                        'menu_icon' => $menu_icon,

                        'permalink_epmask' => EP_PERMALINK, 

                        'can_export' => true,

                        'show_in_nav_menus' => null, 

                        'show_in_menu' => null, 

                        'show_in_admin_bar' => null

                    )

                );



               unset($taxonomy_assc);

               unset($menu_icon);

            }

        }

        

        $custom_taxonomies = get_option('ezs_custom_tax',null);



        if( is_array($custom_taxonomies) ){



            foreach( $custom_taxonomies as $taxonomy ){



                register_taxonomy( $taxonomy['slug'], $taxonomy['associate_posts'], array(

                    'hierarchical' => true,

                    'update_count_callback' => '',

                    'rewrite' => true,

                    'query_var' => $taxonomy['slug'],

                    'public' => true,

                    'show_ui' => null,

                    'show_tagcloud' => null,

                    '_builtin' => false,

                    'labels' => array(

                    'name' => _x( $taxonomy['name'], 'taxonomy general name', 'hrh-ez' ),

                    'singular_name' => _x( $taxonomy['name'], 'taxonomy singular name', 'hrh-ez' ),

                    'search_items' => __( 'Search '.$taxonomy['name'], 'hrh-ez' ),

                    'all_items' => __( 'All '.$taxonomy['name'], 'hrh-ez' ),

                    'parent_item' => array( null, __( 'Parent '.$taxonomy['name'], 'hrh-ez' ) ),

                    'parent_item_colon' => array( null, __( 'Parent '.$taxonomy['name'].':', 'hrh-ez' ) ),

                    'edit_item' => __( 'Edit '.$taxonomy['name'], 'hrh-ez' ),

                    'view_item' => __( 'View '.$taxonomy['name'], 'hrh-ez' ),

                    'update_item' => __( 'Update '.$taxonomy['name'], 'hrh-ez' ),

                    'add_new_item' => __( 'Add New '.$taxonomy['name'], 'hrh-ez' ),

                    'new_item_name' => __( 'New '.$taxonomy['name'].' Name', 'hrh-ez' ) ),

                    'capabilities' => array(),

                    'show_in_nav_menus' => null,

                    'label' => __( 'Brands', 'hrh-ez' ),

                    'sort' => true,

                    'args' => array( 'orderby' => 'term_order' ) )

                );

            }

        }

}















// hide default metaboxs fromn ez custom post

add_filter('default_hidden_meta_boxes', 'easysummit_hide_meta_lock', 10, 2);

function easysummit_hide_meta_lock($hidden, $screen) {

        if ( 'series14' == $screen->base )

                $hidden = array('postexcerpt','slugdiv','postcustom','trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv', 'categories');

               

        return $hidden;

}











//Add the Events Meta Boxes

add_action( 'add_meta_boxes', 'easysummit_add_events_metaboxes', 0 );

function easysummit_add_events_metaboxes(){	   

$post_type_form = get_option( 'ez_ezshn', null );

if( $post_type_form!==null && is_array($post_type_form) ){  	

 foreach($post_type_form as $value){	

add_meta_box('easysummit_ezs_event', 'EZ Event Main Information', 'easysummit_ezs_event', $value['slug'], 'advanced', 'high');	

	}}}

	









//remove main post editor for ez posts

add_action("init","easysummit_reset_editor");

function easysummit_reset_editor()

{

	$post_type_form = get_option( 'ez_ezshn', null );

if( $post_type_form!==null && is_array($post_type_form) ){  	

 foreach($post_type_form as $value){	

     global $_wp_post_type_features;



     $post_type=$value['slug'];

     $feature = "editor";

     if ( !isset($_wp_post_type_features[$post_type]) )

     {



     }

     elseif ( isset($_wp_post_type_features[$post_type][$feature]) )

     unset($_wp_post_type_features[$post_type][$feature]);

}

}}







//add ez post editor 

add_action( 'add_meta_boxes', 'easysummit_action_add_meta_boxes', 0 );

	function easysummit_action_add_meta_boxes() {

		$post_type_form = get_option( 'ez_ezshn', null );

if( $post_type_form!==null && is_array($post_type_form) ){  	

 foreach($post_type_form as $value){	

     global $_wp_post_type_features;



     $post_type= $value['slug'];

     $feature = "editor";

     if ( !isset($_wp_post_type_features[$post_type]) )

     {

unset($_wp_post_type_features[$post_type]['editor']);}

				add_meta_box(

					'description_section',

					__('Onsite Offer Page'),

					'easysummit_inner_custom_box',

						$value['slug'], 'advanced', 'low'

				);

 }}

	

	}





function easysummit_inner_custom_box( $post ) {

	echo '<div class="wp-editor-wrap">';

	the_editor($post->post_content);

	echo '</div>';

	}

	





	add_action( 'admin_head', 'easysummit_action_admin_head'); //white background

	function easysummit_action_admin_head() {

	?>

<style type="text/css">

.wp-editor-container {

	background-color:#fff;

}

#easysummit_ezs_event {

	background-color:#CCC;

}

#description_section {

	background-color:#CCC;

}

</style>

<?php

	}

	

	



// EZ metabox fields

function easysummit_ezs_event() {

    global $post;

    // Noncename needed to verify where the data originated

    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .

    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    // Get the location data if its already been entered

      

          

		//public event link

		echo 'Public Event Link: <a target="_blank" href="'.get_permalink().'">'.get_permalink().'</a>';

		//public offer link 

		

		 $event_affiliate_link = get_post_meta(get_the_ID(),'_event_affiliate',true);

		 if ($event_affiliate_link <>"")

{$offerlink_gui = $event_affiliate_link;}

else

{$the_permalink_gui = get_permalink();

$offerlink_gui = $the_permalink_gui.'?option=div1';}

		

		

		echo '<br>Public Offer Link: <a target="_blank" href="'.$offerlink_gui.'">'.$offerlink_gui.'</a>';

		

		$events_date =  get_post_meta( get_the_ID(),'_event_date',true );

		echo '<br>Event Date: '.$events_date;

		

		

		  //event info

		  $featured_gallery = get_post_meta($post->ID, '_featured_gallery', true);


$event_subject = get_post_meta($post->ID, '_event_subject', true);
echo '<p>Event Subject</p>';
echo '<input maxlength="100" type="text" name="_event_subject" value="' . esc_html($event_subject)  . '" class="widefat" />';

$event_description = get_post_meta($post->ID, '_event_description', true);
echo '<p>Event Description</p>';
echo '<textarea cols="75" rows="10" type="text" name="_event_description" value="' . esc_html($event_description) . '" class="widefat" />' . $event_description . '</textarea>';

$event_promotion = get_post_meta($post->ID, '_event_promotion', true);
echo '<p>Event Promotion</p>';
echo '<textarea cols="75" rows="10" type="text" name="_event_promotion" value="' . esc_html($event_promotion) . '" class="widefat" />' . $event_promotion . '</textarea>';

$event_date = get_post_meta($post->ID, '_event_date', true); 
echo '<p>Event Start Date: ex. 2016-01-31 22:01:01</p>';
echo '<input maxlength="25" id="ButtonCreationDemoInput" type="text" name="_event_date" value="' . esc_html($event_date)  . '" class="widefat" />';

$event_date_replay = get_post_meta($post->ID, '_event_date_replay', true); 
echo '<p>Event End Date: ex. 2016-01-31 23:01:01</p>';
echo '<input maxlength="25" id="ButtonCreationDemoInput1" type="text" name="_event_date_replay" value="' . esc_html($event_date_replay)  . '" class="widefat" />';

$event_date_download = get_post_meta($post->ID, '_event_date_download', true); 
echo '<input id="ButtonCreationDemoInput2" type="hidden" name="_event_date_download" value="2030-01-01 00:00:00" class="widefat" />';  
		  
		  



        
//google hangouts email invite
$gh_email_invite = get_post_meta($post->ID, '_gh_email_invite', true);
echo '<p>Google Hangout</p>';
echo '<div style="width:100%">
					<div style="width:50%;float:left">
					<p>Email to Invite</p>
						 <input maxlength="50" type="text" name="_gh_email_invite" value="' . esc_html($gh_email_invite)  . '" class="widefat" />
					</div>';
echo '<div style="width:50%;float:left">
		 		 	<p>Save Email first then Click to Start</p>
						<g:hangout render="createhangout" invites="[{ id : \'' . esc_html($gh_email_invite) . '\', invite_type : \'EMAIL\' }]"></g:hangout>
					</div>
				</div>
				<div style="clear:both"></div>';

//event code
$event_code = get_post_meta($post->ID, '_event_code', true);
$event_code_esc = esc_html($event_code);
$event_code_dec = html_entity_decode($event_code_esc);
echo '<p>Custom Event Code</p>';
echo '<textarea cols="75" rows="10" type="text" name="_event_code" value="' . $event_code_esc . '" class="widefat" />' . $event_code_dec . '</textarea>';


$event_code_qa = get_post_meta($post->ID, '_event_code_qa', true);
$event_code_qa_esc = esc_html($event_code_qa);
$event_code_qa_dec = html_entity_decode($event_code_qa_esc);
echo '<p>Event Q&amp;A Code</p>';
echo '<textarea cols="75" rows="10" type="text" name="_event_code_qa" value="' . $event_code_qa_esc . '" class="widefat" />' . $event_code_qa_dec . '</textarea>';


		  
echo '<h2><span>OFFER</span></h2>';
echo '<h3>Either Offsite or Onsite</h3>';

		  //affiliate link
$event_affiliate = get_post_meta($post->ID, '_event_affiliate', true);
echo '<p>Offsite Offer Link</p>';
echo '<input maxlength="100" type="text" name="_event_affiliate" value="' . esc_url($event_affiliate)  . '" class="widefat" />';
echo '<h4>or Onsite:</h4>';
}


// Save the Metabox Data

add_action('save_post', 'easysummit_save_events_meta', 1, 2); // save the custom fields
function easysummit_save_events_meta($post_id, $post) {
// verify this came from the our screen and with proper authorization,
    if ( !wp_verify_nonce( $_POST['eventmeta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }

// Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
      return $post->ID;

// OK, we're authenticated: we need to find and save the data
// We'll put it into an array to make it easier to loop though.


$featured_gallery = sanitize_text_field($_POST['_featured_gallery']);
update_post_meta( $post->ID, '_featured_gallery', $featured_gallery );

$event_subject = sanitize_text_field($_POST['_event_subject']);
update_post_meta( $post->ID, '_event_subject', $event_subject );

$event_description = sanitize_text_field($_POST['_event_description']);
update_post_meta( $post->ID, '_event_description', $event_description );

$event_promotion = sanitize_text_field($_POST['_event_promotion']);
update_post_meta( $post->ID, '_event_promotion', $event_promotion );

//calendar
$event_date = sanitize_text_field($_POST['_event_date']);
update_post_meta( $post->ID, '_event_date', $event_date );

$event_date_replay = sanitize_text_field($_POST['_event_date_replay']);
update_post_meta( $post->ID, '_event_date_replay', $event_date_replay );

$event_date_download = sanitize_text_field($_POST['_event_date_download']);
//$event_date_download = '2030-01-01 00:00:00';
update_post_meta( $post->ID, '_event_date_download', $event_date_download );


//event code
$event_code = wp_kses_post($_POST['_event_code']);
update_post_meta( $post->ID, '_event_code', $event_code );

$event_code_qa = wp_kses_post($_POST['_event_code_qa']);
update_post_meta( $post->ID, '_event_code_qa', $event_code_qa );

$event_code_replay = wp_kses_post($_POST['_event_code_replay']);
update_post_meta( $post->ID, '_event_code_replay', $event_code_replay );

$event_code_replay_2 = wp_kses_post($_POST['_event_code_replay_2']);
update_post_meta( $post->ID, '_event_code_replay_2', $event_code_replay_2 );

//hangouts
$gh_email_invite = sanitize_text_field($_POST['_gh_email_invite']);
update_post_meta( $post->ID, '_gh_email_invite', $gh_email_invite );

//affiliate
$event_affiliate = sanitize_text_field($_POST['_event_affiliate']);
update_post_meta( $post->ID, '_event_affiliate', $event_affiliate );

//event purchase and download
$event_purchase = sanitize_text_field($_POST['_event_purchase']);
update_post_meta( $post->ID, '_event_purchase', $event_purchase );

$event_download = sanitize_text_field($_POST['_event_download']);
update_post_meta( $post->ID, '_event_download', $event_download );



}
?>