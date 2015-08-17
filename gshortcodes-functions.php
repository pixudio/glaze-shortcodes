<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if( !function_exists('hb_recognized_shortcodes') ) :

	function hb_recognized_shortcodes() {

		$shortcodes = array(
                'hb_hr',
                'hb_space',
                'hb_row',
                'hb_col',
                'hb_blockquote',
                'hb_fancy_list',
                'hb_li',
                'hb_button',
                'hb_alert',
                'hb_accordion',
                'hb_toggle',
                'hb_tabpanel',
                'hb_tab',
                'hb_icon_box',
                'hb_service_big_title',
                'hb_service_custom_icon',
                'hb_service_box_icon',
                'hb_service_box_image',
                'hb_panel',
                'hb_headline',
                'hb_animated_string',
                'hb_theme_slider',
                'hb_post_carousel',
                'hb_ampersand',
                'hb_side_by_side',
                'hb_side',
                'hb_countup',
                'hb_team',
                'hb_map',
                'hb_client_group',
                'hb_client',
                'hb_testimonial',
                'hb_quote',
                'hb_callout',
                'hb_video',
                'hb_video_popup_img',
                'hb_video_popup_btn',
                'hb_posts',
                'hb_pricing',
                'hb_instagram_feed',
                'hb_twitter_feed',
                'hb_progress',
                'hb_icon',
                'hb_banner',
                'hb_description',
                'hb_works',
                'hb_work_carousel',
                'hb_works_grid',
                'hb_works_masonry',
			);

            if ( class_exists( 'WooCommerce' ) ){

                $hb_shortcodes_init[] = 'hb_thumbnail_products';
            }

        return apply_filters( 'hb_recognized_shortcodes', $shortcodes );
	}

endif;

 
if( !function_exists('hb_shortcodes_wpautop_fix') ) {

	/*
	 * Remove auto paragraph and line breaks which wpautop added to shortcodes
	 */    
    function hb_shortcodes_wpautop_fix($content){   
	
		$all_shortcodes = hb_recognized_shortcodes();
		$fix_shortcodes = (array) apply_filters( 'hb_shortcodes_wpautop_fix', $all_shortcodes );

        $block = join("|", $fix_shortcodes);
         
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
         
        return $rep;
    }
    add_filter('the_content', 'hb_shortcodes_wpautop_fix');    
}


/*
|--------------------------------------------------------------------------
| Shortcodes
|--------------------------------------------------------------------------
*/

// BOOTSTRAP ROW
if( !function_exists('hb_row_shortcode') ) { 
 
    function hb_row_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'class'    => ''   
             
        ), $atts));

        return '<div class="row hb-animate-group '.esc_attr($class).'">'.do_shortcode($content).'</div>';
    }

    add_shortcode('hb_row', 'hb_row_shortcode');
}

// BOOTSTRAP COL
if( !function_exists('hb_col_shortcode') ) { 
 
    function hb_col_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'class'        => '',
             'column'       => '6',
             'offset'       => '',
             'hidemobile'   => '',
             'hidetablet'   => '',
             'animation'    => '',
             
        ), $atts));

        $classes = array();

        $activated  = hb_shortcode_active_option_values();

        $classes[] = 'col-sm-'.$column;

        if ( in_array($hidemobile, $activated) ){

            $classes[] = 'hidden-xs';
        }

        if ( in_array($hidetablet, $activated) ){

            $classes[] = 'hidden-sm';
        }

        if ( $offset ){

            $classes[] = 'col-sm-offset-'.$offset;
        }

        if ( $animation ){

            if ( $animation != 'none' ){

                $classes[] = 'hb-animate';

                $animation = ' data-animation="'. esc_attr($animation) .'"';

            } else {
                
                $animation = '';
            }
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        return '<div class="'.esc_attr($classes).'"'.$animation.'>'.do_shortcode($content).'</div>';
    }

    add_shortcode('hb_col', 'hb_col_shortcode');
}

// SIDE BY SIDE
if( !function_exists('hb_side_by_side_shortcode') ) { 
 
    function hb_side_by_side_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'sides'    => '2',
             'class'    => ''
             
        ), $atts));

        $classes = array();

        $classes[] = 'hb-sbs hb-animate-group';

        if ( $sides )

            $classes[] = 'hb-sides-'. $sides;

        if ( $class )

            $classes[] = $class;

        $classes = implode(' ', $classes);

        $output = '<div class="'.esc_attr($classes).'">' . do_shortcode($content) . '</div>';

        return $output;
    }

    add_shortcode('hb_side_by_side', 'hb_side_by_side_shortcode');
}

if( !function_exists('hb_side_shortcode') ) { 
 
    function hb_side_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'background_color'   => '',
             'background'   => '',
             'class'        => '',
             'padding'      => '',
             'animation'    => '',
             'tiny_content' => '',

        ), $atts));

        $activated  = hb_shortcode_active_option_values();

        $classes = array();

        $classes[] = 'hb-side';

        $style = '';

        if ( $background_color ){

            $style .= 'background-color:' . $background_color . ';';
        }

        if ( $background ) {

            $style .= 'background-image:url(' . $background . ');';
        }

        if ( '' != $style ) { $style = ' style="'. esc_attr($style) .'"'; }

        if ( in_array($padding, $activated) ){

            $classes[] = 'hb-side-padding';
        }

        if ( $animation ){

            if ( $animation != 'none' ){

                $classes[] = 'hb-animate';

                $animation = ' data-animation="'. esc_attr($animation) .'"';

            } else {
                
                $animation = '';
            }
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $content_class = ( in_array($tiny_content, $activated) ) ? 'tiny-content hb-side-content clearfix' : 'hb-side-content clearfix';

        $output  = '<div class="'.esc_attr($classes).'"'.$style.$animation.'>';
            $output .= '<div class="'.$content_class.'">';
                $output .= do_shortcode($content);
            $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_side', 'hb_side_shortcode');
}

// ACCORDION SHORTCODE
if( !function_exists('hb_accordion_shortcode') ) { 
 
    $accordion = 0;

    function hb_accordion_shortcode($atts, $content = null) {

        global $accordion;
                
        extract(shortcode_atts(array(
             
             'class'    => ''   
             
        ), $atts));

        $accordion++;

        return '<div class="panel-group '.esc_attr($class).'" id="accordion-'.$accordion.'">'.do_shortcode($content).'</div>';
    }

    add_shortcode('hb_accordion', 'hb_accordion_shortcode');
}

if( !function_exists('hb_toggle_shortcode') ) {

    $accordion_toggle = 0; 
 
    function hb_toggle_shortcode($atts, $content = null) {

        global $accordion, $accordion_toggle;
                
        extract(shortcode_atts(array(
             
             'state'    => 'closed',
             'title'    => '',
             
        ), $atts));

        $accordion_toggle++;

        $state = ('open' == $state) ? array('toggle' => 'collapsed app-link', 'panel' => 'in') : array('toggle' => 'app-link', 'panel' => '');

        $output  = '<div class="panel panel-default">';
            $output  .= '<div class="panel-heading" id="heading-'.$accordion_toggle.'">';
                $output  .= '<strong class="panel-title">';
                    $output  .= '<a class="'.$state['toggle'].'" data-parent="#accordion-'.$accordion.'" data-toggle="collapse" href="#collapse-'.$accordion_toggle.'">'.$title.'</a>';
                $output  .= '</strong>';
            $output  .= '</div>';

            $output  .= '<div class="panel-collapse collapse '.$state['panel'].'" id="collapse-'.$accordion_toggle.'">';
                $output  .= '<div class="panel-body">';
                    $output  .= do_shortcode($content);
                $output  .= '</div>';
            $output  .= '</div>';
        $output  .= '</div>';

        return $output;
    }

    add_shortcode('hb_toggle', 'hb_toggle_shortcode');
}


// ALERT SHORTCODE
if( !function_exists('hb_alert_shortcode') ) { 
 
    function hb_alert_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'class'        => '',
             'type'         => 'warning',
             'dismissible'  => '',
             
        ), $atts));

        $type = trim(strtolower($type));
        $dismissible = trim(strtolower($dismissible));

        $maybe_close_btn = '';

        $classes = array();

        $activated  = hb_shortcode_active_option_values();

        if ( in_array($dismissible, $activated) ){

            $classes[] = 'alert-dismissible';

            $maybe_close_btn = '<button class="close" type="button" data-dismiss="alert">&times;<span class="sr-only">Close</span></button> ';
        }

        $classes[] = 'alert  alert-' . $type;

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        return '<div class="'.esc_attr($classes).'">'.$maybe_close_btn . do_shortcode($content).'</div>';
    }

    add_shortcode('hb_alert', 'hb_alert_shortcode');
}

// AMPERSAND SHORTCODE
if( !function_exists('hb_ampersand_shortcode') ) { 
 
    function hb_ampersand_shortcode($atts, $content = null) {
                

        return '<em class="hb-ampersand">&</em>';
    }

    add_shortcode('hb_ampersand', 'hb_ampersand_shortcode');
}

// SHORTCODE ANIMATED STRING
if( !function_exists('hb_animated_string_shortcode') ) { 
 
    function hb_animated_string_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'id'       => '',
             'class'    => ''
             
        ), $atts));

        $id = intval($id);

        $uniqid = uniqid();

        $classes = array();

        $classes[] = 'hb-slider hb-animated-string';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $output  = '<div id="hb-animated-string-'.$uniqid.'" class="'.esc_attr($classes).'">';

            $output .= hb_generate_animate_string_content( $id, $uniqid );

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_animated_string', 'hb_animated_string_shortcode');
}


function hb_generate_animate_string_content( $id = 0, $uniqid = 0 ){

    $content = $before = $after = '';

    $slider = get_post( $id );

    if ( $id && $slider && 'animated_string' == $slider->post_type ):

        $strings = get_post_meta( $id, 'strings', true );

        if ( $strings && is_array($strings) && !empty($strings) ):

            $content  = '<h1 class="cd-headline huge-text '.esc_attr(get_post_meta($id, 'animate_style', true)).'">';

                $content .= '<span class="cd-words-wrapper">';

                $count = 0;
                foreach ($strings as $string): 

                    if (empty($string['title'])) {
                        continue;
                    }

                    $count++;

                    $content .= (1==$count) ? '<b class="is-visible">' : '<b>';
                        $content .= strip_tags($string['title']);
                    $content .= '</b>';

                endforeach;

                $content .= '</span>';

            $content .= '</h1>';

        endif;

        $subtext = get_post_meta($id, 'subtext', true);

        if ( $subtext ){

            $content .= '<div class="hb-animated-string-subtext clearfix">';
                $content .= apply_filters('the_content', $subtext );
            $content .= '</div>';
        }

        $btn_link  = get_post_meta($id, 'btn_link', true);

        if ( $btn_link ){

            $btn_label = get_post_meta($id, 'btn_label', true);

            if ( ! $btn_label ) {
                $btn_label = 'Find out more';
            }

            $content .= '<a href="'.esc_attr($btn_link).'" class="btn btn-default"><span>'.$btn_label.'</span></a>';
            
        }

        if ( has_post_thumbnail( $id ) ):

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full');

            $before  = '<div class="hb-slider-bg hb-have-bg" style="background-image:url('. $thumb[0] .')"></div>';

        else :

            $before  = '<div class="hb-slider-bg hb-default"></div>';

        endif;

        $video = get_post_meta($id, 'video', true);

        if ( $video ):

            $video_args = array(
                'blur'          => intval(get_post_meta( $id, 'video_blur', true)),
                'grayscale'     => intval(get_post_meta( $id, 'video_grayscale', true)),
                'brightness'    => intval(get_post_meta( $id, 'video_brightness', true)),
                'contrast'      => intval(get_post_meta( $id, 'video_contrast', true)),
                'opacity'       => intval(get_post_meta( $id, 'video_opacity', true)),
                'vol'           => intval(get_post_meta( $id, 'page_banner_video_vol', true )),
                'mute_btn'      => 'on' == get_post_meta( $id, 'page_banner_video_mute_btn', true ) ? 1 : 0,
                'start'         => intval(get_post_meta( $id, 'video_start', true)),
                'stop'          => intval(get_post_meta( $id, 'video_stop', true)),
            );

            $before .= hb_get_background_video($video, $video_args);

        endif;

        if ( 'on' == get_post_meta($id, 'overlay', true) ):

            $before .= '<div class="layer-overlay"></div>';
            $before .= '<style type="text/css">';

                $overlay = array();
                $layer   = array(
                    'overlay_opacity'           => get_post_meta($id, 'overlay_opacity',        true),
                    'color_overlay'             => get_post_meta($id, 'color_overlay',          true),
                    'pattern_overlay'           => get_post_meta($id, 'pattern_overlay',        true),
                    'overlay_fixed'             => get_post_meta($id, 'overlay_fixed',          true),
                    'gradient_overlay_start'    => get_post_meta($id, 'gradient_overlay_start', true),
                    'gradient_overlay_end'      => get_post_meta($id, 'gradient_overlay_end',   true),
                );

                $overlay['opacity'] = $layer['overlay_opacity'];

                if ( $layer['color_overlay'] ){

                    $overlay['background-color'] = $layer['color_overlay'];
                }

                if ( $layer['pattern_overlay'] && $layer['pattern_overlay'] != 'gradient' ){

                    $overlay['background-image'] = HB_THEME_URL . "/img/{$layer['pattern_overlay']}.png";
                }

                if ( isset($layer['overlay_fixed']) && $layer['overlay_fixed'] == 'on'){

                    $overlay['background-attachment'] = 'fixed';
                }

                if ( $layer['pattern_overlay'] 
                    && $layer['pattern_overlay'] == 'gradient' 
                    && $layer['gradient_overlay_start'] 
                    && $layer['gradient_overlay_end'] ){

                    if ( isset($overlay['background-color'])) { unset($overlay['background-color']); }
                    if ( isset($overlay['background-attachment'])) { unset($overlay['background-attachment']); }
                    
                    $overlay['gradient'] = array(
                        'start' => $layer['gradient_overlay_start'],
                        'end'   => $layer['gradient_overlay_end']
                    );
                }
                $before .= '#hb-animated-string-'.$uniqid.' .layer-overlay {';

                foreach ( $overlay as $module => $style ):

                        if ( $style ) {

                            if ( 'gradient' != $module ) {

                                if ( 'background-image' == $module ) {
                                    $before .= "background-image: url({$style});";
                                } else {
                                    $before .= "{$module}: {$style};";
                                }

                            } else {

                                $before .= "background: {$style['start']};".
                                        "background: -moz-linear-gradient(-45deg,  {$style['start']} 0%, {$style['end']} 100%);".
                                        "background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,{$style['start']}), color-stop(100%,{$style['end']}));".
                                        "background: -webkit-linear-gradient(-45deg,  {$style['start']} 0%,{$style['end']} 100%);".
                                        "background: -o-linear-gradient(-45deg,  {$style['start']} 0%,{$style['end']} 100%);".
                                        "background: -ms-linear-gradient(-45deg,  {$style['start']} 0%,{$style['end']} 100%);".
                                        "background: linear-gradient(135deg,  {$style['start']} 0%,{$style['end']} 100%);".
                                        "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$style['start']}', endColorstr='{$style['end']}',GradientType=1 );";
                            }
                        }

                endforeach;
                $before .= '}';
            $before .= '</style>';

        endif;

    else:

        $before  = '<div class="hb-slider-bg hb-default"></div>';

        $content = current_user_can('edit_theme_options') ?

                    "<p class='hb-error'>".
                    __('No Animated String Found! Please Check Shortcode ID or', 'glaze').
                    "<br/><a href='". get_admin_url()."post-new.php?post_type=animated_string'>".__('Create A New One!', 'glaze')."</a>".
                    "</p>"

        :

                    "<p class='hb-error'>". 
                    __('Monkeys are working on this content hardly ;)', 'glaze'). 
                    "</p>"
        ;

    endif;

    $before .= '<div class="hb-slider-content">';
        $before .= '<div class="vertical-align">';
            $before .= '<div class="centered-box">';

            $after .= '</div>';
        $after .= '</div>';
    $after .= '</div>';

    return $before . $content . $after;
}

// BANNER SHORTCODE
if( !function_exists('hb_banner_shortcode') ) { 
 
    function hb_banner_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'text_align'       => 'center',
             'vertical_align'   => 'middle',
             'scheme'           => '',
             'background'       => '',
             'background_color' => '',
             'link'             => '',
             'height'           => '',
             'mp4'              => '',
             'ogg'              => '',
             'webm'             => '',
             'video_ratio'      => '',
             'class'            => '',

        ), $atts));

        $TEXTALIGN      = array('left', 'center', 'right');
        $VERTICALALIGN  = array('top', 'middle', 'bottom');

        $text_align     = in_array($text_align, $TEXTALIGN) ? $text_align : 'center';
        $vertical_align = in_array($vertical_align, $VERTICALALIGN) ? $vertical_align : 'middle';

        $scheme = 'light' == $scheme ? 'light' : 'dark';

        $height = ( !empty($height) )? sprintf(' style="min-height:%s;"', esc_attr($height)) : '';

        $styles = array();

        if ( !empty($background) ){
            $styles[] = 'background-image: url(' . $background . ')';
        }

        if ( !empty($background_color) ){
            $styles[] = 'background-color: ' . $background_color;
        }

        $styles = empty($styles) ? '' : ' style="' . esc_attr(implode(';', $styles)) . '"';

        $classes = array();

        $classes[] = 'hb-banner';

        $classes[] = 'hb-layer-' . $scheme;

        $classes[] = 'text-' . $text_align;

        $classes[] = 'vertical-' . $vertical_align;

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'"'.$styles.'>';

            $output .= ( $mp4 || $ogg || $webm ) ?
                    hb_get_selfhost_video( array(
                        'mp4'   => $mp4,
                        'ogg'   => $ogg,
                        'webm'  => $webm
                    ), $video_ratio )
            : '';

            remove_filter( 'the_content', 'prepend_attachment' );

            if ( !empty($link) ){

                $output .= '<a class="hb-banner-link" href="'.esc_attr($link).'">'; 
                    $output .= '<div class="hb-banner-base"'.$height.'>';
                        $output .= '<div class="hb-banner-inner">';
                            $output .= apply_filters('the_content', strip_tags($content, '<p><div><i><b><u><img><h1><h2><h3><h4><h5><h6><strong><em><span><ul><li><ol>'));
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</a>';

            } else {

                $output .= '<div class="hb-banner-base"'.$height.'>';
                    $output .= '<div class="hb-banner-inner">';
                        $output .= apply_filters('the_content', $content);
                    $output .= '</div>';
                $output .= '</div>';
            }

        $output .= '</div>';

        add_filter( 'the_content', 'prepend_attachment' );

        return $output;
    }

    add_shortcode('hb_banner', 'hb_banner_shortcode');
}

// BLOCKQUOTE SHORTCODE
if( !function_exists('hb_blockquote_shortcode') ) { 
 
    function hb_blockquote_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'reverse'  => '',
             'frame'    => '',
             'class'    => '',
             'author'   => '',
             'cite'     => '',
             
        ), $atts));

        $classes = 'fancy-font ';

        $reverse = strtolower(trim($reverse));

        $activated  = hb_shortcode_active_option_values();

        if ( $frame ){
            $classes .= $frame . '-frame ';
        }

        if ( in_array($reverse, $activated) ){
            $classes .= 'blockquote-reverse ';
        }

        if ( $class ){
            $classes .= $class;
        }

        if ( '' != $classes ){
            $classes = 'class="'. esc_attr(trim($classes)) .'"';
        }

        $output  = '<blockquote '.$classes.'>';
        $output .= apply_filters('the_content', $content);

        if ( $author || $cite ){

            $output .= '<footer>';

                if ( $author ){

                    $output .= $author .' ';
                }
                if ( $cite ){

                    $output .= '<cite title="'.esc_attr($cite).'">'.$cite.'</cite>';
                }
                
            $output .= '</footer>';
        }
        $output .= '</blockquote>';

        return $output;
    }

    add_shortcode('hb_blockquote', 'hb_blockquote_shortcode');
}

// BUTTON SHORTCODE
if( !function_exists('hb_button_shortcode') ) { 
 
    function hb_button_shortcode($atts, $content = null) {
            
        extract(shortcode_atts(array(
             
             'class'    => '',
             'href'     => '#',
             'target'   => '_self',
             'size'     => 'normal',
             'type'     => 'default',
             'block'    => '0',
             'active'   => '0',
             'disabled' => '0',
             'icon'     => '',

        ), $atts));

        $target = trim(strtolower($target));
        $size = trim(strtolower($size));
        $type = trim(strtolower($type));
        $block = trim(strtolower($block));
        $active = trim(strtolower($active));
        $disabled = trim(strtolower($disabled));
        $icon = trim(strtolower($icon));

        $icon = ( $icon ) ? '<i class="'.esc_attr($icon).'"></i>&nbsp;&nbsp;' : '';

        $classes = array();

        $activated  = hb_shortcode_active_option_values();

        $default_sizes = array(
            'large'         => 'btn-lg',
            'lg'            => 'btn-lg',
            'small'         => 'btn-sm',
            'sm'            => 'btn-sm',
            'extrasmall'    => 'btn-xs',
            'extra_small'   => 'btn-xs',
            'xs'            => 'btn-xs',
        );

        if ( isset($default_sizes[$size]) ){

            $classes[] = $default_sizes[$size];
        }

        if ( $type ){

            $classes[] = 'btn-'.$type;
        }

        if ( in_array($block, $activated) ){

            $classes[] = 'btn-block';
        }

        if ( in_array($active, $activated) ){

            $classes[] = 'active';
        }

        if ( in_array($disabled, $activated) ){

            $classes[] = 'disabled';
        }

        if ( $class ){

            $classes[] = $class;
        }

        if ( $icon ){

            $classes[] = 'have-icon';
        }

        $classes = implode(' ', $classes);

        $btn = '<a class="btn '.esc_attr($classes).'" href="'.esc_attr($href).'" target="'.esc_attr($target).'"><span>'. $icon . wp_strip_all_tags($content) .'</span></a>';

        if ( in_array($block, $activated) ){

            $btn = '<div class="hb-block-btn"><div class="hb-block-btn-wrapp">' . $btn . '</div></div>';
        }

        return $btn;
    }

    add_shortcode('hb_button', 'hb_button_shortcode');
}

// CALLOUT SHORTCODE
if( !function_exists('hb_callout_shortcode') ) { 
 
    function hb_callout_shortcode($atts, $content = null) {
            
        extract(shortcode_atts(array(
             
             'title'            => '',
             'subtitle'         => '',
             'image'            => '',
             'btn_label'        => '',
             'link'             => '',
             'class'            => '',

        ), $atts));

        $classes = array('hb-callout hb-animate-solo');

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'" data-animation="calloutIn">';

            $output .= '<div class="hb-callout-header">';
                if ( $title ){
                    $output .= '<h4 class="hb-callout-title hb-animate-solo">'. $title .'</h4>';
                }
                if ( $subtitle ){
                    $output .= '<h6 class="hb-callout-subtitle hb-animate-solo">'. $subtitle .'</h6>';
                }
            $output .= '</div>';
            $output .= '<div class="hb-callout-wrapp">';
                $image = ( $image )? ' style="background-image:url('.esc_url($image).');"' : '';
                $output .= '<div class="hb-callout-img hb-animate-solo" data-animation="fadeInLeft"'. $image .'></div>';
                $output .= '<div class="hb-callout-content">';
                    $output .= '<div class="hb-callout-entry clearfix">'. do_shortcode($content) .'</div>';
                    if ( $link && $btn_label ){
                        $output .= '<div class="hb-block-btn hb-animate-solo">';
                            $output .= '<div class="hb-block-btn-wrapp">';
                                $output .= '<a class="service-link btn btn-block btn-sm btn-default" href="'.esc_url($link).'"><span>'.wp_strip_all_tags($btn_label).'</span></a>';
                            $output .= '</div>';
                        $output .= '</div>';
                    }
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_callout', 'hb_callout_shortcode');
}

// CLIENT GROUP SHORTCODE
if( !function_exists('hb_client_group_shortcode') ) { 
 
    function hb_client_group_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'class'    => ''   
             
        ), $atts));

        return '<div class="hb-client hb-animate-group clearfix '.esc_attr($class).'">'.do_shortcode($content).'</div>';
    }

    add_shortcode('hb_client_group', 'hb_client_group_shortcode');
}


if( !function_exists('hb_client_shortcode') ) { 
 
    function hb_client_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'name'     => '',
             'url'      => '',
             'logo'     => '',

        ), $atts));

        if ( empty($logo) ) {
            return;
        }

        $output  = '<div class="item hb-animate" data-animation="fadeIn">';
            $img = '<img src="'.esc_url($logo).'" alt="'.esc_attr($name).'">';
            $output .= (!empty($url)) ? '<a href="'.esc_url($url).'" target="_blank">'.$img.'</a>' : $img ;
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_client', 'hb_client_shortcode');
}

// COUNTUP SHORTCODE
if( !function_exists('hb_countup_shortcode') ) { 
 
    function hb_countup_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'icon'             => 'fa fa-circle', // fontawesome, ionicons, bootstrap...
             'size'             => '', // small, medium, larg
             'effect'           => '', // 1,2,3,4,5,6,7,8,9
             'shape'            => '', // round, square
             'target'           => '',
             'class'            => ''   
             
        ), $atts));

        if ( empty($target) ) return;

        $classes = array();

        $classes[] = 'hb-countup-box hb-icon-box hb-icon-type-vertical text-center';

        if ( $size ){

            $classes[] = 'hb-icon-size-' . $size;
        }

        if ( $effect && $effect != 'none' ) {

            $classes[] = 'hb-icon-effect-' . intval($effect) . ' hb-icon-effect-' . $effect;
        }

        if ( $shape ){

            $classes[] = 'hb-icon-shape-' . $shape;
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode( ' ', $classes );

        $output  = '<div class="'.esc_attr($classes).' clearfix">';

            if ( trim($icon) ){ 

                $icon_align = 'text-center';

                $output  .= '<div class="hb-icon-item '.esc_attr($icon_align).'">';
                    $output .= '<i class="hb-icon '.esc_attr($icon).'"></i>';
                $output .= '</div>';
            }

            $output .= '<span class="hb-counter">'.esc_html($target).'</span>';

            if ( trim($content) ){

                $output  .= '<div class="hb-countup-content">';
                    $output .= do_shortcode($content);
                $output .= '</div>';
            }

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_countup', 'hb_countup_shortcode');
}

// DESCRIPTION SHORTCODE
if( !function_exists('hb_description_shortcode') ) { 
 
    function hb_description_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             'style'    => 'fancy-font',
             'align'    => 'text-center',
             'class'    => '',
             
        ), $atts));

        $classes = array('hb-animate-solo');

        if ( $style ){

            $classes[] = $style;
        }

        if ( $align ){

            $classes[] = $align;
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        return '<div class="'.esc_attr($classes).'">'.$content.'</div>';
    }

    add_shortcode('hb_description', 'hb_description_shortcode');
}

// DROPCAP SHORTCODE
if( !function_exists('hb_dropcap_shortcode') ) { 

    function hb_dropcap_shortcode($atts, $content = null) {
        
        extract(shortcode_atts(array(
             'class'    => '',
             'size'     => '',
             'style'    => 'one',
        ), $atts));

        $classes = array();

        if ( ! $style ){

            $style = 'one';
        }

        $classes[] = 'hb-dropcap hb-dropcap-'. $style;

        if ( $size ){

            $classes[] = 'hb-dropcap-'. $size;
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);
        
        return '<span class="'.esc_attr($classes).'">'.do_shortcode($content).'</span>';
    }
    
    add_shortcode('hb_dropcap', 'hb_dropcap_shortcode');
}

// FANCY LIST SHORTCODE
if( !function_exists('hb_fancy_list_shortcode') ) { 
 
    function hb_fancy_list_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'class'    => ''   
             
        ), $atts));

        return '<ul class="icon-ul '.esc_attr($class).'">'.do_shortcode($content).'</ul>';
    }

    add_shortcode('hb_fancy_list', 'hb_fancy_list_shortcode');
}


if( !function_exists('hb_li_shortcode') ) { 
 
    function hb_li_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'class' => '',
             'icon'  => '',

        ), $atts));

        return '<li class="'.esc_attr($class).'"><i class="icon-li '.esc_attr($icon).'"></i>'.do_shortcode($content).'</li>';
    }

    add_shortcode('hb_li', 'hb_li_shortcode');
}

// HEADLINE SHORTCODE
if( !function_exists('hb_headline_shortcode') ) { 
 
    function hb_headline_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             'tag'      => 'h2',
             'style'    => 'underline-center',
             'class'    => '',
             'skin'     => 'dark',
             
        ), $atts));

        $tag = trim(strtolower($tag));

        $allowed_tags = array('h1','h2','h3','h4','h5','h6');

        if ( empty($tag) || ! in_array($tag, $allowed_tags)){

            $tag = 'h2';
        }

        switch ( $style ) {
            case 'span':
                $content = hb_render_span_title_html($content);
                break;
            
            case 'justify':
                $content = hb_txt_justify($content);
                break;

            default:
                $content = do_shortcode($content);
                break;
        }

        $classes = array('hb-animate-solo');

        if ( $skin ){

            $classes[] = 'headline-'. $skin;
        }

        if ( $style ){

            $classes[] = 'headline-'. $style;
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $output  = '<div class="hb-headline-wrapper clearfix">';

            $output .=  '<'.esc_attr($tag).' class="'.esc_attr($classes).'"><span class="headline-'.esc_attr($style).'-entry">' .$content. '</span></'.esc_attr($tag).'>';

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_headline', 'hb_headline_shortcode');
}

// HR SHORTCODE
if( !function_exists('hb_hr_shortcode') ) { 
 
    function hb_hr_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'style'    => '',
             'class'    => ''
             
        ), $atts));

        $classes = array();

        $classes[] = 'hb-hr';

        if ( $style ){

            $classes[] = 'hb-hr-'. $style;
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        return '<hr class="'.esc_attr($classes).'"/>';
    }

    add_shortcode('hb_hr', 'hb_hr_shortcode');
}

// ICON SHORTCODE
if( !function_exists('hb_icon_shortcode') ) { 
 
    function hb_icon_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'icon'     => '',
             'size'     => '',
             'color'    => '',
             'class'    => ''
             
        ), $atts));

        if ( empty($icon) ) return;

        $def_sizes = array(
            'large'     => 'fa-lg',
            '2xlarge'   => 'fa-2x', 
            '3xlarge'   => 'fa-3x', 
            '4xlarge'   => 'fa-4x', 
            '5xlarge'   => 'fa-5x'
        );

        $size = trim(strtolower($size));

        $classes = array();

        $classes[] = $icon;

        if ( ! empty($size) && isset($def_sizes[$size]) ){

            $classes[] = $def_sizes[$size];
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $style = '';

        if ( ! empty($color) ){

            $style = ' style="color:'.esc_attr($color).' !important"';
        }

        return '<i class="'.esc_attr($classes).'"'.$style.'></i>';
    }

    add_shortcode('hb_icon', 'hb_icon_shortcode');
}

// ICONBOX SHORTCODE
if( !function_exists('hb_icon_box_shortcode') ) { 
 
    function hb_icon_box_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'icon'             => 'fa fa-circle', // fontawesome, ionicons, bootstrap...
             'type'             => '', // horizontal, vertical
             'icon_align'       => '', // left, right, center
             'content_align'    => '', // left, right, center
             'size'             => '', // small, medium, larg
             'effect'           => '', // 1,2,3,4,5,6,7,8,9
             'shape'            => '', // round, square
             'class'            => ''   
             
        ), $atts));

        $classes = array();

        $classes[] = 'hb-icon-box';

        if ( $type ){

            $classes[] = 'hb-icon-type-' . $type;
        }

        if ( $size ){

            $classes[] = 'hb-icon-size-' . $size;
        }

        if ( $effect && $effect != 'none' ) {

            $classes[] = 'hb-icon-effect-' . intval($effect) . ' hb-icon-effect-' . $effect;
        }

        if ( $shape ){

            $classes[] = 'hb-icon-shape-' . $shape;
        }

        if ( $content_align ){

            $classes[] = 'text-' . $content_align;
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode( ' ', $classes );

        $output  = '<div class="'.esc_attr($classes).' clearfix">';

            if ( trim($icon) ){ 

                $icon_align = ( $icon_align ) ? 'text-' . $icon_align : 'text-center';

                $output  .= '<div class="hb-icon-item '.esc_attr($icon_align).'">';
                    $output .= '<i class="hb-icon '.esc_attr($icon).'"></i>';
                $output .= '</div>';
            }

            if ( trim($content) ){

                $output  .= '<div class="hb-icon-content">';
                    $output .= do_shortcode($content);
                $output .= '</div>';
            }

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_icon_box', 'hb_icon_box_shortcode');
}

// INSTAGRAM FEED SHORTCODE
if( !function_exists('hb_instagram_feed_shortcode') ) { 
 
    function hb_instagram_feed_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'count'    => 18,
             'type'     => 'grid',
             'gutter'   => 'yes',
             'dots'     => 'yes',
             'class'    => ''
             
        ), $atts));

        if ( ! function_exists('hb_get_instagram_feed') ){

            return;
        }

        $classes = array();
        $activated  = hb_shortcode_active_option_values();

        $classes[] = 'hb-instagram-feed hb-animate-group';

        if ( !in_array($gutter, $activated) ){

            $classes[] = 'hb-instagram-nogap';
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes[] = ('grid'==$type)? 'hb-instagram-feed-grid' : 'hb-instagram-feed-carousel';

        $classes = implode(' ', $classes);

        $images = hb_get_instagram_feed();

        if ( !is_array($images) || empty($images) ) {
            return;
        }

        if ( 'carousel' == $type ){

            $dots = in_array( trim(strtolower($dots)), $activated)? 'on' : 'off' ;
            $margin = in_array( trim(strtolower($gutter)), $activated)? 'on' : 'off' ;

            $output  = '<div class="'.esc_attr($classes).'">';
                $output .= '<div class="hb-carousel hb-instagram-nogap" data-dots="'.$dots.'" data-margin="'.$margin.'">';

                    $counter = 0;
                    foreach ($images as $image) { $counter++;

                        if ( $counter > $count ) break;

                        $alt = isset($image->caption->text) ? $image->caption->text : '';
                        $output .= '<div class="hb-carousel-item hb-animate" data-animation="fadeInRight">';
                            $output .= '<div class="hb-instagram-item">';
                                $output .= '<img src="'.esc_url($image->images->standard_resolution->url).'" alt="'.esc_attr($alt).'" class="hb-animate">';
                            $output .= '</div>';
                        $output .= '</div>';
                    }
                $output .= '</div>';
            $output .= '</div>';

        } else {

            $output  = '<div class="'.esc_attr($classes).'">';
                $output .= '<div class="row">';

                    $counter = 0;
                    foreach ($images as $image) { $counter++;

                        if ( $counter > $count ) break;

                        $alt = isset($image->caption->text) ? $image->caption->text : '';
                        $output .= '<div class="col-sm-4">';
                            $output .= '<div class="hb-instagram-item">';
                                $output .= '<a href="'.esc_url($image->images->standard_resolution->url).'">';
                                    $output .= '<img src="'.esc_url($image->images->standard_resolution->url).'" alt="'.esc_attr($alt).'" class="hb-animate">';
                                $output .= '</a>';
                            $output .= '</div>';
                        $output .= '</div>';
                    }
                $output .= '</div>';
            $output .= '</div>';
        }

        return $output;
    }

    add_shortcode('hb_instagram_feed', 'hb_instagram_feed_shortcode');
}

// MAP SHORTCODE
if( !function_exists('hb_map_shortcode') ) { 
 
    function hb_map_shortcode($atts, $content = null) {

        extract(shortcode_atts(array(
             
             'class'        => '',
             'lat'          => '',
             'lng'          => '',
             'zoom'         => '8',
             'ratio'        => '0.5',
             
        ), $atts));

        if ( empty($lat) || empty($lng) ) {
            return;
        }

        $ratio = intval($ratio * 100);
        if ( !$ratio ) {
            $ratio = 50;
        }

        $zoom = intval($zoom);
        if ( !$zoom ) {
            $zoom = 8;
        }

        if ( ! wp_script_is( 'hb-googlemap', 'enqueued' ) ){
            wp_enqueue_script( 'hb-googlemap' );
        }

        $classes = array();

        $classes[] = 'hb-map';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $content = trim($content);

        $output  = '<div class="'.esc_attr($classes).'" data-lat="'.esc_attr($lat).'" data-lng="'.esc_attr($lng).'" data-zoom="'.$zoom.'" style="padding-top:'.$ratio.'%">';
            $output .= '<div id="map-'.uniqid().'" class="hb-map-content"></div>';
            if ( $content ){
                $output .= '<div class="hb-map-info-window">'.$content.'</div>';
            }
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_map', 'hb_map_shortcode');
}

// PANEL SHORTCODE
if( !function_exists('hb_panel_shortcode') ) { 
 
    function hb_panel_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(

             'align'                    => '',
             'title'                    => '',
             'subtitle'                 => '',
             'animation'                => '',
             'panel_padding'            => '',
             'panel_background_image'   => '',
             'panel_background_color'   => '',
             'sidebox_background_image' => '',
             'class'                    => ''   
             
        ), $atts));

        $panel_animate = $sidebox_class = '';

        $panel_style = $box_style = $classes = array();

        $classes[] = 'hb-panel-wrapper hb-animate-group clearfix';

        $classes[] = ( 'right' == $align )? 'hb-panel-right' : 'hb-panel-left';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $panel_class = ( 'off' == $panel_padding )? 'hb-panel-nopadding' : 'hb-panel-padding';

        // panel style
        if ( $animation && 'none' != $animation ){

            $panel_animate = 'data-animation="'.esc_attr($animation).'"';
            $panel_class .= ' hb-animate';
        }

        // panel style
        if ( $panel_background_image ){

            $panel_style[] = 'background-image:url('. $panel_background_image .')';
        }

        if ( $panel_background_color ){

            $panel_style[] = 'background-color:'. $panel_background_color;
        }

        // sidebox style
        if ( $sidebox_background_image ){

            $box_style[] = 'background-image:url('. $sidebox_background_image .')';
        }

        $panel_style    = ( !empty($panel_style) )? ' style="'. esc_attr(implode(';', $panel_style)) .'"' : '';
        $box_style      = ( !empty($box_style) )? ' style="'. esc_attr(implode(';', $box_style)) .'"' : '';

        // parallax
        if ( 'right' == $align ){

            $sidebox_parallax = 'data-bottom-top="transform:translate3d(0,80px,0)" data-top-bottom="transform:translate3d(0,-80px,0)"';

        } else {

            $sidebox_parallax = 'data-bottom-top="transform:translate3d(0,-80px,0)" data-top-bottom="transform:translate3d(0,80px,0)"';
        }

        $output  = '<div class="'. esc_attr($classes).'">';

            $output .= '<div class="hb-panel '.$panel_class.' clearfix" '.$panel_style.$panel_animate.'>';
                $output .= apply_filters('the_content', $content);
            $output .= '</div>';    

            $output .= '<div class="hb-sidebox" '.$sidebox_parallax.'>';

                    $output .= '<div class="hb-sidebar-box hb-animate-solo"'.$box_style.'></div>';
                    $output .= '<div class="hb-sidebar-inner">';
                        if ( $title ){
                            $output .= '<h4 class="hb-panel-title hb-animate-solo">'. $title .'</h4>';
                        }
                        if ( $subtitle ){
                            $output .= '<div class="hb-sidebox-subtitle h6 hb-animate-solo">'. $subtitle .'</div>';
                        }
                    $output .= '</div>';

            $output .= '</div>';

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_panel', 'hb_panel_shortcode');
}

// POST CAROUSEL SHORTCODE
if( !function_exists('hb_post_carousel_shortcode') ) { 
 
    function hb_post_carousel_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'cat'          => '',
             'count'        => '6',
             'class'        => '',
             'dots'         => 'on',
             'margin'       => 'on',
             'stage'        => 'off',
             
        ), $atts));

        $count = ( $count == '-1' ) ? -1 : intval($count);

        $args = array(

            'post_type'             => 'post',
            'paged'                 => 1,
            'ignore_sticky_posts'   => true,
        );

        if ( $count || -1 == $count ) {

            $args['posts_per_page'] = $count;
        }

        if ( $cat ) {

            $args['category__in'] = explode(',', $cat);
        }

        query_posts( $args );

        if ( ! have_posts() ) {

            wp_reset_query();

                if ( current_user_can('edit_theme_options') ){

                    $output = "<p class='hb-error'>". 
                    __('No Post Found!', 'glaze').
                    "<br/><a href='".get_admin_url()."post-new.php'>".__('Create One!', 'glaze')."</a>".
                    "</p>";

                } else {

                    $output = "<p class='hb-error'>".
                    __('Monkeys are working on this content hardly ;)', 'glaze'). 
                    "</p>";
                }

            return $output;
        }

        $activated  = hb_shortcode_active_option_values();

        $classes = $properties = array();

        $classes[] = 'hb-carousel hb-animate-group';

        if ( in_array( trim(strtolower($dots)), $activated) ){
            $properties[]   = 'data-dots="on"';
            $classes[]      = 'has-dots';
        } else {
            $properties[]   = 'data-dots="off"';
            $classes[]      = 'no-dots';
        }

        if ( in_array( trim(strtolower($margin)), $activated) ){
            $properties[]   = 'data-margin="on"';
            $classes[]      = 'has-margin';
        } else {
            $properties[]   = 'data-margin="off"';
            $classes[]      = 'no-margin';
        }

        if ( in_array( trim(strtolower($stage)), $activated) ){
            $properties[]   = 'data-items="1" data-stage="270"';
            $classes[]      = 'stage-padding';
        }

        $properties[]       = 'data-center="on"';

        if ( $class ){
            $classes[] = $class;
        }

        $properties = implode(' ', $properties);

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'" '.$properties.'>';

            while ( have_posts() ) : the_post();

                $output .= '<div class="hb-post-carousel hb-carousel-item hb-animate" data-animation="fadeInRight">';

                    if ( has_post_thumbnail() ){

                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');

                        $output .= '<div class="box-img" style="background-image:url('. $thumb[0] .')"></div>';
                    }

                    $output .= '<h2 class="hb-post-carousel-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h2>';
                    $output .= '<span class="entry-date">'.get_the_date().'</span>';

                $output .= '</div>';

            endwhile; wp_reset_query();

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_post_carousel', 'hb_post_carousel_shortcode');
}

// POSTS SHORTCODE
if( !function_exists('hb_posts_shortcode') ) { 
 
    function hb_posts_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'cat'          => '',
             'count'        => '6',
             'class'        => '',
             'more_posts'   => '',
             'more_posts_link' => '',
             
        ), $atts));

        $count = ( $count == '-1' ) ? -1 : intval($count);

        $args = array(

            'post_type'             => 'post',
            'paged'                 => 1,
            'ignore_sticky_posts'   => true,
        );

        if ( $count || -1 == $count ) 

            $args['posts_per_page'] = $count;

        if ( $cat ) 

            $args['category__in'] = explode(',', $cat);

        query_posts( $args );

        if ( ! have_posts() ) {

            wp_reset_query();

                if ( current_user_can('edit_theme_options') )

                    $output = "<p class='hb-error'>". 
                    __('No Post Found!', 'glaze').
                    "<br/><a href='".get_admin_url()."post-new.php'>".__('Create One!', 'glaze')."</a>".
                    "</p>";

                else

                    $output = "<p class='hb-error'>".
                    __('Monkeys are working on this content hardly ;)', 'glaze'). 
                    "</p>";

            return $output;
        }

        $classes = array();

        $classes[] = 'hb-post-list-wrapper hb-animate-group';

        if ( $class )

        $classes[] = $class;

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'">';

            while ( have_posts() ) : the_post();

                $output .= '<div class="hb-post-list hb-animate" data-animation="fadeIn">';

                    if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) )
                        $output .= '<span class="cat-links">'. get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'glaze' ) ) . '</span> / ';

                    $output .= '<span class="entry-date">'.get_the_date().'</span>';

                    $output .= '<h4 class="hb-post-list-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h4>';

                    $output .= '<div class="entry-list-excerpt clearfix hidden-xs">'.get_the_excerpt().'</div>';

                $output .= '</div>';

            endwhile; wp_reset_query();

            if ( ! empty($more_posts) ):

                $more_posts_link = ( $more_posts_link )? $more_posts_link : get_home_url();

                $output .= '<a href="'.esc_url($more_posts_link).'" class="btn btn-primary hb-animate" data-animation="fadeIn"><span>'.$more_posts.'</span></a>';

            endif;

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_posts', 'hb_posts_shortcode');
}

// PRICING SHORTCODE
if( !function_exists('hb_pricing_shortcode') ) { 
 
    function hb_pricing_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'id'       => '',
             'name'     => '',
             'class'    => ''
             
        ), $atts));

        if ( !$id && !$name ) return;

        if ( $name && !$id ):
            global $wpdb;
            $name = esc_sql($name);
            $post_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $name . "' AND post_type = 'pricing_table'" );
        else:
            $post_id = $id;
        endif;

        $getpost = get_post($post_id);

        if ( !$getpost ) return;

        $items = get_post_meta($post_id, 'slides', true);

        if ( empty($items) || !is_array($items) ) return;

        $defaults = array(

            'columns'   => 4,
            'type'      => 1,
            'animation' => 'fadeIn',
        );

        $args = array(
            'columns'   => get_post_meta($post_id, 'columns', true),
            'type'      => get_post_meta($post_id, 'type', true),
            'animation' => get_post_meta($post_id, 'animation', true)
        );

        foreach ($args as $key => $value)

            if ( empty($value) ) unset($args[$key]);    

        extract( wp_parse_args( $args, $defaults ) );

        $columns_classes = array(
            3 => 'col-md-4',
            4 => 'col-sm-6 col-md-3',
            6 => 'col-sm-6 col-md-4 col-lg-2',
        );

        $sizes = array(
            3 => 'hb-pricing-large',
            4 => '',
            6 => 'hb-pricing-small',
        );  

        $classes = array();

        $classes[] = 'row hb-animate-group hb-pricing-table';

        if ( $class )

            $classes[] = $class;

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'">';

            foreach ($items as $item) {

                $output .= '<div class="'.$columns_classes[$columns].' hb-animate" data-animation="'.$animation.'">';
                    $popular = ('on' == $item['featured']) ? 'hb-popular' : '';
                    $output .= '<div class="hb-pricing '.$sizes[$columns].' hb-pricing-'.$type.' '.$popular.'" >';

                        if ( 3 == $type && !empty($item['img']) ){

                            $img = wp_get_attachment_image_src($item['img'], full);

                            if ( $img )
                            $output .= '<img class="hb-pricing-img" src="'.$img[0].'" alt="'.esc_attr($item['title']).'">';
                        }

                        $output .= ('on' == $item['featured']) ? '<div class="hb-featured">'.$item['label'].'</div>': '';
                        $output .= '<h3 class="hb-pricing-title">'.$item['title'].'</h3>';
                        $output .= '<span class="hb-pricing-amount">'.$item['price'].'</span>';
                        if (!empty($item['subtitle']))
                            $output .= '<p class="hb-pricing-plan">'.$item['subtitle'].'</p>';
                        if (!empty($item['desc'])){
                            $output .= '<ul>';
                                $data = str_replace(array("\r", "\n"), '%%', $item['desc']);
                                $data = array_filter(explode('%%', $data));
                                foreach ($data as $i) {
                                    $output .= '<li>'.$i.'</li>';
                                }
                            $output .= '</ul>';
                        }
                        if (!empty($item['btn_link']))
                        $output .= '<a href="'.esc_attr($item['btn_link']).'" class="hb-pricing-btn">'.$item['btn_label'].'</a>';
                    $output .= '</div>';
                $output .= '</div>';
            }

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_pricing', 'hb_pricing_shortcode');
}

// PROGRESS SHORTCODE
if( !function_exists('hb_progress_shortcode') ) { 
 
    function hb_progress_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'goal'     => '100',
             'label'    => 'Skill',
             'class'    => ''
             
        ), $atts));

        $classes = array();

        $classes[] = 'hb-progress-wrapper';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $goal = esc_attr(intval($goal));

        $output  = '<div class="'.esc_attr($classes).'">';
            if (!empty($label)){
                $output .= '<label class="progress__bar_label">'.$label.'</label>';
            }
            $output .= '<div class="hb-asprogress progress" role="progressbar" data-goal="'.$goal.'">';
                $output .= '<div class="progress__bar" style="width:'.$goal.'%"><span class="progress__label">'.$goal.'%</span></div>';
            $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_progress', 'hb_progress_shortcode');
}

// SERVICE BIG TITLE SHORTCODE
if( !function_exists('hb_service_big_title_shortcode') ) { 
 
    function hb_service_big_title_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'title'    => '',
             'link'     => '',
             'class'    => '',  
             
        ), $atts));

        $link = trim($link);

        $output  = '<div class="hb-service hb-serive-big-title '.esc_attr($class).'">';
            $output .= '<h4 class="service-big-title headline-underline">'.$title.'</h4>';
            $output .= '<div class="service-content">';
                $output .= do_shortcode($content);
            $output .= '</div>';

            if ( $link ){
                $output .= '<a class="service-link" href="'.esc_attr($link).'"><i class="ion-ios-arrow-thin-right"></i></a>';
            }

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_service_big_title', 'hb_service_big_title_shortcode');
}

// SERVICE BOX ICON SHORTCODE
if( !function_exists('hb_service_box_icon_shortcode') ) { 
 
    function hb_service_box_icon_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'title'        => '',
             'subtitle'     => '',
             'link'         => '',
             'icon'         => '',
             'box_shadow'   => '',
             'class'        => '',

        ), $atts));

        $classes = array();

        $link = trim($link);

        $activated  = hb_shortcode_active_option_values();

        if (in_array(trim($box_shadow), $activated))

            $classes[] = 'hb-box-shadow';

        if ( $class )

            $classes[] = $class;

        $classes = implode(' ', $classes);

        $output  = '<div class="hb-service hb-serive-box-icon '.$classes.'">';

            $output .= '<div class="hb-serive-b-icon"><i class="'.$icon.'"></i></div>';
            $output .= '<h2 class="headline-underline-center">'.$title.'</h2>';
            if ( $subtitle )
                $output .= '<small class="hb-service-subtitle">'.$subtitle.'</small>';
            $output .= '<div class="service-content">';
                $output .= do_shortcode($content);
            $output .= '</div>';

            if ( $link )
                $output .= '<a class="service-link" href="'.esc_attr($link).'"><i class="ion-ios-arrow-thin-right"></i></a>';

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_service_box_icon', 'hb_service_box_icon_shortcode');
}

// SERVICE BOX IMAGE SHORTCODE
if( !function_exists('hb_service_box_image_shortcode') ) { 
 
    function hb_service_box_image_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'title'        => '',
             'subtitle'     => '',
             'link'         => '',
             'btn_label'    => '',
             'image'        => '',
             'box_shadow'   => '',
             'class'        => '',

        ), $atts));

        $classes = array('hb-service hb-serive-box-image hb-layer-light');

        $link = trim($link);

        $activated  = hb_shortcode_active_option_values();

        if (in_array(trim($box_shadow), $activated)){

            $classes[] = 'hb-box-shadow';
        }

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'">';

            $output .= '<div class="hb-serive-b-img">';

                if ( $image ){

                    $output .= '<div class="hb-serive-b-img-box" style="background-image:url('.esc_url($image).')" data-bottom-top="transform:translate3d(0,-12em,0)" data-top-bottom="transform:translate3d(0,12em,0)"></div>';
                }

                $output .= '<div class="hb-serive-b-content">';

                    $output .= '<h2 class="headline-underline">'.$title.'</h2>';

                    if ( trim($content) ){
                        $output .= '<div class="service-content">';
                            $output .= do_shortcode($content);
                        $output .= '</div>';
                    }

                $output .= '</div>';

                if ( $subtitle ){
                    $output .= '<small class="h3 hb-service-subtitle">'.wp_strip_all_tags($subtitle).'</small>';
                }

                if ( $link && $btn_label ){
                    $output .= '<div class="hb-block-btn">';
                        $output .= '<div class="hb-block-btn-wrapp">';
                            $output .= '<a class="service-link btn btn-block btn-sm btn-default" href="'.esc_url($link).'"><span>'.wp_strip_all_tags($btn_label).'</span></a>';
                        $output .= '</div>';
                    $output .= '</div>';

                    $output .= '<div class="sbi-lines">';
                        $output .= '<span class="sbi-01"></span>';
                        $output .= '<span class="sbi-02"></span>';
                        $output .= '<span class="sbi-03"></span>';
                    $output .= '</div>';
                }
            $output .= '</div>';

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_service_box_image', 'hb_service_box_image_shortcode');
}

// SERVICE CUSTOM ICON SHORTCODE
if( !function_exists('hb_service_custom_icon_shortcode') ) { 
 
    function hb_service_custom_icon_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'title'        => '',
             'link'         => '',
             'btn_label'    => '',
             'icon'         => '',
             'class'        => '',

        ), $atts));

        $link = trim($link);

        $output  = '<div class="hb-service hb-serive-custom-icon '.$class.'">';

            $style = ($icon)? 'style="background-image:url('.$icon.')"' : 'style="background-color:#f7f7f7;border-radius:50%"';

            $output .= '<div class="hb-serive-c-icon" '.$style.'></div>';
            $output .= '<h4 class="headline-underline-center">'.$title.'</h4>';
            $output .= '<div class="service-content">';
                $output .= do_shortcode($content);
            $output .= '</div>';

            if ( $link && $btn_label ){
                $output .= '<a class="service-link btn btn-default btn-xs" href="'.esc_attr($link).'"><span>'.$btn_label.'</span></a>';
            }

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_service_custom_icon', 'hb_service_custom_icon_shortcode');
}

// SPACE SHORTCODE
if( !function_exists('hb_space_shortcode') ) { 
 
    function hb_space_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'height'   => '',
             
        ), $atts));

        $output  = '<div class="clearfix">';
            $output .= ( $height )? '<div class="hb-space" style="height:'.esc_attr($height).'"></div>' : '<div class="hb-space"></div>';
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_space', 'hb_space_shortcode');
}

// TABPANEL SHORTCODE
if( !function_exists('hb_space_shortcode') ) { 
 
    function hb_space_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'height'   => '',
             
        ), $atts));

        $output  = '<div class="clearfix">';
            $output .= ( $height )? '<div class="hb-space" style="height:'.esc_attr($height).'"></div>' : '<div class="hb-space"></div>';
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_space', 'hb_space_shortcode');
}

// TAB PANEL SHORTCODE
if( !function_exists('hb_tabpanel') ) {

    function hb_tabpanel( $atts, $content ){
            
            extract(shortcode_atts(array(
                'class'     => ''
            ), $atts)); 
            
            $return = '';
                        
            $GLOBALS['tab_count'] = 0;
            $GLOBALS['tabs'] = array();
            
            do_shortcode( $content );       
        
            if( is_array( $GLOBALS['tabs'] ) ){
                
                $tabcount = 1;
                
                foreach( $GLOBALS['tabs'] as $tab ){
                    
                    $active = ($tabcount == 1) ? 'class="active"' : '';
                    $tabs[]     = '<li role="presentation" '.$active.'><a href="#tab-'.$tab['id'].'" data-toggle="tab" role="tab">'.$tab['title'].'</a></li>';
                    
                    $active = ($tabcount == 1) ? 'active in' : '';
                    $panes[]    = '<div class="tab-pane fade '.$active.' '.$tab['class'].' clearfix" id="tab-'.$tab['id'].'" role="tabpanel">'.do_shortcode($tab['content']).'</div>';
                    
                    $tabcount++;
                    
                }
                
                $return .= '<div class="hb-tabpanel" role="tabpanel">';
                
                $return .= "\n".'<!-- the tabs --><ul class="nav nav-tabs" role="tablist">'.implode( "\n", $tabs ).'</ul>'."\n".'<!-- tab "panes" --><div class="tab-content">'.implode( "\n", $panes ).'</div>'."\n";
                
                $return .= '</div>';
                
                
            }
        
        return $return;
    
    }
    add_shortcode( 'hb_tabpanel', 'hb_tabpanel' );

}

if( !function_exists('hb_tab') ) {

    function hb_tab( $atts, $content ){
        
        extract(shortcode_atts(array(
            'title' => '%d',
            'id' => '%d',
            'class' => ''
        ), $atts));
        
                
        $x = $GLOBALS['tab_count'];
        $GLOBALS['tabs'][$x] = array(
            'title' => sprintf( $title, $GLOBALS['tab_count'] ),
            'content' =>  $content,
            'id' =>  $id,        
            'class' => $class );
        
        $GLOBALS['tab_count']++;
    }
    add_shortcode( 'hb_tab', 'hb_tab' );
}

// TEAM SHORTCODE
if( !function_exists('hb_team_shortcode') ) { 
 
    function hb_team_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'class'        => '',
             'id'           => '',
             'name'         => '',
             'link2page'    => ''
             
        ), $atts));

        if ( !$id && !$name ) { return; }

        if ( $name && !$id ):
            global $wpdb;
            $name = esc_sql($name);
            $post_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $name . "'" );
        else:
            $post_id = $id;
        endif;

        $getpost = get_post($post_id);

        if ( !$getpost ) { return; }

        $activated  = hb_shortcode_active_option_values();

        $link2page = in_array($link2page, $activated)? true : false;

        $classes = array();

        $classes[] = 'hb-member hb-member-po';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $image_size = 'full'; // allow gifs

        $output  = '<div class="'.esc_attr($classes).'">';
            $output .= '<div class="hb-member-img-wrap">';
                        $member_alt     = false;
                        $member_img     = 'http://placehold.it/1024x1280'; // default img
                        $member_img_id  = get_post_meta($post_id, 'img', true);
                        $member_img_obj = wp_get_attachment_image_src($member_img_id, $image_size);
                        if ( $member_img_obj ){
                            $member_img = $member_img_obj[0];
                        }

                        $member_alt_id  = get_post_meta($post_id, 'img_alt', true);
                        $member_alt_obj = wp_get_attachment_image_src($member_alt_id, $image_size);
                        if ( $member_alt_obj ){
                            $member_alt = $member_alt_obj[0];
                        }

                    $output .= '<div class="hb-member-img" style="background-image: url('.$member_img.')"></div>';
                    if ($member_alt):
                    $output .= '<div class="hb-member-img-alt" style="background-image: url('.$member_alt.')"></div>';
                    endif;

                    if ($link2page){
                        $output .= '<a href="'.get_permalink($post_id).'" rel="bookmark"></a>';
                    }
                $output .= '</div>';
                $output .= ($link2page)?
                '<h6 class="member-name"><a href="'.get_permalink($post_id).'" rel="bookmark">'.get_the_title($post_id).'</a></h6>'
                :
                '<h6 class="member-name">'.get_the_title($post_id).'</h6>';
                $title = get_post_meta($post_id, 'title', true);
                if ( $title ) { $output .= '<p class="member-title">'.$title.'</p>'; }
                $output .= apply_filters('the_content', get_post_meta($post_id, 'desc', true));
                    $socials = get_post_meta($post_id, 'socials', true);
                    if ( $socials && is_array($socials) && !empty($socials) ){

                        $output .= '<div class="hb-member-socials">';

                        foreach ($socials as $social) {

                            if ( !$social['href'] ) { continue; }

                            $url = ( false === strpos($social['href'], 'mailto:') || false === strpos($social['href'], 'tel:')) ? esc_url($social['href']) : $social['href'];

                            $output .= '<a href="'.$url.'" target="_blank" class="hb-social"><span>'.$social['name'].'</span></a>';
                        }

                        $output .= '</div>';
                    }
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_team', 'hb_team_shortcode');
}

// TESTIMONIAL SHORTCODE
if( !function_exists('hb_testimonial_shortcode') ) { 
 
    function hb_testimonial_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'class'    => ''   
             
        ), $atts));

        return '<div class="hb-carousel hb-testimonial '.esc_attr($class).'" data-items="1" data-margin="on" data-dots="on">'.do_shortcode($content).'</div>';
    }

    add_shortcode('hb_testimonial', 'hb_testimonial_shortcode');
}

// QUOTE SHORTCODE
if( !function_exists('hb_quote_shortcode') ) { 
 
    function hb_quote_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'author'       => '',
             'title'        => '',
             'avatar'       => '',

        ), $atts));

        $output  = '<div class="item">';
            $output .= '<div class="hb-sbs hb-sides-2">';

                $output .= '<div class="hb-side hb-side-padding text-center">';
                    $output .= '<div class="tiny-content">';
                        if ( !empty($avatar) ){
                            $output .= '<div class="testimonial-avatar" style="background-image:url('.esc_url($avatar).')"></div>';
                        }
                        if ( !empty($author) ){
                            $output .= '<h6>'.$author.'</h6>';
                        }
                        if ( !empty($title) ){
                            $output .= '<p>'.$title.'</p>';
                        }
                    $output .= '</div>';
                $output .= '</div>';

                $output .= '<div class="hb-side hb-side-padding">';
                    $output .= '<div class="tiny-content clearfix">';
                        $output .= '<p class="fancy-font">'. do_shortcode($content) .'</p>';
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_quote', 'hb_quote_shortcode');
}

// THEME SLIDER SHORTCODE
if( !function_exists('hb_theme_slider_shortcode') ) { 
 
    function hb_theme_slider_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'id'       => '',
             'class'    => ''
             
        ), $atts));

        $id = intval($id);

        $uniqid = uniqid();

        $classes = array();

        $classes[] = 'hb-slider hb-theme-slider';

        if ( $class )

            $classes[] = $class;

        $classes = implode(' ', $classes);

        $output  = '<div id="hb-theme-slider-'.$uniqid.'" class="'.esc_attr($classes).'">';

            $output .= hb_generate_theme_slider_content( $id, $uniqid );

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_theme_slider', 'hb_theme_slider_shortcode');
}

function hb_generate_theme_slider_content( $id = 0, $uniqid = 0 ){

    $content = $before = $after = '';

    $slider = get_post( $id );

    if ( $id && $slider && 'theme_slider' == $slider->post_type ):

        $data = array(
            'animatein'     => get_post_meta($id, 'animatein', true),
            'animateout'    => get_post_meta($id, 'animateout', true),
            'dots'          => get_post_meta($id, 'dots', true),
        );

        $data = array_map('trim', $data);
        $data = array_map('esc_attr', $data);

        $titlestyle     = get_post_meta($id, 'title_style', true);
        $titlesize      = get_post_meta($id, 'title_size', true);
        $subtitle_style = get_post_meta($id, 'subtitle_style', true);
        $slides         = get_post_meta($id, 'slides', true);

        if ( $slides && is_array($slides) && !empty($slides) ):

            $content  = '<div class="hb-theme-slides"';

                foreach ($data as $key => $value) :

                    $content .= ' data-'.$key.'="'.$value.'"';

                endforeach;

            $content .= '>';

                foreach ($slides as $slide) :

                    if ( ! $slide['img'] ) continue;

                    $img = wp_get_attachment_image_src($slide['img'], 'full');

                    if ( ! $img ) continue;

                    $content .= '<div class="item">';

                        $content .= '<div class="hb-slider-bg hb-have-bg" style="background-image:url('. $img[0] .')"></div>';

                        if ( 'on' == $slide['overlay'] )
                            $content .= hb_generate_theme_slider_overlay($slide);

                        $content .= '<div class="hb-slider-content">';
                            $content .= '<div class="slider-container">';
                                $content .= '<div class="vertical-align">';
                                    $content .= '<div class="centered-box">';

                                        if ( $slide['title'] ){

                                        
                                        switch ( $titlestyle ) {
                                            case 'span':
                                                $slide['title'] = hb_render_span_title_html($slide['title']);
                                                break;
                                            
                                            case 'justify':
                                                $slide['title'] = hb_txt_justify($slide['title']);
                                                break;
                                        }


                                            $content .= '<div class="h1 headline-'.esc_attr($titlestyle).' '.esc_attr($titlesize).'">';
                                                $content .= $slide['title'];
                                            $content .= '</div>';
                                        }

                                        if ( $slide['subtext'] ){

                                            $content .= '<div class="hb-animated-string-subtext clearfix">';
                                                $content .= '<div class="headline-frame '.esc_attr($subtitle_style).' clearfix">';
                                                    $content .= '<span class="headline-frame-entry">'. do_shortcode($slide['subtext']) . '</span>';
                                                $content .= '</div>';
                                            $content .= '</div>';
                                        }

                                        if ( $slide['btn_link'] ){

                                            if ( ! $slide['btn_label'] ) $slide['btn_label'] = 'Find out more';

                                            $content .= '<a href="'.esc_attr($slide['btn_link']).'" class="btn btn-xs btn-default"><span>'.$slide['btn_label'].'</span></a>';
                                            
                                        }

                                    $content .= '</div>';
                                $content .= '</div>';
                            $content .= '</div>';
                        $content .= '</div>';

                    $content .= '</div>';

                endforeach;

            $content .= '</div>';

        else:

            // no slide found
            $content = hb_generate_theme_slider_errors( __('No Slide Found!', 'glaze')."<br/><a href='". get_admin_url()."post.php?post=".$id."&action=edit'>".__('Create New Ones!', 'glaze')."</a>");

        endif;

    else:

        // no slider found
        $content = hb_generate_theme_slider_errors( __('No Theme Slider Found! Please Check Shortcode ID or', 'glaze')."<br/><a href='". get_admin_url()."post-new.php?post_type=theme_slider'>".__('Create A New One!', 'glaze')."</a>" );

    endif;

    return $before . $content . $after;
}


function hb_generate_theme_slider_overlay( $layer ){

    $uniqid  = uniqid();
    $output  = '<div id="layer-overlay-'.$uniqid.'" class="layer-overlay"></div>';
    $output .= '<style type="text/css">';

        $overlay = array();

        $overlay['opacity'] = $layer['overlay_opacity'];

        if ( $layer['color_overlay'] )

            $overlay['background-color'] = $layer['color_overlay'];

        if ( $layer['pattern_overlay'] && $layer['pattern_overlay'] != 'gradient' )

            $overlay['background-image'] = HB_THEME_URL . "/img/{$layer['pattern_overlay']}.png";

        if ( isset($layer['overlay_fixed']) && $layer['overlay_fixed'] == 'on')

            $overlay['background-attachment'] = 'fixed';

        if ( $layer['pattern_overlay'] 
            && $layer['pattern_overlay'] == 'gradient' 
            && $layer['gradient_overlay_start'] 
            && $layer['gradient_overlay_end'] ){

            if ( isset($overlay['background-color'])) unset($overlay['background-color']);
            if ( isset($overlay['background-attachment'])) unset($overlay['background-attachment']);
            
            $overlay['gradient'] = array(
                'start' => $layer['gradient_overlay_start'],
                'end'   => $layer['gradient_overlay_end']
            );
        }

        $output .= '#layer-overlay-'.$uniqid.' {';

        foreach ( $overlay as $module => $style ):

                if ( $style ) 

                    if ( 'gradient' != $module )

                        if ( 'background-image' == $module )
                            $output .= "background-image: url({$style});";
                        else
                            $output .= "{$module}: {$style};";

                    else

                        $output .= "background: {$style['start']};".
                                "background: -moz-linear-gradient(-45deg,  {$style['start']} 0%, {$style['end']} 100%);".
                                "background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,{$style['start']}), color-stop(100%,{$style['end']}));".
                                "background: -webkit-linear-gradient(-45deg,  {$style['start']} 0%,{$style['end']} 100%);".
                                "background: -o-linear-gradient(-45deg,  {$style['start']} 0%,{$style['end']} 100%);".
                                "background: -ms-linear-gradient(-45deg,  {$style['start']} 0%,{$style['end']} 100%);".
                                "background: linear-gradient(135deg,  {$style['start']} 0%,{$style['end']} 100%);".
                                "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$style['start']}', endColorstr='{$style['end']}',GradientType=1 );";

        endforeach;
        $output .= '}';
    $output .= '</style>';

    return $output;
}

function hb_generate_theme_slider_errors( $admin_error = '' ){

    $content = $before = $after = '';

        $content = ( current_user_can('edit_theme_options') && $admin_error ) ?

                    "<p class='hb-error'>".$admin_error."</p>"

        :

                    "<p class='hb-error'>". 
                    __('Monkeys are working on this content hardly ;)', 'glaze'). 
                    "</p>"
        ;

        $before  = '<div class="hb-slider-bg hb-default"></div>';
        $before .= '<div class="hb-slider-content">';
            $before .= '<div class="vertical-align">';
                $before .= '<div class="centered-box">';

                $after  = '</div>';
            $after .= '</div>';
        $after .= '</div>';

    return $before . $content . $after;
}

// THUMBNAIL PRODUCT SHORTCODE
function hb_thumbnail_products_shortcode( $atts ) {

    $atts = shortcode_atts( array(
        'columns'   => '4',
        'orderby'   => 'title',
        'order'     => 'asc',
        'ids'       => '',
        'skus'      => '',
        'per_page'  => '3',
    ), $atts );

    $meta_query = WC()->query->get_meta_query();

    $args = array(
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby'             => $atts['orderby'],
        'order'               => $atts['order'],
        'posts_per_page'      => $atts['per_page'],
        'meta_query'          => $meta_query
    );

    if ( ! empty( $atts['skus'] ) ) {
        $skus = explode( ',', $atts['skus'] );
        $skus = array_map( 'trim', $skus );
        $args['meta_query'][] = array(
            'key'       => '_sku',
            'value'     => $skus,
            'compare'   => 'IN'
        );
    }

    if ( ! empty( $atts['ids'] ) ) {
        $ids = explode( ',', $atts['ids'] );
        $ids = array_map( 'trim', $ids );
        $args['post__in'] = $ids;
    }

    ob_start();

    $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

    if ( $products->have_posts() ) : ?>

        <div class="hb-thumbnail-products">

            <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                <?php global $product; ?>

                <?php
                $thumb = 0;
                if ( has_post_thumbnail() && $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full') ){

                    $thumb = esc_url($img[0]);
                }
                ?>
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <span class="hb-product-thumb" style="background-image:url(<?php echo $thumb; ?>)"></span>
                    <div class="hb-thumb-product-entry">
                        <?php the_title('<h6 class="headline-underline">', '</h6>'); ?>
                        <span class="hb-product-price"><?php echo $product->get_price_html(); ?></span>
                    </div>
                </a>

            <?php endwhile; // end of the loop. ?>

        </div>

    <?php endif;

    wp_reset_postdata();

    return '<div class="woocommerce columns-' . $atts['columns'] . '">' . ob_get_clean() . '</div>';
}

add_shortcode('hb_thumbnail_products', 'hb_thumbnail_products_shortcode');

// TWITTER FEED SHORTCODE
if( !function_exists('hb_twitter_feed_shortcode') ) { 
 
    function hb_twitter_feed_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'count'    => 4,
             'class'    => '',
             'oauth_access_token' => '',
             'oauth_access_token_secret' => '',
             'consumer_key' => '',
             'consumer_secret' => '',
             
        ), $atts));

        if ( ! function_exists('hb_get_twitter_feed') || ! function_exists('hb_twitter_time_ago') ){
            return;
        }

        $settings = array(
            'oauth_access_token' => '',
            'oauth_access_token_secret' => '',
            'consumer_key' => '',
            'consumer_secret' => ''
        );

        if ( function_exists('ot_get_option') ){

            $settings = array(
                'oauth_access_token' => ot_get_option('twitter_access_token'),
                'oauth_access_token_secret' => ot_get_option('twitter_access_token_secret'),
                'consumer_key' => ot_get_option('twitter_consumer_key'),
                'consumer_secret' => ot_get_option('twitter_consumer_secret')
            );
        }

        if ( $oauth_access_token && $oauth_access_token_secret && $consumer_key && $consumer_secret ){

            $settings = array(
                'oauth_access_token' => $oauth_access_token,
                'oauth_access_token_secret' => $oauth_access_token_secret,
                'consumer_key' => $consumer_key,
                'consumer_secret' => $consumer_secret
            );
        }

        $settings = array_map( 'trim', $settings );

        if ( in_array('', $settings) ) {
            return __( 'Please make sure you have entered all necessary Twitter API Keys under Theme Options -> Twitter' , 'glaze');
        }

        $tweets = hb_get_twitter_feed( $settings, $count );

        if ( empty($tweets) || count($tweets) < 2 ){

            return '<div class="alert alert-warning" role="alert">'.__('An Error has occured, no Twitter Feeds are available', 'glaze').'</div>';
        }

        $classes = array();

        $classes[] = 'hb-twitter-feed text-center';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'">';

            $output .= '<i class="fa fa-twitter fa-2x"></i>';

            $output .= '<div class="hb-twitter-slider owl-carousel" data-dots="off" data-animatein="fadeIn" data-animateout="fadeOut">';

            foreach ($tweets as $tweet) {

                $tweetdate = new DateTime($tweet->created_at);
                $tweetdate = strtotime($tweetdate->format('Y-m-d H:i:s'));
                $currentdate = strtotime(date('Y-m-d H:i:s'));  
                $days = hb_twitter_time_ago($tweetdate , $currentdate);

                $output .= '<div class="item">';
                    $output .= '<div class="tiny-content">';
                        $output .= '<div class="h6 tweet-text">'.hb_clean_tweet($tweet->text).'</div>';
                        $output .= '<div class="tweet-bottom clearfix">';
                        $output .= '<span class="tweet_time"><a href="http://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id.'">@'. $tweet->user->screen_name.' '. __('about', 'glaze').' '. $days .'</a></span>';
                            $output .= '<span class="tweet-actions">';
                                $output .= ' <a href="https://twitter.com/intent/retweet?tweet_id='.$tweet->id.'" rel="nofollow" target="_blank"><i class="fa fa-retweet"></i></a>';
                                $output .= ' <a href="https://twitter.com/intent/favorite?tweet_id='.$tweet->id.'" rel="nofollow" target="_blank"><i class="fa fa-heart"></i></a>';
                            $output .= '</span>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
            }
            $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_twitter_feed', 'hb_twitter_feed_shortcode');
}

// VIDEO SHORTCODE
if( !function_exists('hb_video_shortcode') ) { 
 
    function hb_video_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'url'          => '',
             'ratio'        => '',
             'class'        => ''
             
        ), $atts));

        if ( empty($url) || ! function_exists('hb_get_video') ) {

            return;
        }

        $classes = array();

        $classes[] = 'hb-video';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $ratio = ( '4x3' == $ratio ) ? 'embed-responsive-4by3' : 'embed-responsive-16by9';

        $video = hb_get_video( $url, $ratio );

        $output  = '<div class="'.esc_attr($classes).'">';
            $output .= $video;
        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_video', 'hb_video_shortcode');
}

// VIDEO POPUP BUTTON SHORTCODE
if( !function_exists('hb_video_popup_btn_shortcode') ) { 
 
    function hb_video_popup_btn_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'url'          => '',
             'label'        => 'Watch Video',
             'class'        => ''
             
        ), $atts));

        if ( empty($url) ) { return; }

        $classes = array();

        $classes[] = 'btn btn-xs btn-default popup hb-video-popup-button';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        return '<a data-type="video" class="'.esc_attr($classes).'" href="'.esc_url($url).'"><span>'. $label .'</span></a>';
    }

    add_shortcode('hb_video_popup_btn', 'hb_video_popup_btn_shortcode');
}

// VIDEO POPUP IMG SHORTCODE
if( !function_exists('hb_video_popup_img_shortcode') ) { 
 
    function hb_video_popup_img_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'url'          => '',
             'cover_image'  => '',
             'class'        => ''
             
        ), $atts));

        if ( empty($url) || empty($cover_image) ) return;

        $classes = array();

        $classes[] = 'popup hb-video-popup-image';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $output  = '<a data-type="video" class="'.esc_attr($classes).'" href="'.esc_url($url).'">';
            $output .= '<img src="'.esc_url($cover_image).'" alt=""/>';
            $output .= '<svg version="1.1" class="svg-play-btn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><circle cx="50" cy="50" r="45"/><polygon points="39.5,33.2 68.5,50 39.5,66.8 "/></svg>';
        $output .= '</a>';

        return $output;
    }

    add_shortcode('hb_video_popup_img', 'hb_video_popup_img_shortcode');
}

// WORK CAROUSEL SHORTCODE
if( !function_exists('hb_work_carousel_shortcode') ) { 
 
    function hb_work_carousel_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'group'        => '',
             'count'        => '6',
             'class'        => '',
             'dots'         => 'on',
             'margin'       => 'on',
             
        ), $atts));

        $count = ( $count == '-1' ) ? -1 : intval($count);

        $args = array(

            'post_type'             => 'work',
            'paged'                 => 1,
            'ignore_sticky_posts'   => true,
        );

        if ( $count ) {

            $args['posts_per_page'] = $count;
        }

        if ( $group ) {

            $args['tax_query'] = array(

                array(
                    'taxonomy' => 'work-group',
                    'terms'    => explode(',', $group), 
                )
            );
        }

        query_posts( $args );

        if ( ! have_posts() ) {

            wp_reset_query();

                if ( current_user_can('edit_theme_options') ){

                    $output = "<p class='hb-error'>". 
                    __('No Work Found!', 'glaze').
                    "<br/><a href='".get_admin_url()."post-new.php?post_type=work'>".__('Create One!', 'glaze')."</a>".
                    "</p>";

                } else {

                    $output = "<p class='hb-error'>".
                    __('Monkeys are working on this content hardly ;)', 'glaze'). 
                    "</p>";
                }

            return $output;
        }

        $activated  = hb_shortcode_active_option_values();

        $dots = in_array( trim(strtolower($dots)), $activated)? 'on' : 'off' ;

        $margin = in_array( trim(strtolower($margin)), $activated)? 'on' : 'off' ;

        $classes = array();

        $classes[] = 'hb-carousel hb-animate-group';

        if ( $class ){

            $classes[] = $class;
        }

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'" data-dots="'.$dots.'" data-margin="'.$margin.'">';

            while ( have_posts() ) : the_post();

                $output .= '<div class="hb-work hb-carousel-item hb-animate" data-animation="fadeInRight">';

                    $output .= '<a href="' . get_permalink() . '" rel="bookmark">';

                        if ( has_post_thumbnail() ){

                            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');

                            $output .= '<div class="box-img" style="background-image:url('. $thumb[0] .')"></div>';
                        }

                        $output .= '<h2 class="hb-work-title">' . get_the_title() . '</h2>';

                    $output .= '</a>';

                $output .= '</div>';

            endwhile; wp_reset_query();

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_work_carousel', 'hb_work_carousel_shortcode');
}

// WORKS SHORTCODE

if( !function_exists('hb_works_shortcode') ) { 
 
    function hb_works_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'group'        => '',
             'count'        => '6',
             'class'        => ''
             
        ), $atts));

        $count = ( $count == '-1' ) ? -1 : intval($count);

        $args = array(

            'post_type'             => 'work',
            'paged'                 => 1,
            'ignore_sticky_posts'   => true,
        );

        if ( $count ) {

            $args['posts_per_page'] = $count;
        }

        if ( $group ) {

            $args['tax_query'] = array(

                array(
                    'taxonomy' => 'work-group',
                    'terms'    => explode(',', $group), 
                )
            );
        }

        query_posts( $args );

        if ( ! have_posts() ) {

            wp_reset_query();

                if ( current_user_can('edit_theme_options') ){

                    $output = "<p class='hb-error'>". 
                    __('No Work Found!', 'glaze').
                    "<br/><a href='".get_admin_url()."post-new.php?post_type=work'>".__('Create One!', 'glaze')."</a>".
                    "</p>";

                } else {

                    $output = "<p class='hb-error'>".
                    __('Monkeys are working on this content hardly ;)', 'glaze'). 
                    "</p>";
                }

            return $output;
        }

        $classes = array();

        $classes[] = 'hb-works';

        $classes[] = 'hb-masonry';

        if ( $class ){

            $classes[] = $class;
        }

        $classes[] = 'clearfix';

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'">';

            if ( trim($content) ){
                $output .= '<div class="hb-work hb-masonry-item hb-work-desc">' . do_shortcode($content) . '</div>';
            }

            while ( have_posts() ) : the_post();

                $output .= '<a href="' . get_permalink() . '" rel="bookmark" class="hb-work hb-masonry-item hb-animate-solo">';

                    if ( has_post_thumbnail() ){

                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');

                        $output .= '<div class="box-img" style="background-image:url('. $thumb[0] .')"></div>';
                    }

                    $output .= '<h2 class="hb-work-title">' . get_the_title() . '</h2>';

                $output .= '</a>';

            endwhile; wp_reset_query();

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_works', 'hb_works_shortcode');
}

// WORKS GRID SHORTCODE
if( !function_exists('hb_works_grid_shortcode') ) { 
 
    function hb_works_grid_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'group'        => '',
             'columns'      => '3',
             'count'        => '6',
             'filter'       => '',
             'class'        => ''
             
        ), $atts));

        if ( ! wp_script_is('hb-worksfilter') )
            wp_enqueue_script( 'hb-worksfilter' );

        $activated  = hb_shortcode_active_option_values();

        $allowed_cols   = array('2','double','two','3','triple','three','4','four');

        $work_cols      = array(
            '2' => '2',
            'double' => '2',
            'two' => '2',
            '3' => '3',
            'triple' => '3',
            'three' => '3',
            '4' => '4',
            'four' => '4'
        );

        $columns = ($columns && in_array($columns, $allowed_cols))? $work_cols[$columns] : '3';

        $count = ( $count == '-1' ) ? -1 : intval($count);

        $args = array(

            'post_type'             => 'work',
            'paged'                 => 1,
            'ignore_sticky_posts'   => true,
        );

        if ( $count ) {

            $args['posts_per_page'] = $count;
        }

        if ( $group ) {

            $args['tax_query'] = array(

                array(
                    'taxonomy' => 'work-group',
                    'terms'    => explode(',', $group), 
                )
            );
        }

        query_posts( $args );

        if ( ! have_posts() ) {

            wp_reset_query();

                if ( current_user_can('edit_theme_options') ){

                    $output = "<p class='hb-error'>". 
                    __('No Work Found!', 'glaze').
                    "<br/><a href='".get_admin_url()."post-new.php?post_type=work'>".__('Create One!', 'glaze')."</a>".
                    "</p>";

                } else {

                    $output = "<p class='hb-error'>".
                    __('Monkeys are working on this content hardly ;)', 'glaze'). 
                    "</p>";
                }
                    
            return $output;
        }

        $classes = array();

        $classes[] = 'hb-works hb-grid-work';

        $classes[] = 'hb-works-col-'.$columns;

        $classes[] = 'hb-masonry';

        if ( $class ){

            $classes[] = $class;
        }

        $classes[] = 'clearfix';

        $classes = implode(' ', $classes);

        $uniqid = 'grid-works-' . uniqid();

        $output  = '<div class="grid-works-block">';

            if ( in_array($filter, $activated) ):

                if ( $group ):

                    $terms = get_terms( 'work-group', array('include'=>explode(',', $group)) );

                else:

                    $terms = get_terms( 'work-group' );

                endif;

                if ( $terms && is_array($terms) && !empty($terms) ):

                    $output .= '<div class="row">';
                        $output .= '<div class="col-xs-12">';
                            $output .= '<div id="workfilter-'. $uniqid .'" class="hb-workfilter-handle">';
                                $output .= '<div class="hb-workfilter-action hb-workfilter-active" data-workfilterclass="hb-cat-workfiltered" data-gridpostitems="#'. $uniqid .'-items">';
                                    $output .= '<div class="hb-workfilter-items">';
                                        $output .= '<div class="hb-workfilter-carousel">';

                                            $output .= '<div class="hb-workfilter"><span data-hbworkfilter="hb-work">' . __('All', 'glaze') .' <em class="workfilter-balloon"></em></span></div>';

                                                foreach ( $terms as $term) {

                                                    if ( empty($term->slug ) )
                                                        continue;

                                                    $output .= '<div class="hb-workfilter"><span data-hbworkfilter="category-' .sanitize_html_class($term->slug, $term->term_id). '">' .$term->name. ' <em class="workfilter-balloon"></em></span></div>';
                                                }

                                        $output .= '</div>';
                                    $output .= '</div>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                
                endif;

            endif;

            $output .= '<div id="'.esc_attr($uniqid).'-items" class="'.esc_attr($classes).'">';

                while ( have_posts() ) : the_post();

                    $output .= '<a href="' . get_permalink() . '" rel="bookmark" class="'.implode(' ', get_post_class("hb-work hb-masonry-item hb-animate-solo")). '">';

                        if ( has_post_thumbnail() ){

                            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');

                            $output .= '<div class="box-img" style="background-image:url('. $thumb[0] .')"></div>';
                        }

                        $output .= '<h2 class="hb-work-title">' . get_the_title() . '</h2>';

                    $output .= '</a>';

                endwhile; wp_reset_query();

            $output .= '</div>';

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_works_grid', 'hb_works_grid_shortcode');
}

// WORKS MASONRY
if( !function_exists('hb_works_masonry_shortcode') ) { 
 
    function hb_works_masonry_shortcode($atts, $content = null) {
                
        extract(shortcode_atts(array(
             
             'group'        => '',
             'count'        => '6',
             'class'        => ''
             
        ), $atts));

        $count = ( $count == '-1' ) ? -1 : intval($count);

        $args = array(
            'post_type'             => 'work',
            'paged'                 => 1,
            'ignore_sticky_posts'   => true,
        );

        if ( $count ) {

            $args['posts_per_page'] = $count;
        }

        if ( $group ) {

            $args['tax_query'] = array(

                array(
                    'taxonomy' => 'work-group',
                    'terms'    => explode(',', $group), 
                )
            );
        }

        query_posts( $args );

        if ( ! have_posts() ) {

            wp_reset_query();

            if ( current_user_can('edit_theme_options') ){

                $output = "<p class='hb-error'>". 
                __('No Work Found!', 'glaze').
                "<br/><a href='".get_admin_url()."post-new.php?post_type=work'>".__('Create One!', 'glaze')."</a>".
                "</p>";

            } else {

                $output = "<p class='hb-error'>".
                __('Monkeys are working on this content hardly ;)', 'glaze'). 
                "</p>";
            }
                    
            return $output;
        }

        $classes = array();

        $classes[] = 'hb-masonry-work';

        if ( $class ){

            $classes[] = $class;
        }

        $classes[] = 'clearfix';

        $classes = implode(' ', $classes);

        $output  = '<div class="'.esc_attr($classes).'">';

            $output .= '<div class="hb-nemasonry-work-boxes">';

                $counter = 0;

                while ( have_posts() ) : the_post();

                    if ( ! has_post_thumbnail() ){

                        continue;
                    }

                    $counter++;

                    $output .= '<a href="' . get_permalink() . '" rel="bookmark" class="'.implode(' ', get_post_class("hb-nemasonry-item hb-animate-solo")). '">';

                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');

                        if (0 == $counter%2){

                            $skrollr = array(
                                'data-bottom-top="transform:translate3d(0,3rem,0)" data-top-bottom="transform:translate3d(0,-3rem,0)"',
                                'data-bottom-top="transform:translate3d(0,-1rem,0)" data-top-bottom="transform:translate3d(0,1rem,0)"',
                            );

                        } else {

                            $skrollr = array(
                                'data-bottom-top="transform:translate3d(0,-3rem,0)" data-top-bottom="transform:translate3d(0,3rem,0)"',
                                'data-bottom-top="transform:translate3d(0,1rem,0)" data-top-bottom="transform:translate3d(0,-1rem,0)"',
                            );
                        }
                        $output .= '<div class="hb-work-img" style="background-image:url('. $thumb[0] .')" '.$skrollr[0].'>';

                            $output .= '<div class="work-link">';
                                $output .= '<span class="wl-01"></span>';
                                $output .= '<span class="wl-02"></span>';
                                $output .= '<span class="wl-03"></span>';
                                $output .= '<span class="wl-04"></span>';
                                $output .= '<span class="wl-05"></span>';
                                $output .= '<span class="wl-06"></span>';
                                $output .= '<span class="wl-plus"></span>';
                            $output .= '</div>';

                        $output .= '</div>';

                        $output .= '<h2 class="hb-work-title-entry" '.$skrollr[1].'><span>' . wp_strip_all_tags(get_the_title()) . '</span></h2>';

                    $output .= '</a>';

                endwhile; wp_reset_query();

            $output .= '</div>';

        $output .= '</div>';

        return $output;
    }

    add_shortcode('hb_works_masonry', 'hb_works_masonry_shortcode');
}



