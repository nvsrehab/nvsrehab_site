<?php
/*
Plugin Name: VodPod Videos Widget
Description: Lets you post videos from any site that supports EMBEDs to the sidebar of your blog.  Also allows you to put a horizontal video widget on your page, as well as a full video gallery.
Author: Vodpod and Crowd Favorite
Version: 2.0.1
Author URI: http://vodpod.com
*/

function vp_public_head() {
}
add_action('wp_head', 'vp_public_head');

function vp_replace($content) {
	$pods = array(
		'sidebar' => array(
                        "/\[vodpod_sidebar pod=(\w+)\s*(?:options=((?:(?:options\[\w+\]\=\w+\&?)|(?:[\w_]+=[\w%\d]+\&?))+))?\s*(?:divId=([\w_-]+))?\]/"
			, '<div id="%DIVID%"><div id="%DIVID%_link"><a href="%POD_LINK%">see all videos</a></div></div>
<script src="http://widgets.vodpod.com/javascripts/recent_videos.js?id=%POD%&amp;
options[div_id]=%DIVID%&amp;v=2&amp;type=wpp&amp;options[theme]=sidebar3&amp;%OPTIONS%"></script>'
		)
		,'header' => array(
                        "/\[vodpod_header pod=(\w+)\s*(?:options=((?:(?:options\[\w+\]\=\w+\&?)|(?:[\w_]+=[\w%\d]+\&?))+))?\s*(?:divId=([\w_-]+))?\]/"
			, '<div id="%DIVID%"><div id="%DIVID%_link"><a href="%POD_LINK%">see all videos</a></div></div>
<script src="http://widgets.vodpod.com/javascripts/recent_videos.js?id=%POD%&amp;
options[div_id]=%DIVID%&amp;options[theme]=horizbar2&amp;options[paging]=true&amp;v=2&amp;type=wpp&amp;%OPTIONS%"></script>'
		)
		, 'gallery' => array(
			"/\[vodpod_gallery pod=(\w+)(?: options=([^\s\]]+))?(?: divId=([\w_-]+))?\]/"
			, '<link href="'.get_bloginfo('wpurl').'/wp-content/plugins/vodpod/gallery.css" media="all" rel="Stylesheet" type="text/css" />
<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/vodpod/prototype.js"></script>
<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/vodpod/builder.js"></script>
<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/vodpod/gallery.js"></script>
<div id="vp_gallery" class="vp_gallery">
<a href="http://vodpod.com">Video Gallery powered by Vodpod</a>
</div>
<div style="clear:both;"></div>
<script type="text/javascript">
var gallery = new Vodpod.Gallery("%POD%", "js_widget", $("vp_gallery"));
</script>'
		)
	);
	foreach ($pods as $k => $pod) {
		$find = $pod[0];
		$replace = $pod[1];
		$matches = false;
		if (preg_match($find, $content, $matches)) {
			if (!isset($matches[2]) || empty($matches[2])) {
				$matches[2] = '';
			} 
			if (!isset($matches[3]) || empty($matches[3])) {
				$matches[3] = md5(microtime());
			}
			if (preg_match('/^\d+$/', $matches[1])) {
                          $pod_link = "http://vodpod.com/pod/" . $matches[1];
         		} else {
			  $pod_link = "http://" . $matches[1] . ".vodpod.com";
			}
                        $matches[4] = $pod_link;
			$replace = str_replace(array('', '%POD%', '%OPTIONS%', '%DIVID%','%POD_LINK%'), $matches, $replace);
			$content = preg_replace($find, $replace, $content);
		}
	}
	return $content;
}

function vp_the_content($content) {
	return vp_replace($content);
}
add_action('the_content', 'vp_the_content');

function vp_template($shortcode) {
	echo vp_replace($shortcode);
}

function vp_init() {
	if (isset($_GET['vp_action'])) {
		switch ($_GET['vp_action']) {
			case 'new_post':
				$page = 'post-new.php';
			case 'new_page':
				$page = 'page-new.php';
				if (!empty($_GET['shortcode'])) {
					header('Location: '.get_bloginfo('wpurl').'/wp-admin/post-new.php?content='.stripslashes(urlencode($_GET['shortcode'])));
					die();
				}
				break;
		}
	}
}
add_action('init', 'vp_init');


/* Sidebar Widget */
// Put functions into one big function we'll call at the plugins_loaded
// action. This ensures that all required plugin functions are defined.
function widget_vodpod_init() {

	// Check for the required plugin functions. This will prevent fatal
	// errors occurring when you deactivate the dynamic-sidebar plugin.
	if ( !function_exists('register_sidebar_widget') )
		return;

	function widget_vodpod($args) {
		
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

		// Each widget can store its own options. We keep strings here.
		$options = get_option('widget_vodpod');
		$podurl = htmlspecialchars(strip_tags(stripslashes($options['podurl'])), ENT_QUOTES);

		// These lines generate our output. Widgets can be very complex
		// but as you can see here, they can also be very, very simple.
		echo $before_widget . $before_title . $title . $after_title;
		$url_parts = parse_url(get_bloginfo('home'));
		$theme = htmlspecialchars(strip_tags(stripslashes($options['theme'])), ENT_QUOTES);
		$category = htmlspecialchars(strip_tags(stripslashes($options['category'])), ENT_QUOTES);
		$category_name = htmlspecialchars(strip_tags(stripslashes($options['category_name'])), ENT_QUOTES);
		$color = str_replace('#', '', htmlspecialchars(strip_tags(stripslashes($options['color'])), ENT_QUOTES));
		$title = htmlspecialchars(strip_tags(stripslashes($options['title'])), ENT_QUOTES);
		$link = '<a href="http://vodpod.com" style="font-size:8pt">see all videos</a>';
		if (preg_match("/^\d+$/", $podurl) == false && preg_match("/^B64/", $podurl) == false && $podurl != '') {
			$link = '<a href="http://' . $podurl . '.vodpod.com" style="font-size:8pt">see all videos</a>';
		}
		
		echo '<div id="vodpod_recent_videos">' . $link . '</div>
		<script src="http://widgets.vodpod.com/javascripts/recent_videos.js?id=' . ($podurl ? $podurl : 'pod') . 
		     ($theme != null && $theme != '' ? '&options[theme]='.$theme : '') . 
		     ($color != null && $color != '' ? '&options[color]='.$color : '') .
		     ($title != null && $title != '' ? '&title='.$title : '') .
		     ($category_name != null && $category_name != '' ? '&category_name='.$category_name : '').
		     (($category_name==null || $category_name=='') && $category != null && $category !='' ? '&category_id='.$category : '') . '"></script>';
		echo $after_widget;
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_vodpod_control() {

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_vodpod');
		if ( !is_array($options) )
			$options = array('podurl'=>'', 'buttontext'=>__('Vod:Pod Videos', 'widgets'));
		if ( $_POST['vodpod-submit'] || $_POST['vodpod_theme'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['podurl'] = htmlspecialchars(strip_tags(stripslashes($_POST['vodpod_podurl'])), ENT_QUOTES);
			$options['title'] = htmlspecialchars(strip_tags(stripslashes($_POST['vodpod_title'])), ENT_QUOTES);
			$options['theme'] = htmlspecialchars(strip_tags(stripslashes($_POST['vodpod_theme'])), ENT_QUOTES);
			$options['category'] = htmlspecialchars(strip_tags(stripslashes($_POST['vodpod_category'])), ENT_QUOTES);
			$options['category_name'] = htmlspecialchars(strip_tags(stripslashes($_POST['vodpod_category_name'])), ENT_QUOTES);
			$options['color'] = htmlspecialchars(strip_tags(stripslashes($_POST['vodpod_color'])), ENT_QUOTES);
			update_option('widget_vodpod', $options);
		}

		// Be sure you format your options to be valid HTML attributes.
		$podurl = htmlspecialchars($options['podurl'], ENT_QUOTES);
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$theme = htmlspecialchars($options['theme'], ENT_QUOTES);
		$category = htmlspecialchars($options['category'], ENT_QUOTES);	
		$category_name = htmlspecialchars($options['category_name'], ENT_QUOTES);
		$color = htmlspecialchars($options['color'], ENT_QUOTES);
		
		// Here is our little form segment. Notice that we don't need a
		// complete form. This will be embedded into the existing form.
		echo '<p style="text-align:left;"></p>';
		echo '<p style="text-align:left;">Add your favorite videos from hundreds of sites to your blog with the <a href="http://vodpod.com" target="_new">Vodpod</a> widget.  If you know the Pod you want to display, type in the URL here.</p>';
		echo '<p style="text-align:left;padding-bottom:10px;border-bottom:1px solid #ccc;"><label for="vodpod_podurl" style="font-weight:bold;">Pod Name:  </label><input style="width: 110px;" id="vodpod_podurl" name="vodpod_podurl" type="text" value="'. $podurl . '" />.vodpod.com</p>';
		echo '<p style="text-align:left;">Do you want a title to be displayed above the widget?</p>';
		echo '<p style="text-align:left;padding-bottom:10px;border-bottom:1px solid #ccc;"><label for="vodpod_title" style="font-weight:bold;">Custom Title:</label> <input style="width: 250px;" id="vodpod_title" name="vodpod_title" type="text" value="'. $title . '" /></p>';
		echo '<p style="text-align:left;">What do you want your widget to look like? <a href="http://vodpod.com/site/blog_badges" target="_new">View different styles</a></p>';
		echo '<p style="text-align:left;padding-bottom:10px;border-bottom:1px solid #ccc;"><label for="vodpod_theme" style="font-weight:bold;">Widget Style:</label>
		      <select style="" id="vodpod_theme" name="vodpod_theme">
		      <option value="sidebar3" '. ($theme=='sidebar3' ? 'selected' : '')  .'>Elegant (4 videos)</option>
		      <option value="mini" ' . ($theme=='mini' ? 'selected' : '') . '>Button (1 video)</option>
		      <option value="sidebar2" ' . ($theme=='sidebar2' ? 'selected' : '') . '>Floating (5 videos)</option>
		      <option value="sidebar1" ' . ($theme=='sidebar1' || $theme=='' ? 'selected' : '') . '>Boxy (5 videos)</option>
		      </select></p>';
		echo '<div id="color_selector">
		      <p style="text-align:left;">How about a different color for your widget?  Enter a Hex Color Code (i.e. #606060) from <a href="http://www.webmonkey.com/reference/color_codes/" target="_new">this chart</a>. (NOTE: Only works for Boxy and Floating styles).</p>
		      <p style="text-align:left;padding-bottom:10px;border-bottom:1px solid #ccc;"><label for="vodpod_color" style="font-weight:bold;">Color:</label> <input style="width: 50px;" id="vodpod_color" name="vodpod_color" type="text" value="'. $color . '" /></p>
		      </div>
		';
		echo '<p style="text-align:left;">Which videos would you like displayed?  We can show Recent, Most Viewed or Random</p>';
		echo '<p style="text-align:left;padding-bottom:10px;border-bottom:1px solid #ccc;"><label for="vodpod_category" style="font-weight:bold;">Video Category:</label>
		      <select style="" id="vodpod_category" name="vodpod_category">
		      <option value="latest" '. ($category=='latest' ? 'selected' : '')  .'>Most Recent</option>
		      <option value="popularity" ' . ($category=='popularity' ? 'selected' : '') . '>Most Viewed</option>
		      <option value="random" ' . ($category=='random' ? 'selected' : '') . '>Random</option>
		      </select>
		      or <label for="vodpod_category_name" style="font-weight:bold">Enter a category name:</label> 
		      <input type="text" name="vodpod_category_name" id="vodpod_category_name" style="width:130px;" value="' . $category_name . '"/>
		      </p>';		
		echo '<p style="text-align:left;"><a href="http://www.vodpod.com/newpod/?r=wordpress" target="_new">Start a Pod</a> if you don\'t have one already to collect videos for your blog.</p>';
		echo '<p style="text-align:left;">And be sure to check out our <a href="http://vodpod.com/wordpress" target="_new">WordPress Firefox extension</a> for easily posting videos to your blog and pod.</p>';
		echo '<input type="submit" id="vodpod-submit" name="vodpod-submit" value="Save" />';
	}
	
	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	register_sidebar_widget(array('Vodpod Videos', 'widgets'), 'widget_vodpod');

	// This registers our optional widget control form. Because of this
	// our widget will have a button that reveals a 300x100 pixel form.
	register_widget_control(array('Vodpod Videos', 'widgets'), 'widget_vodpod_control', 550, 600);
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_vodpod_init');

?>