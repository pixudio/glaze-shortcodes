<?php

function hb_recognized_shortcode_lists(){

	$hb_shortcodes = array();
	$animations    = hb_recognized_animation_effects();


	#-----------------------------------------------------------------
	# Column Layouts
	#-----------------------------------------------------------------

	$hb_shortcodes['headline_1'] 	= array( 'type'  	=>	's', 
											 'title'	=>	__('Layouts', 'hb_shortcodes' ));

	$hb_shortcodes['hb_row'] 	= array( 'type'  	=>'c', 'title'=>__('Column (bootstrap row)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 'class' 	=> 	array( 	'type'  	=>	'input' , 
																						'title' 	=>	__('Optional Class','hb_shortcodes')
																					 ),
																 )
											);

	$hb_shortcodes['hb_col'] 	= array( 'type'  	=>'c', 'title'=>__('Column (bootstrap col)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'column'    => array( 'type'  => 'range'  	 , 'title'  => __('Bootstrap Col' , 'hb_shortcodes') . ' <a href="http://getbootstrap.com/css/#grid" target="_blank">'.__('Source' , 'hb_shortcodes').'</a>', 'def'=>'6', 'min' => '1', 'max' => '12', 'step' => '1', 'value' => '6') ,
											 						'offset'    => array( 'type'  => 'range'  	 , 'title'  => __('Offset' , 'hb_shortcodes'), 'def'=>'0', 'min' => '0', 'max' => '12', 'step' => '1', 'value' => '0') ,
											 						'hidetablet'=> array( 'type'  => 'radio'  	 , 'title'  => __('Hide from Tablet' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
											 						'hidemobile'=> array( 'type'  => 'radio'  	 , 'title'  => __('Hide from Mobile' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
											 						'animation'=> array( 'type'   => 'select'  	 , 'title'  => __('Animation' , 'hb_shortcodes'), 'values' => $animations ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_side_by_side'] 	= array( 'type'  	=>'c', 'title'=>__('Side By Side (wrapper)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 
											 	'class' 	=> 	array( 	'type'  	=>	'input' , 
																						'title' 	=>	__('Optional Class','hb_shortcodes')
																					 ),
																 )
											);

	$hb_shortcodes['hb_side'] 	= array( 'type'  	=>'c', 'title'=>__('Side By Side (grid / col)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	
											 						'background_color'  => array( 'type'  => 'colorpicker' , 'title' => __('Background Color (optional)' , 'hb_shortcodes')),
											 						'background'  => array( 'type'  => 'mediaacess' , 'title' => __('Background Image (optional)' , 'hb_shortcodes')),
											 						'padding'=> array( 'type'  => 'radio'  	 , 'title'  => __('Padding' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
											 						'tiny_content'=> array( 'type'  => 'radio'  	 , 'title'  => __('Add Tiny Container' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
											 						'animation'=> array( 'type'   => 'select'  	 , 'title'  => __('Animation' , 'hb_shortcodes'), 'values' => $animations ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	#-----------------------------------------------------------------
	# Elements
	#-----------------------------------------------------------------


	$hb_shortcodes['headline_2'] = array( 	'type'	=>	's', 
											'title'	=>	__('Elements', 'hb_shortcodes' ));


	$hb_shortcodes['hb_accordion'] = array( 'type'=>'m', 'title'=>__('Accordion / Toggle', 'hb_shortcodes' ), 	'attr'				  => array( 'togglegroup' => array( 'type' => 'custom' ),
																																		'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')), 
																														));


	$hb_shortcodes['hb_alert'] 	= array( 'type'  	=>'c', 'title'=>__('Alert', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'type'  => array( 'type'  => 'select' , 'title' => __('Type' , 'hb_shortcodes') , 'values' => array( "success","info","warning","danger" ) ),
											 						'dismissible'  => array( 'type'  => 'select' , 'title' => __('Dismissible' , 'hb_shortcodes') , 'values' => array( "on", "off" ) ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_ampersand'] = array( 'type'=>'s', 'title'=>__('Ampersand', 'hb_shortcodes') );


	$hb_shortcodes['hb_banner'] 	= array( 'type'  	=>'c', 'title'=>__('Banner', 'hb_shortcodes' ), 
											 'attr'  	=> array(
											 						'height'  => array( 'type'  => 'input'  	, 'title'  => __('Height' , 'hb_shortcodes') 	 , 'desc' => __('Example: 300px or 20em' , 'hb_shortcodes')), 	
											 						'background_color'  => array( 'type'  => 'colorpicker' , 'title' => __('Background Color' , 'hb_shortcodes')),
											 						'background'  => array( 'type'  => 'mediaacess' , 'title' => __('Background Image' , 'hb_shortcodes')),
											 						'text_align'     => array( 'type'  => 'radio'  	 , 'title'  => __('Text Align' , 'hb_shortcodes'), 'def'=>'center', 'opt' => array('center'=>'Center', 'right' => 'Right', 'left'=>'Left')) ,
											 						'vertical_align'     => array( 'type'  => 'radio'  	 , 'title'  => __('Vertical Align' , 'hb_shortcodes'), 'def'=>'middle', 'opt' => array('middle'=>'Middle', 'top' => 'Top', 'bottom'=>'Bottom')) ,
											 						'scheme'	=> array( 'type'  => 'radio'  	 , 'title'  => __('Scheme' , 'hb_shortcodes'), 'def'=>'dark', 'opt' => array('dark'=>'Dark', 'light' => 'Light')) ,
											 						'link'    => array( 'type'  => 'input'  	 , 'title'  => __('Link (optional)' , 'hb_shortcodes')) ,
											 						'mp4' 	=> 	array( 	'type'  	=>	'mediaacess' , 'title' 	=>	__('Video (MP4)','hb_shortcodes')),
											 						'webm' 	=> 	array( 	'type'  	=>	'mediaacess' , 'title' 	=>	__('Video (WebM)','hb_shortcodes')),
											 						'ogg' 	=> 	array( 	'type'  	=>	'mediaacess' , 'title' 	=>	__('Video (OGG)','hb_shortcodes')),
											 						'video_ratio'     => array( 'type'  => 'radio'  	 , 'title'  => __('Text Align' , 'hb_shortcodes'), 'def'=>'horizontal', 'opt' => array('horizontal'=>'Horizontal', 'vertical' => 'Vertical')) ,
											 						'class' 	=> array( 'type'  => 'input' 	 , 'title' 	=> __('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_blockquote'] 	= array( 'type'  	=>'c', 'title'=>__('Blockquote', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'author'    => array( 'type'  => 'input'  	 , 'title'  => __('Author' , 'hb_shortcodes')) ,
											 						'cite'    	=> array( 'type'  => 'input'  	 , 'title'  => __('Cite' , 'hb_shortcodes')) ,
											 						'frame'     => array( 'type'  => 'radio'  	 , 'title'  => __('Frame' , 'hb_shortcodes'), 'def'=>'default', 'opt' => array('default'=>'Default', 'double' => 'Double', 'dashed'=>'Dashed')) ,
											 						'reverse'	=> array( 'type'  => 'radio'  	 , 'title'  => __('Reverse' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
											 						'class' 	=> array( 'type'  => 'input' 	 , 'title' 	=> __('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_button'] 	= array( 'type'  	=>'c', 'title'=>__('Button', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'href'    => array( 'type'  => 'input'  	 , 'title'  => __('Link' , 'hb_shortcodes')),
											 						'type'  => array( 'type'  => 'select' , 'title' => __('Type' , 'hb_shortcodes') , 'values' => array( "default","primary","success","info","warning","danger","link" ) ),
											 						'size'  => array( 'type'  => 'select' , 'title' => __('Size' , 'hb_shortcodes') , 'values' => array( "default","large","small","extrasmall" ) ),
											 						'icon'      		  => array( 'type'  => 'icon'   , 'title'  => __('Icon' , 'hb_shortcodes')) ,
											 						'target'  => array( 'type'  => 'select' , 'title' => __('Target (optional)' , 'hb_shortcodes') , 'values' => array( "_self", "_blank" ) ),
											 						'block'  => array( 'type'  => 'select' , 'title' => __('Block (optional)' , 'hb_shortcodes') , 'values' => array( "on", "off" ) ),
											 						'active'  => array( 'type'  => 'select' , 'title' => __('Active (optional)' , 'hb_shortcodes') , 'values' => array( "on", "off" ) ),
											 						'disabled'  => array( 'type'  => 'select' , 'title' => __('Disabled (optional)' , 'hb_shortcodes') , 'values' => array( "on", "off" ) ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_callout'] 	= array( 'type'  	=>'c', 'title'=>__('Callout', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'title'    => array( 'type'  => 'input'  	 , 'title'  => __('Title' , 'hb_shortcodes')),
											 						'subtitle'    => array( 'type'  => 'input'  	 , 'title'  => __('Subtitle' , 'hb_shortcodes')),
											 						'image'  => array( 'type'  => 'mediaacess' , 'title' => __('Image' , 'hb_shortcodes')),
											 						'btn_label'    => array( 'type'  => 'input'  	 , 'title'  => __('Button Label' , 'hb_shortcodes')),
											 						'Link'    => array( 'type'  => 'input'  	 , 'title'  => __('Link' , 'hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_client_group'] = array( 'type'=>'m', 'title'=>__('Clients', 'hb_shortcodes' ), 								
																	'attr'				  => array( 'clientgroup'   => array( 'type'  => 'custom' ),
																	'class'     		  => array( 'type'          => 'input'  , 'title'  => __('Optional Class','hb_shortcodes'))
	));


	$hb_shortcodes['hb_countup'] 	= array( 'type'  	=>'c', 'title'=>__('Count Up', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'target'    => array( 'type'  => 'input'  	 , 'title'  => __('Target' , 'hb_shortcodes')),
											 						'icon'   => array( 'type'  => 'icon'   , 'title'  => __('Icon' , 'hb_shortcodes')) ,
											 						'shape'    => array( 'type'  => 'select'  	 , 'title'  => __('Shape' , 'hb_shortcodes') , 'values' => array( "round", "square" ) ),
											 						'size'    => array( 'type'  => 'select'  	 , 'title'  => __('Size' , 'hb_shortcodes') , 'values' => array( "small", "medium", "large" ) ),
											 						'effect'    => array( 'type'  => 'select'  	 , 'title'  => __('Effect' , 'hb_shortcodes') , 'values' => array( "none", "1a", "1b", "2a", "2b", "3a", "3b", "4a", "4b", "5a", "5b", "5c", "5d", "6", "7a", "7b", "8", "9a", "9b" ) ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_description'] = array( 'type'=>'c', 'title'=>__('Description', 'hb_shortcodes'), 'attr'=>array( 'style' 		=> array( 'type'=>'radio' , 'title'=>'Style', 'def'=>'default', 'opt' => array('default' => 'Default', 'fancy-font'=>'Fancy Font', 'h6' => 'Headline')),
																											   'class'      => array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') )
																												));


	$hb_shortcodes['hb_dropcap'] = array( 'type'=>'c', 'title'=>__('Dropcap', 'hb_shortcodes'), 'attr'=>array( 'style' 		=> array( 'type'=>'radio' , 'title'=>'Style', 'def'=>'one', 'opt' => array('one'=>'Style One', 'two' => 'Style Two', 'three' => 'Style Three')),
																												'size' 		=> array( 'type'=>'radio' , 'title'=>'Size', 'def'=>'medium', 'opt' => array('small'=>'Small', 'medium' => 'Medium', 'large' => 'Large')),
																											   'class'      => array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') )
																												));


	$hb_shortcodes['hb_headline'] 	= array( 'type'  	=>'c', 'title'=>__('Fancy Headline', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'style'  => array( 'type'  => 'select' , 'title' => __('Style' , 'hb_shortcodes') , 'values' => array( "span", "justify", "underline", "underline-center" ) ),
											 						'skin'  => array( 'type'  => 'select' , 'title' => __('Skin' , 'hb_shortcodes') , 'values' => array( "dark","light" ) ),
											 						'tag'  => array( 'type'  => 'select' , 'title' => __('Tag' , 'hb_shortcodes') , 'values' => array( "h1", "h2", "h3", "h4", "h5", "h6" ) ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

		
	$hb_shortcodes['hb_fancy_list'] = array( 'type'  => 'm', 'title' => __('Fancy List', 'hb_shortcodes' ), 'attr' 	=> array( 'fancyli' => array( 'type'  => 'custom' )));


	$hb_shortcodes['hb_hr'] = array( 'type'=>'s', 'title'=>__('HR', 'hb_shortcodes'), 'attr'=>array( 'style' 		=> array( 'type'=>'radio' , 'title'=>'Style', 'def'=>'default', 'opt' => array('default'=>'Default', 'gradient' => 'Gradient', 'dotted' => 'Dotted', 'dashed' => 'Dashed', 'double' => 'Double', 'stroke' => 'Stroke')),
																											   'class'      => array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') )
																												));


	$hb_shortcodes['hb_icon'] = array( 'type'=>'s', 'title'=>__('Icon', 'hb_shortcodes'), 'attr'=>array( 
								'icon' 		=> array( 'type'=>'icon' , 'title'=>__('Icon' , 'hb_shortcodes')),
								'size'  	=> array( 'type'  => 'select' , 'title' => __('Size' , 'hb_shortcodes') , 'values' => array( "Inherit", "Large", "2xLarge", "3xLarge", "4xLarge", "5xLarge" ) ),
								'color'  	=> array( 'type'  => 'colorpicker' , 'title' => __('Color (optional)' , 'hb_shortcodes')),
							    'class'     => array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') )
								));

	$hb_shortcodes['hb_icon_box'] 	= array( 'type'  	=>'c', 'title'=>__('Icon Box', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'icon'   => array( 'type'  => 'icon'   , 'title'  => __('Icon' , 'hb_shortcodes')) ,
											 						'type'  => array( 'type'  => 'select' , 'title' => __('Type' , 'hb_shortcodes') , 'values' => array( "horizontal", "vertical" ) ),
											 						'shape'    => array( 'type'  => 'select'  	 , 'title'  => __('Shape' , 'hb_shortcodes') , 'values' => array( "round", "square" ) ),
											 						'icon_align'    => array( 'type'  => 'select'  	 , 'title'  => __('Icon Align' , 'hb_shortcodes') , 'values' => array( "left", "right", "center" ) ),
											 						'content_align'    => array( 'type'  => 'select'  	 , 'title'  => __('Content Align' , 'hb_shortcodes') , 'values' => array( "left", "right", "center" ) ),
											 						'size'    => array( 'type'  => 'select'  	 , 'title'  => __('Size' , 'hb_shortcodes') , 'values' => array( "small", "medium", "large" ) ),
											 						'effect'    => array( 'type'  => 'select'  	 , 'title'  => __('Effect' , 'hb_shortcodes') , 'values' => array( "none", "1a", "1b", "2a", "2b", "3a", "3b", "4a", "4b", "5a", "5b", "5c", "5d", "6", "7a", "7b", "8", "9a", "9b" ) ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_instagram_feed'] = array( 'type'=>'s', 'title'=>__('Instagram Feed', 'hb_shortcodes'), 'attr'=>array( 
		'count'    		=> array( 'type'  => 'range'  	 , 'title'  => __('Count' , 'hb_shortcodes'), 'def'=>'6', 'min' => '1', 'max' => '20', 'step' => '1', 'value' => '6') ,
		'type'			=> array( 'type'  => 'radio'  	 , 'title'  => __('Type' , 'hb_shortcodes'), 'def'=>'grid', 'opt' => array('grid'=>'Grid', 'carousel' => 'Carousel')) ,
		'gutter'		=> array( 'type'  => 'radio'  	 , 'title'  => __('Gutter' , 'hb_shortcodes'), 'def'=>'1', 'opt' => array('1'=>'On', '0' => 'Off')) ,
		'dots'		=> array( 'type'  => 'radio'  	 , 'title'  => __('Dots (only carousel)' , 'hb_shortcodes'), 'def'=>'1', 'opt' => array('1'=>'On', '0' => 'Off')) ,
		'class'      	=> array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') )
																												));


	$hb_shortcodes['hb_map'] 	= array( 'type'  	=>'c', 'title'=>__('Map', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'lat'    => array( 'type'  => 'input'  	 , 'title'  => __('Latitude' , 'hb_shortcodes')) ,
											 						'lng'    	=> array( 'type'  => 'input'  	 , 'title'  => __('Longitude' , 'hb_shortcodes')) ,
											 						'zoom'    => array( 'type'  => 'range'  	 , 'title'  => __('Zoom' , 'hb_shortcodes'), 'def'=>'8', 'min' => '1', 'max' => '20', 'step' => '1', 'value' => '8') ,
											 						'ratio'    => array( 'type'  => 'range'  	 , 'title'  => __('Ratio' , 'hb_shortcodes'), 'def'=>'0.5', 'min' => '0.2', 'max' => '2', 'step' => '0.1', 'value' => '0.5') ,
											 						'class' 	=> array( 'type'  => 'input' 	 , 'title' 	=> __('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_panel'] 	= array( 'type'  	=>'c', 'title'=>__('Panel', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'title'  => array( 'type'  => 'input' , 'title' => __('Title' , 'hb_shortcodes')),
											 						'subtitle'  => array( 'type'  => 'input' , 'title' => __('Subtitle (optional)' , 'hb_shortcodes')),
											 						'animation'=> array( 'type'   => 'select'  	 , 'title'  => __('Animation' , 'hb_shortcodes'), 'values' => $animations ),
											 						'panel_background_color'  => array( 'type'  => 'colorpicker' , 'title' => __('Panel Background Color (optional)' , 'hb_shortcodes')),
											 						'panel_background_image'  => array( 'type'  => 'mediaacess' , 'title' => __('Panel Background Image (optional)' , 'hb_shortcodes')),
											 						'sidebox_background_image'  => array( 'type'  => 'mediaacess' , 'title' => __('Sidebox Background Image (optional)' , 'hb_shortcodes')),
											 						'align' 		  	 	  => array( 'type'  => 'select' , 'title'  => __('Align' , 'hb_shortcodes') , 'values' => array( "left" , "right") ),
											 						'panel_padding' 	  => array( 'type'  => 'select' , 'title'  => __('Panel Padding' , 'hb_shortcodes') , 'values' => array( "on" , "off") ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_posts'] 	= array( 'type'  	=>'s', 'title'=>__('Posts (list)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'count'    => array( 'type'  => 'range'  	 , 'title'  => __('Count' , 'hb_shortcodes'), 'def'=>'6', 'min' => '-1', 'max' => '20', 'step' => '1', 'value' => '6') ,
											 						'cat' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Categories (optional)','hb_shortcodes'), 'desc' => __('Enter Category IDs (Separate ids with commas)' , 'hb_shortcodes')),
											 						'more_posts' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('More Posts Button Label (optional)','hb_shortcodes')),
											 						'more_posts_link' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('More Posts Button Link (optional)','hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_post_carousel'] 	= array( 'type'  	=>'s', 'title'=>__('Posts (carousel)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'count'    => array( 'type'  => 'range'  	 , 'title'  => __('Count' , 'hb_shortcodes'), 'def'=>'6', 'min' => '-1', 'max' => '20', 'step' => '1', 'value' => '6') ,
											 						'cat' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Categories (optional)','hb_shortcodes'), 'desc' => __('Enter Category IDs (Separate ids with commas)' , 'hb_shortcodes')),
											 						'dots'  => array( 'type'  => 'select' , 'title' => __('Dots' , 'hb_shortcodes') , 'values' => array( "active","deactivate" ) ),
											 						'margin'  => array( 'type'  => 'select' , 'title' => __('Margin' , 'hb_shortcodes') , 'values' => array( "active","deactivate" ) ),
											 						'stage'  => array( 'type'  => 'select' , 'title' => __('Stage View' , 'hb_shortcodes') , 'values' => array( "active","deactivate" ) ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_pricing'] 	= array( 'type'  	=>'s', 'title'=>__('Pricing', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'id' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('ID','hb_shortcodes') ),
											 						'name' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Name','hb_shortcodes') ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_progress'] 	= array( 'type'  	=>'s', 'title'=>__('Progress Bar', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'goal' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Goal (number)','hb_shortcodes') ),
											 						'label' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Label','hb_shortcodes') ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_service_big_title'] 	= array( 'type'  	=>'c', 'title'=>__('Services (big title / no icon)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'title'  => array( 'type'  => 'input' , 'title' => __('Title' , 'hb_shortcodes')),
											 						'link'  => array( 'type'  => 'input' , 'title' => __('Link (optional)' , 'hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_service_box_icon'] 	= array( 'type'  	=>'c', 'title'=>__('Services (box icon)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'title'  => array( 'type'  => 'input' , 'title' => __('Title' , 'hb_shortcodes')),
											 						'icon'  => array( 'type'  => 'icon' , 'title' => __('Icon' , 'hb_shortcodes')),
											 						'subtitle'  => array( 'type'  => 'input' , 'title' => __('Subitle (optional)' , 'hb_shortcodes')),
											 						'link'  => array( 'type'  => 'input' , 'title' => __('Link (optional)' , 'hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
											 						'box_shadow'	=> array( 'type'  => 'radio'  	 , 'title'  => __('Box Shadow' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
																 )
											);


	$hb_shortcodes['hb_service_box_image'] 	= array( 'type'  	=>'c', 'title'=>__('Services (box image)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'title'  => array( 'type'  => 'input' , 'title' => __('Title' , 'hb_shortcodes')),
											 						'image'  => array( 'type'  => 'mediaacess' , 'title' => __('Image' , 'hb_shortcodes')),
											 						'subtitle'  => array( 'type'  => 'input' , 'title' => __('Subitle (optional)' , 'hb_shortcodes')),
											 						'btn_label'  => array( 'type'  => 'input' , 'title' => __('Button Label (optional)' , 'hb_shortcodes')),
											 						'link'  => array( 'type'  => 'input' , 'title' => __('Link (optional)' , 'hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
											 						'box_shadow'	=> array( 'type'  => 'radio'  	 , 'title'  => __('Box Shadow' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
																 )
											);


	$hb_shortcodes['hb_service_custom_icon'] 	= array( 'type'  	=>'c', 'title'=>__('Services (custom icon)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'title'  => array( 'type'  => 'input' , 'title' => __('Title' , 'hb_shortcodes')),
											 						'icon'  => array( 'type'  => 'mediaacess' , 'title' => __('Custom Icon (160x160px)' , 'hb_shortcodes')),
											 						'btn_label'  => array( 'type'  => 'input' , 'title' => __('Button Label (optional)' , 'hb_shortcodes')),
											 						'link'  => array( 'type'  => 'input' , 'title' => __('Link (optional)' , 'hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_space'] = array( 'type'=>'s', 'title'=>__('Spacer', 'hb_shortcodes'), 'attr'=>array( 'height' 		 => array( 'type'  => 'input'  	, 'title'  => __('Height' , 'hb_shortcodes') 	 , 'desc' => __('Example: 30px or 2em' , 'hb_shortcodes') ) ,
																												));



	$hb_shortcodes['hb_tabpanel'] = array( 'type'=>'m', 'title'=>__('Tabs', 'hb_shortcodes' ), 										'attr'				  => array( 'tabgroup'  => array( 'type' => 'custom' ),
																																		'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')), 
																														));


	$hb_shortcodes['hb_team'] = array( 'type'=>'s', 'title'=>__('Team Member', 'hb_shortcodes'),
											 'attr'  	=> array( 	
											 						'id'    	=> array( 'type'  => 'input'  	 , 'title'  => __('ID' , 'hb_shortcodes')) ,
											 						'name'    	=> array( 'type'  => 'input'  	 , 'title'  => __('Name' , 'hb_shortcodes')) ,
											 						'link2page'=> array( 'type'  => 'radio'  	 , 'title'  => __('Link to Single Page' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
	 );

	$hb_shortcodes['hb_testimonial'] = array( 'type'=>'m', 'title'=>__('Testimonial', 'hb_shortcodes' ), 		'attr'				  => array( 'quoterotator' => array( 'type'  => 'custom' ),
																	'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
	));


	$hb_shortcodes['hb_twitter_feed'] = array( 'type'=>'s', 'title'=>__('Twitter Feed', 'hb_shortcodes'), 'attr'=>array( 
																	'count'    		=> array( 'type'  => 'range'  	 , 'title'  => __('Count' , 'hb_shortcodes'), 'def'=>'6', 'min' => '1', 'max' => '20', 'step' => '1', 'value' => '6') ,
																	'class'      	=> array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') 
																)
	));


	$hb_shortcodes['hb_video_popup_btn'] = array( 'type'=>'s', 'title'=>__('Video Popup, Button (Youtube / Vimeo)', 'hb_shortcodes'), 'attr'=>array( 
																	'url'    	 	=> array( 'type'  => 'input'  	 , 'title'  => __('URL' , 'hb_shortcodes')) ,
																	'label'    	 	=> array( 'type'  => 'input'  	 , 'title'  => __('Button Label' , 'hb_shortcodes')) ,
																	'class'      	=> array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') 
																)
	));


	$hb_shortcodes['hb_video_popup_img'] = array( 'type'=>'s', 'title'=>__('Video Popup, Image (Youtube / Vimeo)', 'hb_shortcodes'), 'attr'=>array( 
																	'url'    	 	=> array( 'type'  => 'input'  	 , 'title'  => __('URL' , 'hb_shortcodes')) ,
																	'cover_image'   => array( 'type'  => 'mediaacess' , 'title' => __('Cover Image' , 'hb_shortcodes')),
																	'class'      	=> array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') 
																)
	));


	$hb_shortcodes['hb_video'] = array( 'type'=>'s', 'title'=>__('Video Responsive (Youtube / Vimeo)', 'hb_shortcodes'), 'attr'=>array( 
																	'url'    	 	=> array( 'type'  => 'input'  	 , 'title'  => __('URL' , 'hb_shortcodes')) ,
																	'ratio'  		=> array( 'type'  => 'select' , 'title' => __('Ratio' , 'hb_shortcodes') , 'values' => array( "16x9","4x3" ) ),
																	'class'      	=> array( 'type'  => 'input'  	 , 'title'  => __('Optional Class','hb_shortcodes') 
																)
	));


	$hb_shortcodes['hb_works'] 	= array( 'type'  	=>'c', 'title'=>__('Works', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'count'    => array( 'type'  => 'range'  	 , 'title'  => __('Count' , 'hb_shortcodes'), 'def'=>'6', 'min' => '-1', 'max' => '20', 'step' => '1', 'value' => '6') ,
											 						'group' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Group (optional)','hb_shortcodes'), 'desc' => __('Enter Work Groups ID (Separate ids with commas)' , 'hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);


	$hb_shortcodes['hb_work_carousel'] 	= array( 'type'  	=>'s', 'title'=>__('Works (carousel)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'count'    => array( 'type'  => 'range'  	 , 'title'  => __('Count' , 'hb_shortcodes'), 'def'=>'6', 'min' => '-1', 'max' => '20', 'step' => '1', 'value' => '6') ,
											 						'group' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Group (optional)','hb_shortcodes'), 'desc' => __('Enter Work Groups ID (Separate ids with commas)' , 'hb_shortcodes')),
											 						'dots'  => array( 'type'  => 'select' , 'title' => __('Dots' , 'hb_shortcodes') , 'values' => array( "active","deactivate" ) ),
											 						'margin'  => array( 'type'  => 'select' , 'title' => __('Margin' , 'hb_shortcodes') , 'values' => array( "active","deactivate" ) ),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_works_grid'] 	= array( 'type'  	=>'s', 'title'=>__('Works (grid)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'count'    => array( 'type'  => 'range'  	 , 'title'  => __('Count' , 'hb_shortcodes'), 'def'=>'6', 'min' => '-1', 'max' => '20', 'step' => '1', 'value' => '6') ,
											 						'columns'    => array( 'type'  => 'range'  	 , 'title'  => __('Columns' , 'hb_shortcodes'), 'def'=>'3', 'min' => '2', 'max' => '4', 'step' => '1', 'value' => '3') ,
											 						'filter'  => array( 'type'  => 'select' , 'title' => __('Filter' , 'hb_shortcodes') , 'values' => array( "active","deactivate" ) ),
											 						'group' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Group (optional)','hb_shortcodes'), 'desc' => __('Enter Work Groups ID (Separate ids with commas)' , 'hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	$hb_shortcodes['hb_works_masonry'] 	= array( 'type'  	=>'s', 'title'=>__('Works (masonry)', 'hb_shortcodes' ), 
											 'attr'  	=> array( 	'count'    => array( 'type'  => 'range'  	 , 'title'  => __('Count' , 'hb_shortcodes'), 'def'=>'6', 'min' => '-1', 'max' => '20', 'step' => '1', 'value' => '6') ,
											 						'group' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Group (optional)','hb_shortcodes'), 'desc' => __('Enter Work Groups ID (Separate ids with commas)' , 'hb_shortcodes')),
											 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
																 )
											);

	return apply_filters('hb_recognized_shortcode_lists', $hb_shortcodes);
}