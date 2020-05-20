<?php

/**
 * @file
 * Theme settings .
 */

function md_thenews_theme_settings_pages(&$form, &$form_state) {
	$form['md_thenews_settings']['pages'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -2,
		'#prefix'  				=> '<div id="md-pages" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #md-pages -->',
	);
	
	$form['md_thenews_settings']['pages']['pages_htmllist'] = array(
		'#markup' 				=> '<div class="md-listleft">
				<ul>
					<li><a href="#p-layout">Layout settings</a></li>
				</ul>
			</div><div class="md-listcontent">',
		'#weight' 				=> -15,
	);
	$form['md_thenews_settings']['pages']['pages_htmllistclose'] = array(
		'#markup' 				=> '</div><!-- /.md-listleft -->',
		'#weight' 				=> 15,
	);
	
	/* 1.	Layout settings
	--------------------------------------------------------------------------*/
	$form['md_thenews_settings']['pages']['page_layout'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="p-layout" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #p-blog -->',
	);
	
  	$form['md_thenews_settings']['pages']['page_layout']['front_page_content'] = array(
      '#type'          => 'checkbox',
      '#title'         => t('Display "promoted to front page" content and sidebar on Front page'),
      '#default_value' => theme_get_setting('front_page_content'),
    );

  	
  	$form['md_thenews_settings']['pages']['page_layout']['sidebar_position'] = array(
      '#type'          => 'select',
      '#title'         => t('Sidebar position'),
      '#default_value' => theme_get_setting('sidebar_position'),
      '#options'       => array(
                            '1'   => t('Left'),
                            '2' 	=> t('Right'),
                          ),
  	);
  	
  	$form['md_thenews_settings']['pages']['page_layout']['bottom_blocks'] = array(
      '#type'          => 'select',
      '#title'         => t('Bottom blocks'),
      '#default_value' => theme_get_setting('bottom_blocks'),
      '#options'       => array(
  													'0'   => t('Disable'),
                            '1'   => t('1 column'),
                            '2' 	=> t('2 columns'),
  													'3'   => t('3 columns'),
  													'4'   => t('4 columns'),
														'10'   => t('4 columns b'),
                          ),
  	);
  	
  	$form['md_thenews_settings']['pages']['page_layout']['node_article_display'] = array(
      '#type'          => 'select',
      '#title'         => t('Articles display'),
      '#default_value' => theme_get_setting('node_article_display'),
      '#options'       => array(
  													'1'   => t('1 column with large thumbnail'),
                            '2' 	=> t('1 column with big thumbnail'),
														'3'   => t('1 column with small thumbnail'),
  													'4'   => t('1 column with no thumbnail'),
  													'5'   => t('2 columns with big thumbnail'),
														'6'   => t('2 columns with small thumbnail'),
                          ),
  	);
  	
  	$form['md_thenews_settings']['pages']['page_layout']['node_photo_display'] = array(
      '#type'          => 'select',
      '#title'         => t('Photo page display'),
      '#default_value' => theme_get_setting('node_photo_display'),
      '#options'       => array(
                            '1'   => t('Grid 1'),
                            '2' 	=> t('Grid 2'),
  													'3'   => t('Grid 3'),
														'4'   => t('Grid 4'),
                          ),
  	);
		
		$form['md_thenews_settings']['pages']['page_layout']['node_video_display'] = array(
      '#type'          => 'select',
      '#title'         => t('Video page display'),
      '#default_value' => theme_get_setting('node_video_display'),
      '#options'       => array(
                            '1'   => t('Grid 1'),
                            '2' 	=> t('Grid 2'),
  													'3'   => t('Grid 3'),
														'4'   => t('Grid 4'),
                          ),
  	);

}