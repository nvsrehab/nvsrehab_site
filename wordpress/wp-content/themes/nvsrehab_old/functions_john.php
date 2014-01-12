<?php
/*
 * John's function page
 */

namespace john;

function display_recent_news_excerpts($num_excerpts = 1
, $thumb_height = 100
, $thumb_width = 100
, $char_len = 100) {
    $thumb_size = array($thumb_width, $thumb_height);
    $args = array('category_name' => 'news',
        'posts_per_page' => $num_excerpts);
    $recent_posts = new \WP_Query($args);
    while ($recent_posts->have_posts()) {
        ?><span class="excerpt"><?php
        $post = $recent_posts->the_post();
        $permalink = \get_permalink($post->ID);
        if (has_post_thumbnail($post->ID)) {
            echo get_the_post_thumbnail($post->ID, $thumb_size, array('class' => 'excerpt_thumb'));
        }
        ?><h4 class="excerpt_title"><a href="<?php
            echo $permalink;
            ?>"><?php the_title(); ?></a></h4>
                <p class="excerpt_body"><?php
                    get_char_limited_excerpt($char_len, $permalink);
                    ?></p><div style="clear:both;"></div></span><?php
    }
    wp_reset_postdata();
}

function get_char_limited_excerpt($char_len, $permalink = '') {
    $excerpt = get_the_excerpt();
    $char_len++;
    if (mb_strlen($excerpt) > $char_len) {
        $subex = mb_substr($excerpt, 0, $char_len - 5);
        $exwords = explode(' ', $subex);
        $excut = - ( mb_strlen($exwords[count($exwords) - 1]) );
        if ($excut < 0) {
            echo mb_substr($subex, 0, $excut);
        } else {
            echo $subex;
        }
        echo '<a href="' . $permalink . '">[...]</a>';
    } else {
        echo $excerpt;
    }
}

function display_pre_footer_links(){
    $args = array('category_name' => 'Pre-footer Links');
    $links = get_bookmarks($args);
    //echo \htmlspecialchars(\print_r($links, true));
    $before_url = '<p><a href="';
    $middle = '">';
    $after_title = '</a><p>';
    foreach($links as $link){
        $title = $link->link_name;
        $url = $link->link_url;
        echo $before_url.$url.$middle.$title.$after_title;
    }
}



// add_action('wp_footer', '\\john\\display_recent_news_excerpts');
?>
