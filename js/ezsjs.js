/**
 * rtm Javascript.
 */

jQuery(document).ready(function(){
    
    /* Form Slug for new post type by sanitizing title */
    jQuery("#ez_hrh_name").blur(function(){
       
       if( jQuery("#ez_hrh_name").val().trim().length > 0 ){
           
                var ajaxdata = {
                    action: 'ezs_sanitize_title',
                    title:   jQuery("#ez_hrh_name").val().trim()
                };
                
                jQuery.post(ezs_ajaxurl, ajaxdata, function(res){
                    jQuery("#ez_hrh_slug").val(res);
                    jQuery("#ez_hrh_slug").attr('readonly','readonly');
                });
       }else{
           /* If name field is empty, make slug empty */
           jQuery("#ez_hrh_slug").val('');
           jQuery("#ez_hrh_name").val('');
       }
       
    });
    
    /* Validate Menu Icon URL */
    jQuery("#ez_menu_icon").blur(function(){
       
       if( jQuery("#ez_menu_icon").val().trim().length > 0 ){
           
                var ajaxdata = {
                    action: 'ezs_menu_icon',
                    menu_url:   jQuery("#ez_menu_icon").val().trim()
                };
                
                jQuery.post(ezs_ajaxurl, ajaxdata, function(res){
                    jQuery("#ez_error_menu_img").html(res);
                });
       }else{
           jQuery("#ez_error_menu_img").html('');
       }
       
    });
    
});



/*offer popup*/

	 
function elemOn(elem_id){
	if(document.getElementById(elem_id))
		document.getElementById(elem_id).style.display = "block";
}
function elemOff(elem_id){
	if(document.getElementById(elem_id))
		document.getElementById(elem_id).style.display = "none";
}
function showOne(elem_id){
	for( var i = 1; i <= 100; i++ )
		elemOff( 'div'+i );
	elemOn( elem_id );
}
function showeOne(elem_id){
	for( var i = 1; i <= 100; i++ )
		elemOff( 'div'+i );
	elemOn( elem_id );
}
lastone='empty'; 
function showIt(lyr) 
{ 
	if (lastone!='empty') lastone.style.display='none'; 
	lastone=document.getElementById(lyr); 
	lastone.style.display='block';
}


/*test link*/
	$(document).ready(function() {
	var option = 'div1';
	var url = window.location.href;
	option = url.match(/option=(.*)/)[1];
	showDiv(option);
});
function showDiv(option) {
	$('.boxes').hide();
	$('#' + option).show();
}


//function for add event to calendar
(function () {
            if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
            if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
                var h = d[g]('body')[0];h.appendChild(s); }})();
				
//function [imagegallery] show hide event promo
 function toggle_visibility_promo(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'none')
          e.style.display = 'block';
       else
          e.style.display = 'none';
    }
	
	
	//function [imagegallery] show hide event image
	 function toggle_visibility_image(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
	
	
//function google-hangouts
  window.___gcfg = {
    lang: 'zh-CN',
    parsetags: 'onload'
  };

 <!-- AddThisEvent -->
  
  
<!-- AddThisEvent Settings -->

addthisevent.settings({
	mouse		: false,
	css			: false,
	outlook		: {show:true, text:"Outlook Calendar"},
	google		: {show:true, text:"Google Calendar"},
	yahoo		: {show:true, text:"Yahoo Calendar"},
	ical		: {show:true, text:"iCal Calendar"},
	hotmail		: {show:true, text:"Hotmail Calendar"},
	facebook	: {show:true, text:"Facebook Calendar"}
});
