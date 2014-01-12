<?php
/*
Plugin Name: SocialVibe Badge Widget
Description: SocialVibe allows you to use your blog to earn donations for charity by partnering with a paying brand sponsor.
Author: SocialVibe.com
Version: 1.2.0
Author URI: http://www.socialvibe.com/
*/

/*
 Copyright 2009 SocialVibe (email: cjohnson@socialvibe.com)

 This program is free software; you can redistribute it and/or modify it under the terms
 of the GNU General Public License as published by the Free Software Foundation; either
 version 2 of the License, or any later version.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 See the GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along with this program;
 if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,
 MA  02111-1307  USA
*/

/* Changelog
 * June 10, 2009 - v1.0.0
   - Initial release
 * June 26, 2009 - v1.1.0
 * August 20, 2009 - v1.2.0
*/


// Put functions into one big function we'll call at the plugins_loaded
// action. This ensures that all required plugin functions are defined.
function socialvibe_badge_widget_init() {
	
	// Pre-2.6 compatibility
	if ( !defined( 'WP_CONTENT_URL' ) )
		define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
	if ( !defined( 'WP_CONTENT_DIR' ) )
		define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	if ( !defined( 'WP_PLUGIN_URL' ) )
		define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
	if ( !defined( 'WP_PLUGIN_DIR' ) )
		define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
	
	$source = "org";
	$plugin = 'socialvibe_badge_widget';
	$base = plugin_basename(__FILE__);
	if ($base != __FILE__) {
		$plugin = dirname($base);
	}
	define('SOCIALVIBE_PLUGIN_BASE_URL', WP_PLUGIN_URL . '/' . $plugin);
	
	
	// Check for the required plugin functions. This will prevent fatal
	// errors occurring when you deactivate the dynamic-sidebar plugin.
	if ( !function_exists('register_sidebar_widget') )
		return;	

	// This is the function that outputs the SocialVibe data.
	function socialvibe_badge_widget($args) {
		
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

		// Each widget can store its own options. We keep strings here.
		$options = get_option('socialvibe_badge_widget');
		$sponsorship_id = $options['sponsorship_id'];
		$sponsorship_width = $options['sponsorship_width'];
		$sponsorship_height = $options['sponsorship_height'];
		$socialvibe_app_user_id = $options['app_user_id'];

		// These lines generate our output. Widgets can be very complex
		// but as you can see here, they can also be very, very simple.
		$title = "SocialVibe";
		echo $before_widget . $before_title . $title . $after_title;
		
		// Check to make sure the username and password are set
		//if(empty($sponsorship_id)) {
    //    echo "Please enter your sponsorship_id";  
    //}
		
		//$url_parts = parse_url(get_bloginfo('home'));
		echo '<div style="margin-top:5px;margin-bottom:5px;text-align:left;">';
		output_sv($socialvibe_app_user_id);
		echo '<br/></div>';
		echo $after_widget;
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function socialvibe_badge_widget_control() {
				
		$options = get_option('socialvibe_badge_widget');
		if ( !is_array($options) ) {
			$options = array();
			//$options = array('sponsorship_id'=>'');
			//$options = array('access_token'=>'');
		}
			
		if ( $_POST['socialvibe_submit'] ) {
			// Remember to sanitize and format use input appropriately.
			$options['app_user_id'] = strip_tags(stripslashes($_POST['sv_app_user_id']));
			$options['access_token'] = strip_tags(stripslashes($_POST['sv_access_token']));
			$options['access_secret'] = strip_tags(stripslashes($_POST['sv_access_secret']));
			update_option('socialvibe_badge_widget', $options);
		}
		
		// Be sure you format your options to be valid HTML attributes.
		$app_user_id = htmlspecialchars($options['app_user_id'], ENT_QUOTES);
		$access_token = htmlspecialchars($options['access_token'], ENT_QUOTES);
		$access_secret = htmlspecialchars($options['access_secret'], ENT_QUOTES);
		
		$url = 'http://media.socialvibe.com/WordPressShell.swf';
		$width = 450;
		$height = 586;

		echo '<input id="sv_app_user_id" name="sv_app_user_id" type="hidden" value="'.$app_user_id.'" />';
		echo '<input id="sv_access_token" name="sv_access_token" type="hidden" value="'.$access_token.'" />';
		echo '<input id="sv_access_secret" name="sv_access_secret" type="hidden" value="'.$access_secret.'" />';
		echo '<input id="socialvibe_submit" name="socialvibe_submit" type="hidden" value="1" />';		

		$javascript_method_for_flash 	= <<<JAVASCRIPT
			<script type="text/javascript">
				function socialvibe_receive_data(app_user_id, access_token, access_secret)
				{
					jQuery("#sv_app_user_id").val(app_user_id);
					jQuery("#sv_access_token").val(access_token);
					jQuery("#sv_access_secret").val(access_secret);
					//jQuery("#sv_app_user_id").parents("form").submit();
					var theform = jQuery("#sv_app_user_id").parents("form");
					jQuery.ajax({ data: theform.serialize(), url: "widgets.php", type: theform.attr("method"), timeout: 5000, error: function() { alert("Please try again."); } });
				}
			</script>
JAVASCRIPT;
			echo $javascript_method_for_flash;

	// Removed for now since Wordpress TOS won't allow us to use this without the user's permission
		global $current_user;
    	get_currentuserinfo();
		$email = $current_user->user_email;
		$avatar_url = null;
		
		if (function_exists('get_avatar')) {
			$avatar_embed = get_avatar($email);
			preg_match("/src='([^']*)'/", $avatar_embed, $matches);
			if($matches[1]) {
				$avatar_url = $matches[1];
			}
	   } else {
			//alternate gravatar code for < 2.5
			$avatar_url = "http://www.gravatar.com/avatar.php?gravatar_id=" . 
				md5($email) . "&default=" . urlencode($default) . "&size=" . $size;
	   }
	   
		$user_vars = 'blog_url=' . get_option('siteurl') . '&' . 'blog_name=' . get_option('blogname') . '&' . 'avatar_url=' . $avatar_url;
		
		$flashvars = 'auid=' . $app_user_id . '&access_token=' . $access_token . '&access_secret='. $access_secret . '&source=' . $source . '&' . $user_vars . '';
		
		echo '<object width="' . $width . '" height="' . $height . '">'.
				'<param name="movie" value="' . $url . '"></param>'.
				'<param name="allowscriptaccess" value="always"></param>'.
				'<param name="flashvars" value="' . $flashvars . '"></param>'.
				'<embed src="' . $url . '" type="application/x-shockwave-flash" allowscriptaccess="always" '.
				'flashvars="' . $flashvars . '" width="' . $width . '" height="' . $height . '"></embed></object>';
	}
		
	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	register_sidebar_widget(array('SocialVibe', 'widgets'), 'socialvibe_badge_widget');

	// This registers our optional widget control form. Because of this
	// our widget will have a button that reveals a 400x300 pixel form.
	register_widget_control(array('SocialVibe', 'widgets'), 'socialvibe_badge_widget_control', 456, 586);

	// include the scripts
	if ( !is_admin() && is_active_widget( 'socialvibe_badge_widget' ) )
	{
		wp_enqueue_script('socialvibe-badge', SOCIALVIBE_PLUGIN_BASE_URL . '/socialvibe-badge.js', array('jquery'));
 		wp_enqueue_script('lightwindow', SOCIALVIBE_PLUGIN_BASE_URL . '/javascript/thickbox.js', array('jquery'));   
	}
}

function output_sv($socialvibe_app_user_id) {
  ?>
  <script type="text/javascript">
    <?php
      echo "new SocialVibeBadge({app_user_id:'".$socialvibe_app_user_id."'});";
    ?>

		function open_lightbox(title, url, width, height)
		{			// 
					// imgLoader = new Image();
					// 		  imgLoader.src = '<?php echo SOCIALVIBE_PLUGIN_BASE_URL . "/images/loadingAnimation.gif"?>';
			SV.tb_show(title, url + "&KeepThis=true&SVTB_iframe=true&height=" + height + "&width=" + width);		

			jQuery("#SVTB_window").css({'overflow' : 'hidden', 'width' : width + 'px'});	
			jQuery("#SVTB_iframeContent").css({'overflow' : 'hidden', 'width' : width + 'px', 'height' : height + 'px', 'margin-top' : '0px'});
			jQuery("#SVTB_title").css({'background-color' : '#525252', 'color' : '#F2F2F2'});
			jQuery("#SVTB_closeWindowButton").css({'color' : '#F2F2F2'}).html("X");
			jQuery("#SVTB_closeAjaxWindow").contents(":last").remove();
		}
  </script>
  <?php
}

function add_header()
{
	echo '<link type="text/css" rel="stylesheet" href="' . SOCIALVIBE_PLUGIN_BASE_URL , '/css/thickbox.css" />' . "\n";
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'socialvibe_badge_widget_init');

add_action('wp_head', 'add_header');
