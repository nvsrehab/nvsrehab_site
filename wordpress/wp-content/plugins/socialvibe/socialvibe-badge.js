var SocialVibeBadge = function(options) {
  this.init(options);
}
jQuery.extend(SocialVibeBadge.prototype, {
	init: function(options)
	{
		this.options =
	  {
		  host: 'http://media.socialvibe.com',
		
		  app_user_id: ''    // socialvibe app user id
	  };
		if(options)
		{
			this.options.app_user_id = options.app_user_id;
		}
		
		var app_user_id = this.options.app_user_id;
		var params =
		{
			host: this.options.host,
			app_user_id: this.options.app_user_id
		};
				
		var pre_div = '<div id="socialvibe_badge"></div>';
		document.write(pre_div);
		
		var max_sponsorship_width = 200;
		var max_sponsorship_height = 388;

		var width = this.get_widget_width(max_sponsorship_width,max_sponsorship_width);
		var height = width * max_sponsorship_height/max_sponsorship_width;	
		
		var html = '<style type="text/css"> div.SV_Badge { text-align:center; top-margin:0pt; } </style>' + 
				   '<div class="SV_Badge" style="padding:0px; border:0px; margin:0px;">' + 
				   '<object width="' + width + '" height="' + height + '">' + 
				   '<param name="movie" value="http://media.socialvibe.com/wp2.swf?auid=' + app_user_id + '"/>' +
				   '<param name="wmode" value="transparent"/>' +
				   '<param name="allowScriptAccess" value="always"/>' +
				   '<param name="flashvars" value="auid=' + app_user_id + '&width=' + width + '&height=' + height + '"/>' +
				   '<embed src="http://media.socialvibe.com/wp2.swf?auid=' + app_user_id + '" type="application/x-shockwave-flash" ' +
				      'wmode="transparent" allowScriptAccess="always" flashvars="auid=' + app_user_id + "&width=" + width + "&height=" + height +
				      '" width="' + width + '" height="' + height + 
				   '"></embed></object><br/><a href="http://www.socialvibe.com/?rs=wp_badge"><img src="http://media.socialvibe.com/m/networks/wordpress/sv_powered.png" width="' + 
				   width + '" border="0"/></a></div>';

		jQuery("#socialvibe_badge").html(html);
	},	
	
	get_widget_width: function(default_width,max_width)
	{
		try
		{
			var theDiv = jQuery("#socialvibe_badge").parent("div");
			var totalWidth = theDiv.width();
			totalWidth -= this.extract_css_value(theDiv.css("padding-left")) + this.extract_css_value(theDiv.css("padding-right")); // Total Padding Width
			totalWidth -= this.extract_css_value(theDiv.css("margin-left")) + this.extract_css_value(theDiv.css("margin-right")); // Total Margin Width
			totalWidth -= this.extract_css_value(theDiv.css("borderLeftWidth")) + this.extract_css_value(theDiv.css("borderRightWidth")); // Total Border Width
			return Math.min(totalWidth,max_width);
		}
		catch(e) 
		{
			alert(e);
			return default_width;
		}
	},
	
	extract_css_value: function(value)
	{
		return parseInt(value.replace("px",""), 10) || 0;
	}
});
