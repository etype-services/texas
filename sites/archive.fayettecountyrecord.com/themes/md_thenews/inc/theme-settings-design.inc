<?php

/**
 * @file
 * Theme settings .
 */

function md_thenews_theme_settings_design(&$form, &$form_state) {
	$form['md_thenews_settings']['design'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -4,
		'#prefix'  				=> '<div id="md-design" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #md-design -->',
	);
	
	$form['md_thenews_settings']['design']['design_htmllist'] = array(
		'#markup' 				=> '<div class="md-listleft">
				<ul>
				  <li><a href="#ds-general">General</a></li>
					<li><a href="#ds-background">Background</a></li>
					<li><a href="#ds-header">Header</a></li>
					<li><a href="#ds-footer">Footer</a></li>
					<li><a href="#ds-block">Block</a></li>
				</ul>
			</div><div class="md-listcontent">',
		'#weight' 				=> -15,
	);
	$form['md_thenews_settings']['design']['design_htmllistclose'] = array(
		'#markup' 				=> '</div><!-- /.md-listleft -->',
		'#weight' 				=> 15,
	);

    /* 1.	General
	--------------------------------------------------------------------------*/
    $form['md_thenews_settings']['design']['design_general'] = array(
        '#type' 					=> 'fieldset',
        '#weight' 				=> -5,
        '#prefix'  				=> '<div id="ds-general" class="md-tabcontent clearfix">',
        '#suffix'        => '</div><!-- / #ds-general -->',
    );
        // Page box
        $form['md_thenews_settings']['design']['design_general']['design_fluid'] = array(
            '#type'          => 'checkbox',
            '#title'         => t('Enable wide for navigation & bottom'),
            '#default_value' => theme_get_setting('design_fluid'),
        );
        // Site skins
        $form['md_thenews_settings']['design']['design_general']['skins'] = array(
            '#type'          => 'select',
            '#title'         => t('Choose skin'),
            '#default_value' => theme_get_setting('skins'),
            '#options'       => array(
                '0'         => t('Default (Red)'),
                'blue' 	    => t('Blue'),
                'teal' 	    => t('Teal'),
                'green' 	  => t('Green'),
                'orange' 	  => t('Orange'),
                'magenta' 	=> t('Magenta'),
                'pink' 	    => t('Pink'),
            ),
            '#prefix' => '<div id="design-skins" class="clearfix">',
            '#suffix' => '</div>',
        );

	/* 2.	Background
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['design']['design_background'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="ds-background" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #ds-background -->',
	);
	
		// Background settings
		$form['md_thenews_settings']['design']['design_background']['bg_color'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Background-color'),
            '#default_value' => theme_get_setting('bg_color'),
                '#prefix' => '<div class="form-font-color">',
                '#suffix' => '</div>'
	    );
		
		$form['md_thenews_settings']['design']['design_background']['choose_bg'] = array(
            '#type'          => 'select',
            '#title'         => t('Choose background'),
            '#description'   => t('Choose background or choose "Custom" to upload your custom background'),
            '#default_value' => theme_get_setting('choose_bg'),
            '#options'       => array(
                                    '0'     => t('Default'),
                                    '1'		=> t('Pattern'),
                                    '2'     => t('Custom Image'),
                                ),
        );
		
		$items = array();
    $path_data_dir = drupal_get_path('theme', 'md_thenews') . '/images/texture';
		$files = file_scan_directory($path_data_dir, '/.png$/');
		$pattern_css = "";
		foreach ($files as $file) {
      $items[$file->name] = t('Pattern ' . $file->name);
			$pattern_css .= '#pt' . $file->name . ' {background:url(' . base_path() . drupal_get_path('theme', 'md_thenews') . '/images/texture/' . $file->name . '.png) repeat 0 0;}';
    }
		drupal_add_css($pattern_css, 'inline');

		$form['md_thenews_settings']['design']['design_background']['choose_pattern'] = array(
	    '#type'          => 'select',
	    '#title'         => t('Choose Pattern'),
	    '#default_value' => theme_get_setting('choose_pattern'),
	    '#options'       => $items,
			'#prefix' => '<div id="design-bg-pattern" class="clearfix">',
			'#suffix' => '</div>',
	    );
		
		$bg_path = theme_get_setting('bg_path');
		// If $bg_path is a public:// URI, display the path relative to the files directory
		if (file_uri_scheme($bg_path) == 'public') {
			$bg_path = file_uri_target($bg_path);
		}
	   
	  $form['md_thenews_settings']['design']['design_background']['bg_path'] = array(
	    '#type' => 'textfield',
	    '#title' => t('Path to custom background'),
	    '#default_value' =>  $bg_path,
			'#prefix' => '<div id="design-bg-custom" class="clearfix">',
	  );
	
	  $form['md_thenews_settings']['design']['design_background']['bg_upload'] = array(
	    '#type' => 'file',
	  );
		
		$form['md_thenews_settings']['design']['design_background']['bg_repeat'] = array(
	    '#type'          => 'select',
	    '#title'         => t('Background repeat'),
	    '#default_value' => theme_get_setting('bg_repeat'),
	    '#options'       => array(
	                          'inherit'   => t('Inherit'),
	                          'repeat'    => t('Repeat'),
														'repeat-x'  => t('Repeat X'),
														'repeat-y'  => t('Repeat Y'),
														'no-repeat' => t('No repeat'),
	                        ),
	  );
		
		$form['md_thenews_settings']['design']['design_background']['bg_position'] = array(
	    '#type'          => 'select',
	    '#title'         => t('Background position'),
	    '#default_value' => theme_get_setting('bg_position'),
	    '#options'       => array(
	                          'left top'   => t('Left Top'),
														'left center'   => t('Left Center'),
	                          'left bottom'    => t('Left Bottom'),
														'center center'  => t('Center Center'),
														'center top'  => t('Center Top'),
														'center bottom'  => t('Center Bottom'),
														'right top'  => t('Right Top'),
														'right center'  => t('Right Center'),
														'right bottom'  => t('Right Bottom'),
	                        ),
	  );
		
		$form['md_thenews_settings']['design']['design_background']['bg_attachment'] = array(
	    '#type'          => 'select',
	    '#title'         => t('Background Attachment'),
	    '#default_value' => theme_get_setting('bg_attachment'),
	    '#options'       => array(
	                          'scroll'   => t('Scroll'),
														'fixed'   => t('Fixed'),
	                        ),
			'#suffix' => '</div>',
	  );
	
	/* 3.	Header
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['design']['design_header'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="ds-header" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #ds-header -->',
	);
				
		$form['md_thenews_settings']['design']['design_header']['header_bg'] = array(
			'#type'          => 'fieldset',
			'#title'         => t('Header background'),
		);
		
			$form['md_thenews_settings']['design']['design_header']['header_bg']['header_bg_color'] = array(
					'#type'          	=> 'textfield',
					'#title'         	=> t('Background color'),
					'#default_value' 	=> theme_get_setting('header_bg_color'),
					'#prefix' => '<div class="form-font-color width155">',
					'#suffix' => '</div>',
					'#attributes' 		=> array(
															'class' => array(
																'form-colorpicker',
															),
		      ),
				);
	
	/* 4.	Footer
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['design']['design_footer'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="ds-footer" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #ds-footer -->',
	);
	
		$form['md_thenews_settings']['design']['design_footer']['footer_bg'] = array(
			'#type'          => 'fieldset',
			'#title'         => t('Footer background'),
		);
		
			$form['md_thenews_settings']['design']['design_footer']['footer_bg']['footer_bg_color'] = array(
                '#type'          	=> 'textfield',
                '#title'         	=> t('Background color'),
                '#default_value' 	=> theme_get_setting('footer_bg_color'),
                '#prefix' => '<div class="form-font-color width155">',
                '#suffix' => '</div>',
                '#attributes' 		=> array(
                                            'class' => array(
                                                'form-colorpicker',
                                            ),
                ),
			);

  $form['md_thenews_settings']['design']['design_footer']['footer_bo'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Footer border'),
    '#attributes' 		=> array(
      'class' => array(
        'form-borderstyle',
      ),
    ),
  );
      $form['md_thenews_settings']['design']['design_footer']['footer_bo']['footer_bo_type'] = array(
        '#type'          	=> 'radios',
        '#title'         	=> t('Type'),
        '#default_value' 	=> theme_get_setting('footer_bo_type'),
        '#options' => drupal_map_assoc(array(t('solid'), t('dashed'), t('dotted'), t('none'))),
        '#attributes' 		=> array(
          'class' => array(
            'form-bordertype',
          ),
        ),
      );

      $form['md_thenews_settings']['design']['design_footer']['footer_bo']['footer_bo_color'] = array(
        '#type'          	=> 'textfield',
        '#title'         	=> t('Color'),
        '#default_value' 	=> theme_get_setting('footer_bo_color'),
        '#prefix' => '<div class="form-font-color width155">',
        '#suffix' => '</div>',
        '#attributes' 		=> array(
          'class' => array(
            'form-colorpicker',
          ),
        ),
      );

			$form['md_thenews_settings']['design']['design_footer']['footer_bo']['footer_bo_size'] = array(
        '#type'          	=> 'textfield',
        '#title'         	=> t('Size'),
        '#default_value' 	=> theme_get_setting('footer_bo_size'),
      );
				


    /* 5.	Blocks
    --------------------------------------------------------------------------*/
    $form['md_thenews_settings']['design']['design_block'] = array(
        '#type' 					=> 'fieldset',
        '#weight' 				=> -5,
        '#prefix'  				=> '<div id="ds-block" class="md-tabcontent clearfix">',
        '#suffix'        => '</div><!-- / #ds-block -->',
    );

        $form['md_thenews_settings']['design']['design_block']['block_bg'] = array(
            '#type'          => 'fieldset',
            '#title'         => t('Block background'),
        );

        $form['md_thenews_settings']['design']['design_block']['block_bg']['block_title_bg_color'] = array(
            '#type'          	=> 'textfield',
            '#title'         	=> t('Title background color'),
            '#default_value' 	=> theme_get_setting('block_title_bg_color'),
            '#prefix' => '<div class="form-font-color width250">',
            '#suffix' => '</div>',
            '#attributes' 		=> array(
                'class' => array(
                    'form-colorpicker',
                ),
            ),
        );

        $form['md_thenews_settings']['design']['design_block']['block_bg']['block_title_content_space'] = array(
          '#type'          	=> 'textfield',
          '#title'         	=> t('Title & content spacing'),
          '#default_value' 	=> theme_get_setting('block_title_content_space'),
          '#prefix' => '<div class="form-font-color width250">',
          '#suffix' => '</div>',
        );

        $form['md_thenews_settings']['design']['design_block']['block_bg']['block_content_bg_color'] = array(
            '#type'          	=> 'textfield',
            '#title'         	=> t('Content background color'),
            '#default_value' 	=> theme_get_setting('block_content_bg_color'),
            '#prefix' => '<div class="form-font-color width250">',
            '#suffix' => '</div>',
            '#attributes' 		=> array(
                'class' => array(
                    'form-colorpicker',
                ),
            ),
        );

        $form['md_thenews_settings']['design']['design_block']['block_border'] = array(
          '#type'          => 'fieldset',
          '#title'         => t('Block bottom border'),
          '#attributes' 		=> array(
            'class' => array(
              'form-borderstyle',
            ),
          ),
        );
        $form['md_thenews_settings']['design']['design_block']['block_border']['block_bo_type'] = array(
          '#type'          	=> 'radios',
          '#title'         	=> t('Type'),
          '#default_value' 	=> theme_get_setting('block_bo_type'),
          '#options' => drupal_map_assoc(array(t('solid'), t('none'))),
          '#attributes' 		=> array(
            'class' => array(
              'form-bordertype',
            ),
          ),
        );

        $form['md_thenews_settings']['design']['design_block']['block_border']['block_bo_color'] = array(
          '#type'          	=> 'textfield',
          '#title'         	=> t('Color'),
          '#default_value' 	=> theme_get_setting('block_bo_color'),
          '#prefix' => '<div class="form-font-color width155">',
          '#suffix' => '</div>',
          '#attributes' 		=> array(
            'class' => array(
              'form-colorpicker',
            ),
          ),
        );

        $form['md_thenews_settings']['design']['design_block']['block_border']['block_bo_size'] = array(
          '#type'          	=> 'textfield',
          '#title'         	=> t('Size'),
          '#default_value' 	=> theme_get_setting('block_bo_size'),
        );
}