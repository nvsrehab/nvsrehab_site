var Vodpod = {};
Vodpod.Gallery = Class.create();

Vodpod.Gallery.prototype = {
  pod_id: null,
  api_key: null,
  videos: [],
  gallery_node: null,
  videos_node: null,
  current_page: 1,
  active_video: null,
  
  initialize: function(pod_id, api_key, gallery_node)
  {
    this.gallery_node = gallery_node;
    this.pod_id = pod_id;
    this.api_key = api_key;
    
    this.gallery_node.innerHTML = '';

    // create the display containers
    this.gallery_node.appendChild(Builder.node('div', {className:'vp_gallery_top'}));

    this.container_node = this.gallery_node.appendChild(Builder.node('div', {className:'vp_container'}));
    this.header_node = this.container_node.appendChild(Builder.node('div', {className:'vp_header'}));
    this.videos_node = this.container_node.appendChild(Builder.node('div', {className:'vp_video_thumbs'}));

    this.player_node = this.container_node.appendChild(Builder.node('div', {className:'vp_video_player'}));
    this.title_node = this.player_node.appendChild(Builder.node('div', {className:'vp_video_title'}));
    this.embed_node = this.player_node.appendChild(Builder.node('div', {className:'vp_embed_holder'}));
    this.metadata_node = this.player_node.appendChild(Builder.node('div', {className:'vp_metadata'}));
    this.description_node = this.metadata_node.appendChild(Builder.node('div', {className:'vp_video_description'}));
    
    this.views_node = this.metadata_node.appendChild(Builder.node('div', {className:'vp_video_views'}));
    this.source_node = this.metadata_node.appendChild(Builder.node('div', {className:'vp_video_source'}));
    this.date_node = this.metadata_node.appendChild(Builder.node('div', {className:'vp_video_date'}));
    this.metadata_node.appendChild(Builder.node('div', {className:'clear'}));
    this.links_node = this.metadata_node.appendChild(Builder.node('div', {className:'vp_video_links'}));
    this.collectors_link_node = this.links_node.appendChild(Builder.node('a', {href:'#'}, ''));

    this.container_node.appendChild(Builder.node('div', {className:'clear'}));

    this.pagination_node = this.container_node.appendChild(Builder.node('div', {className:'vp_pagination'}));
    this.previous_node = this.pagination_node.appendChild(
      Builder.node('a', {href:'#'},
        [Builder.node('img', {src:'http://vodpod.com/images/widget/left_blue.gif'})]
      )
    );
    this.next_node = this.pagination_node.appendChild(
      Builder.node('a', {href:'#'},
        [Builder.node('img', {src:'http://vodpod.com/images/widget/right_blue.gif'})]
      )
    );
    this.container_node.appendChild(Builder.node('div', {className:'clear'}));

    this.footer_node = this.gallery_node.appendChild(Builder.node('div', {className:'vp_footer'}));
    this.footer_node.innerHTML = '<div style="float:right;">\
    <div style="float:left">I collect with</div>\
    <img src="http://vodpod.com/images/widget/logo_10px.png" class="vodpod_png vp_logo"/>\
    <div style="float:left;display:inline;">vodpod</div>\
    </div>\
    <div style="clear:both;"></div>';

    this.bottom_node = this.gallery_node.appendChild(Builder.node('div', {className:'vp_gallery_bottom'}));
    
    this.previous_node.onclick = this.loadPrevious.bind(this);
    this.next_node.onclick = this.loadNext.bind(this);
    
    // Load the videos, once the page has been loaded
    addLoadEvent( (function() {this.loadGroupData();this.loadVideos()}).bind(this) );
  },
  
  loadGroupData: function()
  {
    url = 'http://vodpod.com/api/pod/details.js?pod_id=' + this.pod_id + "&api_key=" + this.api_key + "&callback=gallery.setGroupData";

    var json_script = document.createElement('script');
    json_script.src = url;
    document.body.appendChild(json_script);    
  },
  
  setGroupData: function(json)
  {
    this.header_node.innerHTML = '<a href="http://' + json.pod.subdomain + '.vodpod.com">' + json.pod.name + '</a>';
  },
  
  loadVideos: function(options)
  {
    var opts = {
      category_id: null, page: 1, sort: 'date-desc'
    }
    Object.extend(opts, options || {});
    this.current_page = opts.page;
    
    url = 'http://vodpod.com/api/pod/videos.js?pod_id=' + this.pod_id + "&api_key=" + this.api_key + "&callback=gallery.createVideos";
    if (opts.category_id)
      url += "&category_id=" + opts.category_id;
    if (opts.page)
      url += "&page=" + opts.page;
    if (opts.sort)
      url += "&sort=" + opts.sort;
    
    // Grey out the video list
    //this.videos_node.setStyle({opacity:0.3});
    
    var json_script = document.createElement('script');
    json_script.src = url;
    document.body.appendChild(json_script);
  },
  
  createVideos: function(json)
  {
    this.clearVideos();
    json.videos.items.each( (function(item) {
      var v = new Vodpod.Video(item.video, this);
      this.videos.push(v);
    }).bind(this));

    // Un-Grey the video list
    //this.videos_node.setStyle({opacity:1});
    
    // Activate/deactivate pagination arrows
    if (json.videos.total > this.current_page*10) {
      this.next_node.className = 'active';
    } else {
      this.next_node.className = 'inactive';
    }

    if (this.current_page > 1) {
      this.previous_node.className = 'active';
    } else {
      this.previous_node.className = 'inactive';
    }
    
    // Load the first video into the player (if one isn't already loaded)
    if (!this.active_video)
      this.videos[0].loadVideo(false);
  },
  
  clearVideos: function()
  {
    this.videos = [];
    this.videos_node.innerHTML = '';
  },
  
  loadNext: function()
  {
    this.loadVideos({page: this.current_page+1});
    return false;
  },
  
  loadPrevious: function()
  {
    this.loadVideos({page: this.current_page-1});
    return false;
  }
};

Vodpod.Video = Class.create();
Vodpod.Video.prototype = {
  id: null,
  pod_id: null,
  title: null,
  description: null,
  tags: null,
  created_at: null,
  link: null,
  embed_tag: null,
  autoplay_embed_tag: null,
  thumbnail_small: null,
  thumbnail_medium: null,
  total_views: null,
  weekly_views: null,
  num_collectors: 1,
  node: null,
  gallery: null,
  
  initialize: function(video, gallery)
  {
    this.gallery = gallery;
    
    this.id = video.video_id;
    this.pod_id = video.pod_id;
    this.title = video.title;
    this.description = video.description;
    this.tags = video.tags;
    this.created_at = video.created_at;
    this.link = video.link;
    this.embed_tag = video.embed_tag;
    this.autoplay_embed_tag = video.autoplay_embed_tag;
    this.thumbnail_small = video.thumbnails.small;
    this.thumbnail_medium = video.thumbnails.medium;
    this.total_views = video.stats.total_views;
    this.weekly_views = video.stats.weekly_views;
    this.num_collectors = video.num_collectors;
    
    this.createElement();
  },
  
  createElement: function()
  {
    this.node = Builder.node('div', {id:'vp_video_' + this.id, className:'video_thumb', video_id:this.id},
      [Builder.node('img', {className:'thumbnail', src:this.thumbnail_small}),
       Builder.node('div', {className:'thumb_title_box'}),
       Builder.node('div', {className:'thumb_title'},
         [Builder.node('span', {className:'number'}), this.title])]);
    this.node.onclick = this.loadVideo.bind(this, true);
    
    this.gallery.videos_node.appendChild(this.node);
  },
  
  loadVideo: function(autoplay)
  {
    var embed = (autoplay == true) ? this.autoplay_embed_tag : this.embed_tag;
    
    var title_node = Builder.node('a', {href:this.link}, this.title);
    this.gallery.title_node.innerHTML = '';
    this.gallery.title_node.appendChild(title_node);
    this.gallery.embed_node.innerHTML = embed;
    this.gallery.description_node.innerHTML = this.description;
    this.gallery.views_node.innerHTML = this.total_views + ' views';
    this.gallery.date_node.innerHTML = "Added " + this.formattedDate();
    
    if (this.num_collectors >= 0)
    {
      this.gallery.collectors_link_node.href = this.link;
      this.gallery.collectors_link_node.innerHTML = 'Collected by ' + this.num_collectors + ' people';
    } else {
      Element.hide(this.gallery.collectors_link_node);
    }
    
    this.gallery.active_video = this;
  },
  
  formattedDate: function()
  {
    date_match = this.created_at.match(/(\d{1,2} \w{3,4}) \d*?(\d{2})\b/);
    return date_match[1] + " " + date_match[2];
  }
};

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	}
	else {
		window.onload = function() {
			oldonload();
			func();
		}
	}
}