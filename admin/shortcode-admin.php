<?php

/**
 * Recognize shortcodes assets
 *
 * @return null
 **/
if( !function_exists('hb_recognize_shortcodes_assets_url') ) { 
    
    function hb_recognize_shortcodes_assets_url( $asset ){

    	$url = array(
    		'fontawesome' 	=> GSHORTCODES_URL . 'inc/font-awesome-4.3.0/css/font-awesome.css',
    		'ionicons'		=> GSHORTCODES_URL . 'inc/ionicons-2.0.1/css/ionicons.css',
    		'etlinefonts'	=> GSHORTCODES_URL . 'inc/et-line-font/style.css',
    		'bootstrap'		=> GSHORTCODES_URL . 'inc/bootstrap-3.3.5/css/bootstrap.only.fonts.css',
    	);

    	if ( empty($asset) || 'string' != gettype($asset) || ! isset($url[$asset]) ){
    		return;
    	}

        return apply_filters('glaze_shortcode_generate_css_url', $url[$asset], $asset);
    }
}

if ( ! function_exists( 'hb_shortcode_active_option_values' ) ):

	/**
	 *
	 * Activated values which user might use
	 *
	 * @since pixudio 1.0
	 *
	 * @return string
	 */
	function hb_shortcode_active_option_values(){

		return apply_filters( 'hb_shortcode_active_option_values', array(
			'1',
			'true',
			'active',
			'yes',
			'on',
			'whatever',
			'yup',
			'xo',
		));
	}

endif;

/**
 * Remove shortcodes which are not implemented from the list
 *
 * @return array
 **/
if( !function_exists('hb_gshortcodes_remove') ) { 
    
    function hb_gshortcodes_remove( $shortcodes ){

    	$gshortcodes = hb_recognized_shortcodes();

        foreach ($shortcodes as $index => $shortcode) :

        	if ( 0 === strpos($index, 'headline_') ){
        		continue;
        	}

        	if ( ! in_array($index, $gshortcodes) ){

        		unset($shortcodes[$index]);
        		continue;
        	}

        	// SHORTCODENAME_shortcode
        	$function_name 			= $index . '_shortcode';
        	// SHORTCODENAME_shortcode_custom
        	$function_name_custom   = $function_name . '_custom';

            if ( ! function_exists( $function_name )  && ! function_exists( $function_name_custom ) ) {

        		unset($shortcodes[$index]);
            }

        endforeach;

        return $shortcodes;
    }
    add_action('hb_recognized_shortcode_lists',  'hb_gshortcodes_remove', 10 , 1);
}


if ( ! function_exists( 'hb_tinymce_js_plugin' ) ) {
    
	/*
	 * Custom TinyMCE Plugin
	 *
	 */
    function hb_tinymce_js_plugin( $plugins ) {

       $plugins['hb_shortcode_generator'] = GSHORTCODES_URL . 'admin/js/hb-tinymce.js';

       return $plugins;
    }

}


if ( ! function_exists( 'register_hb_tinymce_button' ) ) {
    
	/*
	 * Create Add Shortcode Button
	 *
	 */
    function register_hb_tinymce_button( $buttons ) {
        array_push( $buttons, "hb_shortcode_generator" );
        return $buttons; 
    }
}

if ( !function_exists( 'hb_generate_shortcode_select' ) ) {
	
	/*
	 * Generate Shortcode Select Box
	 *
	 */
	function hb_generate_shortcode_select() {
		
		$hb_shortcodes = (array) hb_recognized_shortcode_lists();

		$counter = 1;
		$select  = '<p><select id="hb-shortcodes" class="form-control">';
		$select .= '<option selected="selected" value="" disabled="disabled">'.__('Choose Shortcode' , 'hb_shortcodes').'</option>';
		
		foreach( $hb_shortcodes as $code => $options ){
			
			/* definition is a headline */
			if($code == 'headline_'.$counter) {
				
				$select .= '<option class="disabled" value="'.$options['title'].'" disabled="disabled">'.$options['title'].'</option>';
				$counter++;
			
			/* definition is a shortcode */	
			} else {
				
				$options['clabel'] = (isset($options['clabel']) && !empty($options['clabel'])) ? $options['clabel'] : '';
				$select .= '<option value="'.$code.'" data-clabel="'.$options['clabel'].'">'.$options['title'].'</option>';
				
			}
			
		}
		
		$select .= '</select></p>';
		
		return $select;
	}
}


if( !function_exists('hb_recognized_animation_effects') ) :

	/*
	 * CSS3 Animation Effects
	 *
	 */
	function hb_recognized_animation_effects() {
	 
	  return apply_filters( 'hb_recognized_animation_effects', array(
		'flash',
		'bounce',
		'shake',
		'tada',
		'swing',
		'wobble',
		'wiggle',
		'pulse',
		'slideInUp',
		'slideInLeft',
		'slideInRight',
		'slideInDown',
		'flip',
		'flipInX',
		'flipInY',
		'fadeIn',
		'fadeInUp',
		'fadeInDown',
		'fadeInLeft',
		'fadeInRight',
		'fadeInUpBig',
		'fadeInDownBig',
		'fadeInLeftBig',
		'fadeInRightBig',
		'bounceIn',
		'bounceInDown',
		'bounceInUp',
		'bounceInLeft',
		'bounceInRight',
		'rotateIn',
		'rotateInDownLeft',
		'rotateInDownRight',
		'rotateInUpLeft',
		'rotateInUpRight',
		'lightSpeedIn',
		'hinge',
		'rollIn',
	  ));
	  
	}

endif;


if ( !function_exists( 'hb_get_option_element' ) ) {

	/*
	 * Generate shortcode config element
	 *
	 */
	function hb_get_option_element( $name, $attr_opt, $type, $code ){
		
		$return = '';
				
		switch( $attr_opt['type'] ){
			
			case 'radio' : return hb_generate_radio_option( $name, $attr_opt, $type, $code ); 
			break;
		
			case 'select': return hb_generate_select_option( $name, $attr_opt, $type, $code ); 
			break;
			
			case 'effect': return hb_generate_effect_option( $name, $type, $code ); 
			break;
			
		case 'custom':
	 

	 		if( $name == 'fancyli' ) {
				
				$return .= '<p><label>'.__( 'Manage List' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-facylist-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-fancylist well-white">';
														
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Icon' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';

							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="fancyli" style="margin-bottom:10px !important;" class="sc-fancyli-icon form-control propertychange" type="text" data-attrname="icon" value="" />';
								$return .= '<a href="#" class="btn btn-primary btn-sm open-hb-modal"> ' . __('Choose Icon' , 'hb_shortcodes') . '</a>';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Content' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<textarea data-group="fancyli" class="sc-fancyli-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
															
							$return .= '<button data-group="fancyli" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="fancyli" class="btn btn-primary btn-xs add-fancyli-item">'.__('Add List', 'hb_shortcodes' ).'</button><div class="clear"></div><br />';

			} elseif( $name == 'tabgroup' ) {
				$return .= '<p><label>'.__( 'Manage Tabs' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-list-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-lister well-white">';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Title' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="tabgroup" class="sc-list-item form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Tab Content' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<textarea data-group="tabgroup" class="sc-list-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';	
							
							$return .= '<button data-group="tabgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="tabgroup" class="btn btn-primary btn-xs add-list-item">' . __('Add Tab', 'hb_shortcodes' ) . '</button><div class="clear"></div><br />';
			
			} elseif( $name == 'verticaltabgroup' ) {
				
				$return .= '<p><label>'.__( 'Manage Vertical Image Tabs' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-list-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-lister well-white">';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Title' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="tabgroup" class="sc-list-item form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Tab Content' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<textarea data-group="tabgroup" class="sc-list-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';	
							
							$return .= '<button data-group="tabgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="tabgroup" class="btn btn-primary btn-xs add-list-item">' . __('Add Tab', 'hb_shortcodes' ) . '</button><div class="clear"></div><br />';
					
			} elseif( $name == 'clientgroup' ) {
				
				$return .= '<p><label>'.__( 'Manage Clients' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-client-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-clients well-white">';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Client Name' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="clientgroup" class="sc-client-item form-control client-name propertychange" type="text" name="" value="" />';
							$return .= '</div>';
														
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Client URL' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="clientgroup" class="sc-client-item form-control client-url propertychange" type="text" name="" value="" />';
							$return .= '</div>';
														
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Logo' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value hb-media-access" style="margin-bottom:10px;">';
									$return .= '<input data-group="clientgroup" class="sc-client-item form-control client-logo propertychange" type="text" value="" />';
									$return .= hb_media_access( __('Add Logo', 'hb_shortcodes' ) );
							$return .= '</div>';
															
							$return .= '<button data-group="clientgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';							
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="clientgroup" class="btn btn-primary btn-xs add-client-item">'.__('Add Client', 'hb_shortcodes' ).'</button><div class="clear"></div><br />';
			
            } elseif( $name == 'imagerotator' ) {
				
				$return .= '<p><label>'.__( 'Manage Images' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-irotator-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-irotator well-white">';
																					
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Link' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="irotatorgroup" class="sc-irotator-item form-control irotator-url propertychange" type="text" name="" value="" />';
							$return .= '</div>';
														
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Upload Image' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value hb-media-access" style="margin-bottom:10px;">';
									$return .= '<input data-group="irotatorgroup" class="sc-irotator-item form-control irotator-image propertychange" type="text" value="" />';
									$return .= hb_media_access( __('Add Image', 'hb_shortcodes' ) );
							$return .= '</div>';
															
							$return .= '<button data-group="irotatorgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';							
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="irotatorgroup" class="btn btn-primary btn-xs add-irotator-item">'.__('Add Image', 'hb_shortcodes' ).'</button><div class="clear"></div><br />';
                
			} elseif( $name == 'quoterotator' ) {
				
				$return .= '<p><label>'.__( 'Manage Quotes' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-quote-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-quotes well-white">';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Author' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="quotegroup" class="sc-quote-item form-control quote-author propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';

							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Author Title' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';

							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="quotegroup" class="sc-quote-item form-control quote-author-title propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Avatar' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value hb-media-access" style="margin-bottom:10px;">';
									$return .= '<input data-group="quotegroup" class="sc-quote-item form-control quote-avatar propertychange" type="text" value="" />';
									$return .= hb_media_access( __('Add Avatar', 'hb_shortcodes' ) );
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Quote' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<textarea data-group="quotegroup" class="sc-quote-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
															
							$return .= '<button data-group="quotegroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="quotegroup" class="btn btn-primary btn-xs add-quote-item">'.__('Add Quote', 'hb_shortcodes' ).'</button><div class="clear"></div><br />';
			
			} elseif( $name == 'quoterotator_alt' ) {
				
				$return .= '<p><label>'.__( 'Manage Quotes' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-quote-alt-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-quotes-alt well-white">';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Author' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="quote-alt-group" class="sc-quote-alt-item form-control quote-alt-author propertychange" type="text" name="" value="" />';
							$return .= '</div>';							
						
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Quote' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<textarea data-group="quote-alt-group" class="sc-quote-alt-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
															
							$return .= '<button data-group="quote-alt-group" type="button" class="btn btn-danger btn-xs remove-group-alt-item"><i class="fa fa-trash-o"></i></button>';
							
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="quote-alt-group" class="btn btn-primary btn-xs add-quote-alt-item">'.__('Add Quote', 'hb_shortcodes' ).'</button><div class="clear"></div><br />';
			
			} elseif( $name == 'togglegroup' ){ 
				
				$return .= '<p><label>'.__( 'Manage Accordion' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-toggle-items" data-name="item" data-type="s">';
						$return .= '<div class="sc-toggles well-white">';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Title' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="togglegroup" class="sc-toggle-item form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
													
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Content' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<textarea data-group="togglegroup" class="sc-toggle-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('State' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
							
							$return .= '<select data-group="togglegroup" class="sc-toggle-state sc-select-live">
											<option value="closed">' . __('closed' , 'hb_shortcodes') . '</option>
											<option value="open">' . __('open' , 'hb_shortcodes') . '</option>
										</select>';
							
							$return .= '</div>';
							
							$return .= '<button data-group="togglegroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="togglegroup" class="btn btn-primary btn-xs add-toggle-item">'.__('Add Accordion', 'hb_shortcodes' ).'</button><div class="clear"></div><br />';        
			
			} elseif( $name == 'socialmedia' ){
			
				$return .= '<p><label>'.__( 'Manage Social Media List' , 'hb_shortcodes' ).'</label></p>';
				
					$return .= '<div class="sc-toggle-socials" data-name="item" data-type="s">';
						$return .= '<div class="sc-socials well-white">';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Profile Title' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="socialgroup" class="sc-social-title form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Link to Profile' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="socialgroup" class="sc-social-link form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Target' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';							
							
							$return .= '<div class="hb-option-value">';
								$return .= '<select id="target" class="form-control sc-select-control" data-attrname="target">';
									$return .= '<option value="">Choose Target</option>';
									$return .= '<option value="_blank">_blank</option>';
									$return .= '<option value="_self">_self</option>';
								$return .= '</select>';
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Icon' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
							
							$return .= '<select data-group="socialgroup" class="sc-social-icon sc-select-live">
											<option value="fa-adn">adn</option>
											<option value="fa-android">android</option>
											<option value="fa-apple">apple</option>
											<option value="fa-bitbucket">bitbucket</option>
											<option value="fa-bitcoin">bitcoin</option>
											<option value="fa-btc">btc</option>
											<option value="fa-css3">css3</option>
											<option value="fa-dribbble">dribbble</option>
											<option value="fa-dropbox">dropbox</option>
											<option value="fa-facebook">facebook</option>
											<option value="fa-flickr">flickr</option>
											<option value="fa-foursquare">foursquare</option>
											<option value="fa-github">github</option>
											<option value="fa-gittip">gittip</option>
											<option value="fa-google-plus">google-plus</option>
											<option value="fa-html5">html5</option>
											<option value="fa-instagram">instagram</option>
											<option value="fa-linkedin">linkedin</option>
											<option value="fa-linux">linux</option>
											<option value="fa-maxcdn">maxcdn</option>
											<option value="fa-pinterest">pinterest</option>
											<option value="fa-renren">renren</option>
											<option value="fa-skype">skype</option>
											<option value="fa-stack-exchange">stackexchange</option>
											<option value="fa-trello">trello</option>
											<option value="fa-tumblr">tumblr</option>
											<option value="fa-twitter">twitter</option>
											<option value="fa-vk">vk</option>
											<option value="fa-weibo">weibo</option>
											<option value="fa-windows">windows</option>
											<option value="fa-xing">xing</option>
											<option value="fa-youtube">youtube</option>
										</select>';
							
							$return .= '</div>';
							
							$return .= '<div class="hr"></div>';
													
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>' . __('Content' , 'hb_shortcodes') . ' </label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<textarea data-group="socialgroup" class="sc-social-text form-control propertychange" type="text" name="" /></textarea>';
							$return .= '</div>';
							
							$return .= '<button data-group="socialgroup" type="button" class="btn btn-danger btn-xs remove-group-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					$return .= '</div>';
					
				$return .= '<button type="button" data-group="togglegroup" class="btn btn-primary btn-xs add-social-item">'.__('Add Profile', 'hb_shortcodes' ).'</button><div class="clear"></div>';
			
			
			} elseif( $name == 'probars' ){
				
				$return .= '<label>'.__( 'Manage Bars' , 'hb_shortcodes' ).'</label>';
				
					$return .= '<div class="sc-bar-items" data-name="item" data-type="s">';
					   
					   $return .= '<div class="sc-bars">';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>'.__('Width' , 'hb_shortcodes').'</label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="probars" class="sc-bar-width form-control propertychange" type="text" name="" value="" maxlength="3" />';
							$return .= '</div>';
							
							$return  .= '<div class="hb-option-field">';
								$return .= '<label>'.__('Bar Text' , 'hb_shortcodes').'</label>';
							$return .= '</div>';
							
							$return .= '<div class="hb-option-value">';
								$return .= '<input data-group="probars" class="sc-bar-text form-control propertychange" type="text" name="" value="" />';
							$return .= '</div>';
														
							$return .= '<button type="button" data-group="probars" class="btn btn-danger btn-xs remove-bar-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';
					   
					   $return .= '<div class="sc-bars sc-to-copy">';
							
							$return .= '<p><label>'.__('Width' , 'hb_shortcodes').'</label>';
							$return .= '<input data-group="probars" class="sc-bar-width" type="text" name="" value="" maxlength="3" /></p>';
							
							$return .= '<p><label>'.__('Bar Text' , 'hb_shortcodes').'</label>';
							$return .= '<input data-group="probars" class="sc-bar-text" type="text" name="" value="" /></p>';
							
							$return .= '<button type="button" data-group="probars" class="btn btn-danger btn-xs remove-bar-item"><i class="fa fa-trash-o"></i></button>';
							
					   $return .= '</div>';  
										
					   $return .= '<a href="#" data-group="probars" class="btn add-bar-item">'.__('Add Bar to Group', 'hb_shortcodes' ).'</a>';
					   
					$return .= '</div>';
				
			} elseif( $type == 'c' ){
			
				$return .= '<p><label for="'.$code.'-lastcolumn"><input type="checkbox" class="lastcolumn" id="'.$code.'-lastcolumn" /> '.__('last column' , 'hb_shortcodes').'</label></p>';
			
			} elseif( $name == 'customname' ){
			
				$return .= '<input type="text" id="custom-box-name" class="form-control">';
				
			}
			break;
		
		case 'colorpicker':
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return .= '<div class="hb-option-field"><label for="sc-opt-'.$name.'">'.$attr_opt['title'].' </label></div>';
			$return .= '<div class="hb-option-value"><input class="attr color-picker-hex form-control hb-color-picker" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" /></div>';
			
			break;
		
		case 'icon':
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return .= '<div class="hb-option-field"><label for="sc-opt-'.$name.'">'.$attr_opt['title'].' </label></div>';
			$return .= '<div class="hb-option-value">';
				$return .= '<input style="margin-bottom:10px !important;" class="attr form-control" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" />';
				$return .= '<a href="#" class="btn btn-primary btn-sm open-hb-modal"> ' . __('Choose Icon' , 'hb_shortcodes') . '</a>';
			$return .= '</div>';
			
			break;
		
		case 'range':
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';

			$min = (isset($attr_opt['min']))? $attr_opt['min'] : '0';
			$max = (isset($attr_opt['max']))? $attr_opt['max'] : '1';
			$step = (isset($attr_opt['step']))? $attr_opt['step'] : '0.1';
			$value = (isset($attr_opt['value']))? $attr_opt['value'] : '0.8';
			
			$return .= '<div class="hb-option-field"><label for="sc-opt-'.$name.'">'.$attr_opt['title'].' </label></div>';
			$return .= '<div class="hb-option-value hb-range-slider-group hb-jquery-ui">';
				$return .= '<div class="hb-range-slider" data-min="'.$min.'" data-max="'.$max.'" data-step="'.$step.'" data-value="'.$value.'"></div>';
				$return .= '<span class="hb-range-value">'.$value.'</span>';
				$return .= '<input class="attr form-control hb-hidden-range-input" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" />';
			$return .= '</div>';
			
			break;
			
		
		case 'mediaacess':
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return .= '<div class="hb-option-field">';
				$return .= '<label for="sc-opt-'.$name.'">'.$attr_opt['title'].' </label><br />';
			$return .= '</div>';	
			
            $return .= '<div class="hb-option-value hb-media-access">';
                
                $return .= '<input class="attr form-control" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" />';
                $return .= hb_media_access( $attr_opt['title'] );

            $return .= '</div>';
			
			break;
		
		default:
			
			$attr_opt['def'] = (isset($attr_opt['def']) && !empty($attr_opt['def'])) ? $attr_opt['def'] : '';
			
			$return  = '<div class="hb-option-field">';
				$return .= '<label for="sc-opt-'.$name.'">'.$attr_opt['title'].' </label>';
			$return .= '</div>';
			
			$return .= '<div class="hb-option-value">';
			
				$return .= '<input class="attr form-control" type="text" data-attrname="'.$name.'" value="'.$attr_opt['def'].'" />';
				
				if( isset($attr_opt['desc']) && !empty($attr_opt['desc']) ) {
					$return .= '<span class="description">'.$attr_opt['desc'].'</span>';
				}
			
			$return .= '</div>';
			
			break;
			
		}
		
		$return .= '<div class="hr"></div>';
		
		return $return;
		
	}

}


if ( !function_exists( 'hb_generate_radio_option' ) ) {

	/*
	 * Generate shortcode radio option field
	 *
	 */
	function hb_generate_radio_option( $name, $attr_opt, $type, $code ) {

		if ( ! isset($attr_opt['def']) ) $attr_opt['def'] = null;
		
		$return  = '<div class="hb-option-field">';
			$return  .= $attr_opt['title'];
		$return .= '</div>';
		
		$return .= '<div class="hb-option-value">';
			
			$return .= '<div class="btn-group" data-toggle="buttons">';
			
			foreach( $attr_opt['opt'] as $val => $title ){
				
				$return .= '<label for="sc-opt-'.$code.'-'.$name.'-'.$val.'" data-value="'.$val.'" class="btn btn-primary '.($val==$attr_opt['def']?'active':'').'">';
				$return .= '<input class="attr" type="radio" data-attrname="'.$name.'" name="'.$code.'-'.$name.'" value="'.$val.'" id="sc-opt-'.$code.'-'.$name.'-'.$val.'"'.($val==$attr_opt['def']?' checked="checked"':'').'>';
				$return .= $title;
				$return .= '</label>';						
			}
			
			$return .= '</div>';
			
			if( isset($attr_opt['desc']) && !empty($attr_opt['desc']) ) {
			
				$return .= '<span class="description">'.$attr_opt['desc'].'</span>';
			
			}
			
		$return .= '</div>';
		$return .= '<div class="hr"></div>';
		
		return $return;
		
	}
	
}


if ( !function_exists( 'hb_generate_select_option' ) ) {

	/*
	 * Generate shortcode select option field
	 *
	 */
	function hb_generate_select_option( $name, $attr_opt, $type, $code ) {
		
		/* values */
		$values = $attr_opt['values'];
		
		/* start output */
		$return  = '<div class="hb-option-field">';
			$return .= '<label for="'.$name.'">' . $attr_opt['title'] . ' </label>';
		$return .= '</div>';
			
		$return .= '<div class="hb-option-value">';
		$return .= '<select data-attrname="'.$name.'" class="form-control sc-select-control" id="'.$name.'">';
		
			$return .= '<option value="">' . __( 'Choose' , 'hb_shortcodes' ) . ' '  . $attr_opt['title'] . '</option>';
			
			foreach( $values as $value ){
				
				$return .= '<option value="'.$value.'">'.$value.'</option>';
				
			}
			
			$return .= '</select>';
			
			if( isset($attr_opt['desc']) && !empty($attr_opt['desc']) ) {
			
				$return .= '<span class="description">'.$attr_opt['desc'].'</span>';
			
			} else {
			
				$return .= '';
				
			}
		
		$return .= '</div>';
		$return .= '<div class="hr"></div>';
			
		return $return;
		
	}
	
}


if ( !function_exists( 'hb_generate_effect_option' ) ) {

	/*
	 * Generate shortcode effect select option field
	 *
	 */
	function hb_generate_effect_option( $name, $type, $code ) {
		
		/* values */
		$values = hb_recognized_animation_effects();
		
		/* start output */
		$return  = '<div class="hb-option-field">';
			$return .= '<label for="'.$name.'">' . __( 'Choose Effect' , 'hb_shortcodes' ) . ' </label>';
		$return .= '</div>';
			
		$return .= '<div class="hb-option-value">';
		$return .= '<select data-attrname="'.$name.'" class="form-control sc-select-control" id="'.$name.'">';
		
			$return .= '<option value="">' . __( 'Choose Effect' , 'hb_shortcodes' ) . '</option>';
			
			foreach( $values as $key => $value ){
				
				$return .= '<option value="'.$key.'">'.$value.'</option>';
				
			}
			
			$return .= '</select>';
			
			if( isset($attr_opt['desc']) && !empty($attr_opt['desc']) ) {
			
				$return .= '<span class="description">'.$attr_opt['desc'].'</span>';
			
			} else {
			
				$return .= '';
				
			}
		
		$return .= '</div>';
		$return .= '<div class="hr"></div>';
			
		return $return;
		
	}
	
}


if ( !function_exists( 'hb_media_access' ) ) {

	/*
	 * Media Access Button
	 *
	 */
	function hb_media_access($button_text = "Insert", $uploader_title = "Site Files", $uploader_button = "Insert", $uploader_type = ""){
		
		$button = sprintf('<a href="#" class="hb-upload-button btn btn-primary btn-sm" data-uploader_title="%s" data-uploader_button_text="%s" data-limit_type="%s"><i class="fa fa-picture fa-inverse"></i> %s</a>', $uploader_title, $uploader_button, $uploader_type, $button_text);
		return $button;
	
	}
	
}


if ( !function_exists( 'hb_generate_shortcode_box' ) ) {
	
	/*
	 * Generate shortcode boxes
	 *
	 */
	function hb_generate_shortcode_box() {
		
		$hb_shortcodes = (array) hb_recognized_shortcode_lists();
		
		$boxes   = '';
		$counter = 1;
		
		$boxes .= '<h4 class="sc-settings">'.__('Shortcode Settings' , 'hb_shortcodes').'</h4>';

		foreach( $hb_shortcodes as $code => $options ){
			
			if( $code == 'headline_'.$counter ) {
				
				$counter++;
			
			} else {
			
			$boxes .= '<div class="sc-options well" id="options-'.$code.'" data-name="'.$code.'" data-type="'.$options['type'].'">';
						
				if( isset($options['attr']) ){
																			  
					 foreach( $options['attr'] as $name => $attr_opt ){
						$boxes .= hb_get_option_element( $name, $attr_opt, $options['type'], $code );
					 }
					 
				}
			
			$boxes .= '</div>';
			
			}
				
		}
				
		return $boxes;
		
	}
	
}


/*
 * Font Icons
 *
 * Default fontawesome
 */
 
if ( !function_exists( 'hb_recognized_icons' ) ) {

    function hb_recognized_icons() {
        
        # pattern
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
        
        # file to load
        $subject = file_get_contents( hb_recognize_shortcodes_assets_url('fontawesome') );
        
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
        
        $icons = array();
        
        if( isset($matches) && is_array($matches) ) {
            foreach($matches as $match){
                $icons[] = "fa {$match[1]}";
            }
        }
        
        return apply_filters( 'hb_recognized_icons', $icons );
    } 
}

if ( !function_exists( 'hb_recognized_et_line_icons' ) ) {

    function hb_recognized_et_line_icons( $icons = array() ) {
        
        # pattern
        $pattern = '/(icon.*?):before\s+{\s*content:\s*"(.+)";\s+}/';
        
        # file to load
        $subject = file_get_contents( hb_recognize_shortcodes_assets_url('etlinefonts') );

        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $ionicons = array();

        if( isset($matches) && is_array($matches) ) {
            foreach($matches as $match){
                $ionicons[] = $match[1];
            }
        }
        return array_merge($icons, $ionicons);
    }
    add_filter('hb_recognized_icons', 'hb_recognized_et_line_icons', 5, 1);
}

if ( !function_exists( 'hb_recognized_ion_icons' ) ) {

    function hb_recognized_ion_icons( $icons = array() ) {
        
        # pattern
        $pattern = '/(ion.*?):before\s+{\s*content:\s*"(.+)";\s+}/';
        
        # file to load
        $subject = file_get_contents( hb_recognize_shortcodes_assets_url('ionicons') );

        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $ionicons = array();

        if( isset($matches) && is_array($matches) ) {
            foreach($matches as $match){
                $ionicons[] = $match[1];
            }
        }
        return array_merge($icons, $ionicons);
    }
    add_filter('hb_recognized_icons', 'hb_recognized_ion_icons', 10, 1);
}

if ( !function_exists( 'hb_recognized_glyphicon_icons' ) ) {

    function hb_recognized_glyphicon_icons( $icons = array() ) {
        
        # pattern
        $pattern = '/(glyphicon.*?):before\s+{\s*content:\s*"(.+)";\s+}/';
        
        # file to load
        $subject = file_get_contents( hb_recognize_shortcodes_assets_url('bootstrap') );

        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $glyphicon = array();

        if( isset($matches) && is_array($matches) ) {
            foreach($matches as $match){
                $glyphicon[] = "glyphicon {$match[1]}";
            }
        }
        return array_merge($icons, $glyphicon);
    }
    add_filter('hb_recognized_icons', 'hb_recognized_glyphicon_icons', 99, 1);
}