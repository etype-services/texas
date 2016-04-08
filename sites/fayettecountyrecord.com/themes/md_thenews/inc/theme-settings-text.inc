<?php

/**
 * @file
 * Theme settings .
 */

function md_thenews_theme_settings_text(&$form, &$form_state) {
	$form['md_thenews_settings']['text'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -3,
		'#prefix'  				=> '<div id="md-text-typography" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #md-text-typography -->',
	);
	
	$form['md_thenews_settings']['text']['text_htmllist'] = array(
		'#markup' 				=> '<div class="md-listleft">
				<ul>
					<li><a href="#tt-text">Text &amp; Links</a></li>
					<li><a href="#tt-typography">Typography</a></li>
				</ul>
			</div><div class="md-listcontent">',
		'#weight' 				=> -15,
	);
	
	$form['md_thenews_settings']['text']['text_htmllistclose'] = array(
		'#markup' 				=> '</div><!-- /.md-listleft -->',
		'#weight' 				=> 15,
	);
	
	/* 1.	Text & link style
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['text']['text_normal'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="tt-text" class="md-tabcontent clearfix">',
		'#suffix'        	=> '</div><!-- / #tt-text -->',
	);
		
		// Text
		$form['md_thenews_settings']['text']['text_normal']['text_style'] = array(
	        '#type' 					=> 'fieldset',
			'#prefix'  				=> '<h3>'.t('Text style').'</h3>',
	    );
		
			$form['md_thenews_settings']['text']['text_normal']['text_style']['text_font'] = array(
				'#type'          	=> 'hidden',
				'#default_value' 	=> theme_get_setting('text_font'),
				'#prefix' => '<div id="text-font" class="choosefont clearfix">',
				'#suffix' => '</div>',
			);
			
			$form['md_thenews_settings']['text']['text_normal']['text_style']['ts_font_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Color'),
				'#default_value' 	=> theme_get_setting('ts_font_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
                                            'class' => array(
                                                'form-colorpicker',
                                            ),
	            ),
			);

		// Text selection
		$form['md_thenews_settings']['text']['text_normal']['text_selection'] = array(
	    '#type' 					=> 'fieldset',
			'#prefix'  				=> '<h3>'.t('Text selection style').'</h3>',
	    );
			
			$form['md_thenews_settings']['text']['text_normal']['text_selection']['tss_bgcolor'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Background color'),
				'#default_value' 	=> theme_get_setting('tss_bgcolor'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
                                            'class' => array(
                                                'form-colorpicker',
                                            ),
	            ),
			);
			
			$form['md_thenews_settings']['text']['text_normal']['text_selection']['tss_tcolor'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Text color'),
				'#default_value' 	=> theme_get_setting('tss_tcolor'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
                                            'class' => array(
                                                'form-colorpicker',
                                            ),
	            ),
			);
			
		// Link
		$form['md_thenews_settings']['text']['text_normal']['link_style'] = array(
	    '#type' 					=> 'fieldset',
			'#prefix'  				=> '<h3>'.t('Link style').'</h3>',
			'#description'		=> t('This change will be applied to every link in your website'),
	  );
			
			$form['md_thenews_settings']['text']['text_normal']['link_style']['link_style_htmllist'] = array(
				'#markup' 				=> '<div id="md-subtabs" class="md-subtabs">
								<div class="md-subtabs-head">
		              <ul class="clearfix">
		                <li class="subtab-item clearfix first"> <a class="subtab-link" href="#link-regular">Regular</a> </li>
		                <li class="subtab-item clearfix"> <a class="subtab-link" href="#link-rollover">Rollover</a> </li>
		                <li class="subtab-item clearfix"> <a class="subtab-link" href="#link-visited">Visited</a> </li>
		                <li class="subtab-item clearfix last"> <a class="subtab-link" href="#link-on">On</a> </li>
		              </ul>
		            </div>',
				'#weight' 				=> -15,
			);
			
			$form['md_thenews_settings']['text']['text_normal']['link_style']['link_style_htmllistclose'] = array(
				'#markup' 				=> '</div><!-- /#sub-tab -->',
				'#weight' 				=> 15,
			);
			
			// Link regular
			$form['md_thenews_settings']['text']['text_normal']['link_style']['link_regular'] = array(
				'#type' 					=> 'fieldset',
				'#weight' 				=> -5,
				'#prefix'  				=> '<div id="link-regular" class="md-subtabcontent clearfix">',
				'#suffix'        => '</div><!-- / #link-regular -->',
			);
			
				md_thenews_prepare_link_style($form,'regular');
			
			// Link rollover
			$form['md_thenews_settings']['text']['text_normal']['link_style']['link_rollover'] = array(
				'#type' 					=> 'fieldset',
				'#weight' 				=> -4,
				'#prefix'  				=> '<div id="link-rollover" class="md-subtabcontent clearfix">',
				'#suffix'        => '</div><!-- / #link-rollover -->',
			);
			
				md_thenews_prepare_link_style($form,'rollover');
			
			// Link visited
			$form['md_thenews_settings']['text']['text_normal']['link_style']['link_visited'] = array(
				'#type' 					=> 'fieldset',
				'#weight' 				=> -3,
				'#prefix'  				=> '<div id="link-visited" class="md-subtabcontent clearfix">',
				'#suffix'        => '</div><!-- / #link-visited -->',
			);
			
				md_thenews_prepare_link_style($form,'visited');
			
			// Link on
			$form['md_thenews_settings']['text']['text_normal']['link_style']['link_on'] = array(
				'#type' 					=> 'fieldset',
				'#weight' 				=> -2,
				'#prefix'  				=> '<div id="link-on" class="md-subtabcontent clearfix">',
				'#suffix'        => '</div><!-- / #link-on -->',
			);
			
				md_thenews_prepare_link_style($form,'on');
	
	/* 2.	Typography
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['text']['text_typography'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="tt-typography" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #tt-typography -->',
	);
		
		// Navigation
		$form['md_thenews_settings']['text']['text_typography']['typo_navigation'] = array(
	    '#type' 					=> 'fieldset',
			'#prefix'  				=> '<h3>'.t('Navigation').'</h3>',
			'#description'		=> t('Change the navigation font.'),
	  );
		
	  	$form['md_thenews_settings']['text']['text_typography']['typo_navigation']['typo_nav_style'] = array(
				'#type'          	=> 'hidden',
				'#default_value' 	=> theme_get_setting('typo_nav_style'),
				'#prefix' => '<div id="typo-nav-style" class="choosefont clearfix">',
				'#suffix' => '</div>',
			);
			
			$form['md_thenews_settings']['text']['text_typography']['typo_navigation']['nav_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Color'),
				'#default_value' 	=> theme_get_setting('nav_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
														'class' => array(
															'form-colorpicker',
														),
	      ),
			);
			
			$form['md_thenews_settings']['text']['text_typography']['typo_navigation']['nav_hover_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Hover color'),
				'#default_value' 	=> theme_get_setting('nav_hover_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
														'class' => array(
															'form-colorpicker',
														),
	      ),
			);
			
			$form['md_thenews_settings']['text']['text_typography']['typo_navigation']['nav_active_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Active color'),
				'#default_value' 	=> theme_get_setting('nav_active_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
														'class' => array(
															'form-colorpicker',
														),
	      ),
			);

		// Page title
		$form['md_thenews_settings']['text']['text_typography']['typo_pagetitle'] = array(
	    '#type' 					=> 'fieldset',
			'#prefix'  				=> '<h3>'.t('Page title').'</h3>',
			'#description'		=> t('Change the page title font.'),
	  );
		
	  	$form['md_thenews_settings']['text']['text_typography']['typo_pagetitle']['typo_pagetitle_style'] = array(
				'#type'          	=> 'hidden',
				'#default_value' 	=> theme_get_setting('typo_pagetitle_style'),
				'#prefix' => '<div id="typo-pagetitle-style" class="choosefont clearfix">',
				'#suffix' => '</div>',
			);
			
			$form['md_thenews_settings']['text']['text_typography']['typo_pagetitle']['pagetitle_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Color'),
				'#default_value' 	=> theme_get_setting('pagetitle_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
														'class' => array(
															'form-colorpicker',
														),
	      ),
			);
		
		// Node title
		$form['md_thenews_settings']['text']['text_typography']['typo_nodetitle'] = array(
	    '#type' 					=> 'fieldset',
			'#prefix'  				=> '<h3>'.t('Node title').'</h3>',
			'#description'		=> t('Change the Node title font.'),
	  );
		
	  	$form['md_thenews_settings']['text']['text_typography']['typo_nodetitle']['typo_nodetitle_style'] = array(
				'#type'          	=> 'hidden',
				'#default_value' 	=> theme_get_setting('typo_nodetitle_style'),
				'#prefix' => '<div id="typo-nodetitle-style" class="choosefont clearfix">',
				'#suffix' => '</div>',
			);
			
			$form['md_thenews_settings']['text']['text_typography']['typo_nodetitle']['nodetitle_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Color'),
				'#default_value' 	=> theme_get_setting('nodetitle_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
														'class' => array(
															'form-colorpicker',
														),
	      ),
			);
			
			$form['md_thenews_settings']['text']['text_typography']['typo_nodetitle']['nodetitle_hover_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Hover color'),
				'#default_value' 	=> theme_get_setting('nodetitle_hover_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
														'class' => array(
															'form-colorpicker',
														),
	      ),
			);
			
		$form['md_thenews_settings']['text']['text_typography']['nodetitle_enable'] = array(
	    '#type'          => 'checkbox',
	    '#title'         => t('Use custom settings for each content type instead of the default above'),
	    '#default_value' => theme_get_setting('nodetitle_enable'),
			'#suffix'				=> '<div id="node-custom-typo">',
	  );
		
		foreach (node_type_get_types() as $type => $name) {
			$form['md_thenews_settings']['text']['text_typography']['typo_n'.$type.'title'] = array(
		    '#type' 					=> 'fieldset',
				'#prefix'  				=> '<h3>'.t('!name title', array('!name' => t($type))).'</h3>',
				'#description'		=> t('Change the '.$type.' title font.'),
		  );
				$form['md_thenews_settings']['text']['text_typography']['typo_n'.$type.'title']['typo_n'.$type.'title_style'] = array(
					'#type'          	=> 'hidden',
					'#default_value' 	=> theme_get_setting('typo_n'.$type.'title_style'),
					'#prefix' => '<div id="typo-n'.$type.'title-style" class="choosefont clearfix">',
					'#suffix' => '</div>',
				);
				
				$form['md_thenews_settings']['text']['text_typography']['typo_n'.$type.'title']['n'.$type.'title_color'] = array(
					'#type'          	=> 'textfield',
					'#title'         	=> t('Color'),
					'#default_value' 	=> theme_get_setting('n'.$type.'title_color'),
					'#prefix' => '<div class="form-font-color">',
					'#suffix' => '</div>',
					'#attributes' 		=> array(
															'class' => array(
																'form-colorpicker',
															),
		      ),
				);
				
				$form['md_thenews_settings']['text']['text_typography']['typo_n'.$type.'title']['n'.$type.'title_hover_color'] = array(
					'#type'          	=> 'textfield',
					'#title'         	=> t('Hover color'),
					'#default_value' 	=> theme_get_setting('n'.$type.'title_hover_color'),
					'#prefix' => '<div class="form-font-color">',
					'#suffix' => '</div>',
					'#attributes' 		=> array(
															'class' => array(
																'form-colorpicker',
															),
		      ),
				);
	  }
		
		$form['md_thenews_settings']['text']['text_typography']['nodetitle_enable_close'] = array(
	    '#markup' 				=> '</div>'
	  );
		
		// Block title
		$form['md_thenews_settings']['text']['text_typography']['typo_blocktitle'] = array(
	    '#type' 					=> 'fieldset',
			'#prefix'  				=> '<h3>'.t('Block title').'</h3>',
			'#description'		=> t('Change the Block title font.'),
	  );
		
	  	$form['md_thenews_settings']['text']['text_typography']['typo_blocktitle']['typo_blocktitle_style'] = array(
				'#type'          	=> 'hidden',
				'#default_value' 	=> theme_get_setting('typo_blocktitle_style'),
				'#prefix' => '<div id="typo-blocktitle-style" class="choosefont clearfix">',
				'#suffix' => '</div>',
			);
			
			$form['md_thenews_settings']['text']['text_typography']['typo_blocktitle']['blocktitle_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Color'),
				'#default_value' 	=> theme_get_setting('blocktitle_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
														'class' => array(
															'form-colorpicker',
														),
	      ),
			);
			
		// Bottom Block title
		$form['md_thenews_settings']['text']['text_typography']['typo_bblocktitle'] = array(
	    '#type' 					=> 'fieldset',
			'#prefix'  				=> '<h3>'.t('Bottom block title').'</h3>',
			'#description'		=> t('Change the bottom block title font.'),
	  );
		
	  	$form['md_thenews_settings']['text']['text_typography']['typo_bblocktitle']['typo_bblocktitle_style'] = array(
				'#type'          	=> 'hidden',
				'#default_value' 	=> theme_get_setting('typo_bblocktitle_style'),
				'#prefix' => '<div id="typo-bblocktitle-style" class="choosefont clearfix">',
				'#suffix' => '</div>',
			);
			
			$form['md_thenews_settings']['text']['text_typography']['typo_bblocktitle']['bblocktitle_color'] = array(
				'#type'          	=> 'textfield',
				'#title'         	=> t('Color'),
				'#default_value' 	=> theme_get_setting('bblocktitle_color'),
				'#prefix' => '<div class="form-font-color">',
				'#suffix' => '</div>',
				'#attributes' 		=> array(
														'class' => array(
															'form-colorpicker',
														),
	      ),
			);
}		
	

function md_thenews_prepare_link_style(&$form, $state) {
	$form['md_thenews_settings']['text']['text_normal']['link_style']['link_'.$state]['l_'.$state.'_color'] = array(
		'#type'          	=> 'textfield',
		'#title'         	=> t('Text color'),
		'#default_value' 	=> theme_get_setting('l_'.$state.'_color'),
		'#prefix' => '<div class="form-font-color">',
		'#suffix' => '</div>',
		'#attributes' 		=> array(
												'class' => array(
													'form-colorpicker',
												),
		),
	);
	
	$form['md_thenews_settings']['text']['text_normal']['link_style']['link_'.$state]['l_'.$state.'_st'] = array(
		'#type' => 'checkbox',
		'#title' =>  t('Strikethrough'),
		'#default_value' => theme_get_setting('l_'.$state.'_st'),
		'#prefix' => '<div class="form-text-effect form-item clearfix"><label class="labelleft">'.t('Text Effect').'</label><div class="form-strikethrough">', // Open div
		'#suffix' => '</div>',
	);
	
	$form['md_thenews_settings']['text']['text_normal']['link_style']['link_'.$state]['l_'.$state.'_hl'] = array(
		'#type' => 'checkbox',
		'#title' =>  t('Highlight'),
		'#default_value' => theme_get_setting('l_'.$state.'_hl'),
		'#prefix' => '<div class="form-highlight">',
		'#suffix' => '</div>',
	);
	
	$form['md_thenews_settings']['text']['text_normal']['link_style']['link_'.$state]['l_'.$state.'_hlc'] = array(
		'#type'          	=> 'textfield',
		'#default_value' 	=> theme_get_setting('l_'.$state.'_hlc'),
		'#prefix' => '<div class="form-font-color form-link-color">',
		'#suffix' => '</div></div><!-- /.form-text-effect.form-item -->',	// Close div
		'#attributes' 		=> array(
												'class' => array(
													'form-colorpicker',
												),
		),
	);

	$form['md_thenews_settings']['text']['text_normal']['link_style']['link_'.$state]['l_'.$state.'_ts'] = array(
		'#type' => 'checkboxes',
		'#title' =>  t('Text Style'),
		'#default_value' => is_array(theme_get_setting('l_'.$state.'_ts')) ? theme_get_setting('l_'.$state.'_ts') : array(),
		'#options' => drupal_map_assoc(array(t('bold'), t('italic'), t('underline'))),
		'#prefix' => '<div class="form-text-style clearfix">',
		'#suffix' => '</div>',
	);
}