=== Vodpod Videos Widget ===
Contributors: spencermiles, alexkingorg
Tags: videos, video, vodpod, youtube, sidebar, widget, widgets, gallery
Requires at least: 2.0.2
Tested up to: 2.6.2
Stable tag: 2.0.1

The Vodpod plugin allows bloggers to add an interactive video gallery to their blogs, allowing their readers and visitors to watch videos they've collected from 1000s of sites on the Net.

== Description ==

The Vodpod plugin allows you to collect videos from thousands of sites on the Net, and put them in your blog with an interactive gallery.

Your users and readers can scroll through 100s -- even 1000s -- of videos you've collected without having to leave your blog. Playback of the video occurs in the widget, on your blog. 

You can set up your gallery so that it displays the most recent videos you've collected, or a more specific selection of videos, arranged in a specific order.

[Examples](http://vodpod.com/site/blog_badges "Widget examples")

Also be sure to checkout the [Wordpress video extension for Firefox](http://vodpod.com/wordpress), which is powered by Vodpod, and makes it a snap to add videos to your blog.

Special thanks to Alex King at [Crowd Favorite](http://crowdfavorite.com) for creating the Gallery and Horizontal portions of the plugin!

== Installation ==

If you don't already have a Vodpod account, create one here:
[http://vodpod.com/newpod?r=wordpress](http://vodpod.com/newpod?r=wordpress)

If you don't want to create an account, you can still install the widget, and we'll display videos we think are cool.

1. Download the plugin archive and expand it (you've likely already done this).
2. Put the 'vodpod_widget.php' file and 'vodpod' folder into your wp-content/plugins/ directory.
3. Go to the Plugins page in your WordPress Administration area and click 'Activate' for the Vodpod plugin.

= To create a Sidebar Widget: =

1. Go to the Presentation menu, and click 'Sidebar Widgets'.
2. Drag "Vodpod Videos" to your Sidebar, and click the icon next to it to show the configuration details.
3. Enter your Pod URL, and customize the style, title, and color as you like.

= To create a Gallery: =

1. Go to "Write" followed by "Write Page" in your WordPress Administration area.
2. Write `[vodpod_gallery pod=YourPodSubdomain]`, and click Publish.  YourPodSubdomain will be the text that comes before '.vodpod.com' on your pod homepage.  For example, you would use 'funnyvideos' if your pod was http://funnyvideos.vodpod.com.

= To create a Horizontal widget: =

1. Go go Presentation and choose Theme Editor in your Wordpress administration area.
2. Select the 'Header' file from the right hand side of the theme editor.
3. Add `<?php vp_template('[vodpod_header pod=YourPodSubdomain]'); ?>` wherever you want the vodpod sidebar widget to appear.
4. Click Update File

== Frequently Asked Questions ==

Please see our FAQs online: [http://blog.vodpod.com/?page_id=99](http://blog.vodpod.com/?page_id=99)

* Ask us a question!  support@vodpod.com

== Screenshots ==

1. Sidebar Widget from geekblog.vodpod.com
2. Sidebar Configuration page
3. Gallery
4. Horizontal Widget
