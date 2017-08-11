<?php

/***/

function easysummit_ezs_front_page(){ 

 ?>

<div style="width:100%">
  <div style="width:100%; float:left" class="handlediv" title="Cck to toggle">
    <ul>
      <span class="ezsh-welcome-message"> <a href="http://easysummit.com/download-plugin/">UPGRADE TO EZ SUMMIT PRO FIRST MO FREE</a></span>
      <li>Get Support: <a href="http://easysummit.com/host/" target="_blank">Host Documents</a> | <a href="http://easysummit.com/forum/" target="_blank">Forum Support</a> | <a href="http://easysummit.com/live/" target="_blank">Site Demo<br />
        </a> </li>
      <li>Purchase Addons: <a href="http://hotrockhosting.com/whmcs/cart.php?a=add&amp;pid=62" target="_blank">Priority Support</a> | <a href="http://hotrockhosting.com/whmcs/cart.php?a=add&amp;pid=63" target="_blank">VA Assistance</a> | <a href="http://hotrockhosting.com/whmcs/cart.php?a=add&amp;pid=65" target="_blank">Site Branding</a> | <a href="http://hotrockhosting.com/whmcs/cart.php?a=add&amp;pid=60" target="_blank">Webinar Hosting</a> </li>
      <li>Streaming Webinar Platforms: <a href="http://InstantTeleseminar.com/21-day-trial.asp?x=2749477" target="_blank">Instant Teleseminar</a> | <a href="http://www.gotomeeting.com/fec/" target="_blank">Goto Meeting</a>| <a href="http://www.anymeeting.com" target="_blank">Any Meeting</a><br />
      </li>
      <li>Archive Account: <a href="http://www.gabtaube.audioacrobat.com/" target="_blank">Audio Acrobat</a> or  Cart: <a href="http://www.1automationwiz.com/app/?pr=29&amp;id=196992" target="_blank">1Automationwiz</a><br />
      </li>
    </ul>
    <br />
  </div>
  <div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<div style="width:100%">
  <div style="width:50%;float:left;">
    <?php



/* Form series */

echo '<h3><strong>Create New Series</strong></h3>'; 

if( isset( $_POST['ez_submit'] ) && !empty($_POST['ez_hrh_slug']) && !empty($_POST['ez_hrh_name'])  ){

        

        $associate_taxonomy = !empty($_POST['select_taxonomy']) ? $_POST['select_taxonomy'] : array();

        $menu_icon = empty($_POST['ez_menu_icon']) ? null : $_POST['ez_menu_icon'];



        $new_post_type = array( 'slug'=>$_POST['ez_hrh_slug'], 'name'=>$_POST['ez_hrh_name'], 'tax_association'=>$associate_taxonomy, 'menu_icon'=>$menu_icon );

        

        $available_cpt  =   get_option( 'ez_ezshn', array() );

        if( is_array($available_cpt) && !empty($available_cpt) ){

            

            /* Insert new post type into our post types carrying array. */

            $total_count = count($available_cpt);

            $total_count = ++$total_count;

            /* Here it will get inserted */

            $available_cpt[$total_count] = $new_post_type;

        }else{

            $available_cpt[0] = $new_post_type;

        }

        

        update_option( 'ez_ezshn', $available_cpt );

        

        echo '<p>Series added to WP Admin Menu. <br>Please go to the Series to add events</p>';

        echo '<script type="text/javascript">window.location=" '.  $_SERVER['REQUEST_URI'].' ";</script>';

    }else{



easysummit_ezs_common_form();

		}

?>
  </div>
  <div style="width:50%;float:left;">
    <div>
      <h2>Shortcode</h2>
      <div id="ezs-short-code">
        <div style="width:100%;float:left;">
          <div style="width:50%;float:left;">
            <table border="0" align="center" cellpadding="1%" cellspacing="1%">
              <tr>
                <td><a href="http://easysummit.com/live/">Live Events Listing</a></td>
                <td>[eventslive]</td>
              </tr>
              <tr>
                <td><a href="http://easysummit.com/speaker-offer-gallery/">Events Offers Listing</a></td>
                <td>[eventsoffer]</td>
              </tr>
              <tr>
                <td><a href="http://easysummit.com/series-gallery/">Series Listing</a></td>
                <td>[seriesgallerylist]</td>
              </tr>
            </table>
            <p style="text-align:center"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=E95V7A45FUMGS">Paypal Donations Accepted</a><br />
            <strong style="font-size:12px">or BTC:<br />
            15AMMM5Yr6chXrYs1PFKwvfcLFw75suYBn</strong></p>
            <p style="text-align:center"><br />
            </p>
          </div>
          <div style="width:50%;float:left;">
            <table border="0" align="center" cellpadding="1%" cellspacing="1%">
              <tr>
                <td colspan="2">Pro Only</td>
                
              </tr>
              <tr>
                <td><a href="http://easysummit.com/speaker-gallery/">Next Events</a></td>
                <td><strike>[eventsnext]</strike></td>
              </tr>
              <tr>
                <td><a href="http://easysummit.com/replay-gallery/">Replay Events</a></td>
                <td><strike>[eventsreplay]</strike></td>
              </tr>
              <tr>
                <td><a href="http://easysummit.com/download-event/">Download Events</a></td>
                <td><strike>[eventsdownload]</strike></td>
              </tr>
              <tr>
                <td><a href="http://easysummit.com/speaker-offer-gallery/">Events Offers</a></td>
                <td><strike>[eventsoffer]</strike></td>
              </tr>
              <tr>
                <td><a href="http://easysummit.com/featured-events/">Featured Events</a></td>
                <td><strike>[indexgallery]</strike></td>
              </tr>
              <tr>
                <td><a href="http://easysummit.com/">Footer</a></td>
                <td><strike>[footer]</strike></td>
              </tr>
              <tr>
                <td><a href="http://easysummit.com/event-calendar/">Featured  Dates</a></td>
                <td><strike>[seriescalendar]</strike></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="clear:both;"></div>
<?php 

//end of front page

}





/***/

function easysummit_ezs_common_form( $is_hrh_page = true )

{



			?>

<div id="ezs-manager-form">
<div sytle="text-align:center;"><a href="http://easysummit.com/2-0-videos/">Video Tutorials</a></div>
  <form method="post" action="" name="myForm" onsubmit="return easysummit_validateForm()">
    <div class="fields-container">
      <?php $label_name = ($is_hrh_page) ? 'Name for Series' : 'Name for Series'; ?>
      <label for="ez_hrh_name">
        <?php _e( $label_name,'hrh-ez' ); ?>
      </label>
      <input type="text" autocomplete="off" id="ez_hrh_name" name="ez_hrh_name" value="" />
    </div>
    <div class="fields-container">
      <?php $label_name = ($is_hrh_page) ? 'Slug for Series' : 'Slug for Series'; ?>
      <label for="ez_hrh_slug">
        <?php _e( $label_name,'hrh-ez' ); ?>
      </label>
      <input type="text" autocomplete="off" id="ez_hrh_slug" name="ez_hrh_slug" readonly="readonly" value="" />
    </div>
    <?php

                if($is_hrh_page){ ?>
    <div class="fields-container">
      <label for="ez_menu_icon">
        <?php _e( 'Series Gallery Image URL [Image size 200x300]','hrh-ez' ); ?>
      </label>
      <input type="text" name="ez_menu_icon" id="ez_menu_icon" value="" required/>
      <div class="ezs-alignright" id="ez_error_menu_img"></div>
    </div>
    <?php

                }

                /* Give User Option to associate taxonomies to newly creted post type */

                $taxonomies = easysummit_ezs_tax_list($is_hrh_page);

                /* Form list of all available taxonomies with this function. */

                easysummit_ezs_form_tax_list( $taxonomies, $is_hrh_page ); ?>
    <div class="fields-container">
      <?php $button_value = ($is_hrh_page) ? 'Create Series' : 'Create Series'; ?>
      <input type="submit" name="ez_submit" id="ez-submit" value="<?php echo $button_value; ?>" />
    </div>
    <script>

function easysummit_validateForm() {

    var x = document.forms["myForm"]["ez_menu_icon"].value;

    if (x == null || x == "") {

        alert("Input Gallery Image URL");

        return false;

    }

}

</script>
    <?php $site_url = get_site_url(); ?>
    <p class="ezsh-flush-permalink"><a href=<?php echo $site_url; ?>/wp-admin/options-permalink.php><span id="permalinks">Resave Permalinks</span></a>
      <?php _e('Re-Save Permalinks, after creating a Series','hrh-ez') ?>
    </p>
  </form>
</div>
<?php

			

			


// save activation

if( isset( $_POST['authorization'] ) ){



$option_name_appid = '_appid';

$option_valueposted_appid ['_appid'] = $_POST['_appid'];

$new_value_appid = $option_valueposted_appid ['_appid'];



$option_name_appkey = '_appkey';

$option_valueposted_appkey ['_appkey'] = $_POST['_appkey'];

$new_value_appkey = $option_valueposted_appkey ['_appkey'];





if ( get_option( $option_name_appid ) !== false && get_option( $option_name_appkey ) !== false ) {



    // The option already exists, so we just update it.

    update_option( $option_name_appid, $new_value_appid );

	update_option( $option_name_appkey, $new_value_appkey );

 echo '<script type="text/javascript">window.location=" '.  $_SERVER['REQUEST_URI'].' ";</script>';

   



} else {



    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.

    $deprecated = null;

    $autoload = 'no';

    add_option( $option_name_appid, $new_value_appid, $deprecated, $autoload );

	 add_option( $option_name_appkey, $new_value_appkey, $deprecated, $autoload );

 echo '<script type="text/javascript">window.location=" '.  $_SERVER['REQUEST_URI'].' ";</script>';

   

}







}







// save featured


























//end common form

}





/***/

function easysummit_ezs_form_tax_list( $taxonomies, $is_hrh_page=true ){



    if( is_array($taxonomies) && !empty($taxonomies) ){



        $count = 0;

        

        $label = ($is_hrh_page) ? '' : '';

        

        echo '<p><strong>'.__( $label ,'hrh-ez' ).'</strong></p>';

        echo '<ul class="ezs-list">';

            foreach( $taxonomies as $taxonomy ){



                /* get taxonomy details */

               $tax_details    =   ($is_hrh_page) ?  get_taxonomy($taxonomy) : get_post_type_object($taxonomy);

                

                /* get name (Label) of taxonomy */

                $tax_name       =   $tax_details->label;

                

                echo '<li><input type="checkbox" name="select_taxonomy['.$count.']" id="select_taxonomy'.$count.'" value="'.$taxonomy.'" checked=checked/>

				<label for="select_taxonomy['.$count.']" id="select_taxonomy_label'.$count.'"><!--'.$tax_name.'--></label>

				

				</li>';



                unset($tax_details);

                unset($tax_name);



                $count++;

            }

        echo '</ul>';



    }

}



/***/

function easysummit_ezs_create_taxonomy(){

    

    echo '<h3><strong>Create Series</strong></h3>';

    

    if( isset( $_POST['ez_submit'] ) && !empty($_POST['ez_hrh_slug']) && !empty($_POST['ez_hrh_name'])  ){

        

        $associate_posts = !empty($_POST['select_taxonomy']) ? $_POST['select_taxonomy'] : array();



        $new_taxonomy = array( 'slug'=>$_POST['ez_hrh_slug'], 'name'=>$_POST['ez_hrh_name'], 'associate_posts'=>$associate_posts );

        

        $available_ct  =   get_option( 'ezs_custom_tax', array() );



        if( is_array($available_ct) && !empty($available_ct) ){

            

            /* Insert new post type into our post types carrying array. */

            $total_count = count($available_ct);

            $total_count = ++$total_count;

            /* Here it will get inserted */

            $available_ct[$total_count] = $new_taxonomy;

        }else{

            $available_ct[0] = $new_taxonomy;

        }



        update_option( 'ezs_custom_tax', $available_ct );

        

        echo '<p>Series added to WP Admin Menu. <br>Please go to the Series to add events</p>';

        echo '<script type="text/javascript">window.location=" '.  $_SERVER['REQUEST_URI'].' ";</script>';

    }else{



        /* Display Form */

        easysummit_ezs_common_form(false);

    }

}



/***/

function easysummit_ezs_tax_list( $is_hrh_page=true ){

    $taxonomies         =   null;

    $internal_taxonomies = ($is_hrh_page==true) ?  array( 'nav_menu', 'post_format','link_category' ) : array( 'revision', 'attachment','nav_menu_item','page' );

    $taxonomies = ($is_hrh_page==true) ? get_taxonomies() : get_post_types();    

    $taxonomies = array_diff($taxonomies,$internal_taxonomies);

    return $taxonomies;

}



    



/*Function for debugging*/

//function dbg( $data ){  echo '<pre>';print_r($data);echo '</pre>';exit();}





?>
