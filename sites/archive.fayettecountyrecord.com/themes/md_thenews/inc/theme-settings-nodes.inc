<?php

/**
 * @file
 * Theme settings .
 */

function md_thenews_theme_settings_nodes(&$form, &$form_state) {
	$form['md_thenews_settings']['nodes'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -2,
		'#prefix'  				=> '<div id="md-nodes" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #md-node-display -->',
	);
	
	$md_nodelist = '';
  //kpr(node_type_get_types());
	foreach (node_type_get_types() as $type => $object) {
		$md_nodelist .= '<li><a href="#n-'.$type.'">'.$object->name.'</a></li>';
	}
	
	$form['md_thenews_settings']['nodes']['nodes_htmllist'] = array(
		'#markup' 				=> '<div class="md-listleft">
				<ul><li><a href="#n-default">Default</a></li>
				'.$md_nodelist.'</ul>
			</div><div class="md-listcontent">',
		'#weight' 				=> -15,
	);
	$form['md_thenews_settings']['nodes']['nodes_htmllistclose'] = array(
		'#markup' 				=> '</div><!-- /.md-listleft -->',
		'#weight' 				=> 15,
	);
	
	$form['md_thenews_settings']['nodes']['default'] = array(
		'#type' 					=> 'fieldset',
		'#weight' 				=> -5,
		'#prefix'  				=> '<div id="n-default" class="md-tabcontent clearfix">',
		'#suffix'        => '</div><!-- / #n-default -->',
	);
	
	$form['md_thenews_settings']['nodes']['default']['node_enable'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Use custom settings for each content type instead of the default above'),
    '#default_value' => theme_get_setting('node_enable'),
  );
	
	md_thenews_prepare_node_form($form);
	
	// Node per content-type settings
  foreach (node_type_get_types() as $type => $name) {
		$form['md_thenews_settings']['nodes'][$type] = array(
			'#type' 					=> 'fieldset',
			'#title' 				=> t('!name', array('!name' => t($type))),
			'#weight' 				=> -5,
			'#prefix'  				=> '<div id="n-'.$type.'" class="md-tabcontent clearfix">',
			'#suffix'        => '</div><!-- / #n-'.$type.' -->',
		);
    md_thenews_prepare_node_form($form, $type);
  }
}

/* Node settings form */
function md_thenews_prepare_node_form(&$form, $type = 'default') {
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_position_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Share Buttons Position'),
    '#default_value' => theme_get_setting('node_share_position_' . $type),
		'#options'       => array(
                          '1'   => t('Above Content'),
                          '2' 	=> t('Below Content'),
                        ),
  );

	// Facebook
  $form['md_thenews_settings']['nodes'][$type]['node_share_facebook_' . $type] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Facebook Like Button'),
    '#default_value' => theme_get_setting('node_share_facebook_' . $type),
		'#attributes' => array(
        'class' => array(
          'node-share-checkbox',
        ),
      ),
		'#suffix'        => '<div id="div-node-share-facebook-'.$type.'-collapse" class="node-share-wrap node-share-facebook-wrap clearfix">',
  );
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_facebook_layout_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Layout style'),
    '#default_value' => theme_get_setting('node_share_facebook_layout_' . $type),
    '#options'       => array(
                          'standard'   => t('Standard'),
                          'button_count' 	=> t('Button Count'),
													'box_count'   => t('Box Count'),
                        ),
	);
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_facebook_font_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Font'),
    '#default_value' => theme_get_setting('node_share_facebook_font_' . $type),
    '#options'       => array(
                          'arial'   => t('Arial'),
                          'lucida+grande' 	=> t('Lucida Grande'),
													'segoe-ui'   => t('Segoe UI'),
													'tahoma'   => t('Tahoma'),
													'trebuchet-ms' 	=> t('Trebuchet MS'),
													'verdana'   => t('Verdana'),
                        ),
	);
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_facebook_color_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Color Scheme'),
    '#default_value' => theme_get_setting('node_share_facebook_color_' . $type),
    '#options'       => array(
                          'light'   => t('Light'),
                          'dark' 	=> t('Dark'),
                        ),
	);
	
	$form['md_thenews_settings']['nodes'][$type]['node-facebook-'.$type.'-div-closing'] = array(
    '#suffix'        => '</div>', // #div-node-collapse
  );
	
	// Twitter
  $form['md_thenews_settings']['nodes'][$type]['node_share_twitter_' . $type] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Display twitter button'),
    '#default_value' => theme_get_setting('node_share_twitter_' . $type),
		'#attributes' => array(
        'class' => array(
          'node-share-checkbox',
        ),
      ),
		'#suffix'        => '<div id="div-node-share-twitter-'.$type.'-collapse" class="node-share-wrap node-share-twitter-wrap clearfix">',
  );
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_twitter_style_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Twitter Button Style'),
    '#default_value' => theme_get_setting('node_share_twitter_style_' . $type),
    '#options'       => array(
                          'none'   => t('No count'),
                          'horizontal' 	=> t('Horizontal count'),
													'vertical'   => t('Vertical count'),
                        ),
		'#attributes' => array(
        'class' => array(
          'share-twitter',
        ),
      ),
	);
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_twitter_lang_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Twitter Button Language'),
    '#default_value' => theme_get_setting('node_share_twitter_lang_' . $type),
    '#options'       => array(
                          'en'   => t('English'),
                          'fr' 	=> t('French'),
													'de'   => t('German'),
													'it'   => t('Italian'),
													'es' 	=> t('Spanish'),
													'ko'   => t('Korean'),
													'ja'   => t('Japanese'),
                        ),
	);
	
	$form['md_thenews_settings']['nodes'][$type]['node-twitter-'.$type.'-div-closing'] = array(
    '#suffix'        => '</div>', // #div-node-collapse
  );

  // Pinterest
	//$field1 = field_info_instances('node'); print_r($field1); die();
	$form['md_thenews_settings']['nodes'][$type]['node_share_pinterest_' . $type] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Pin it button'),
    '#default_value' => theme_get_setting('node_share_pinterest_' . $type),
		'#attributes' => array(
        'class' => array(
          'node-share-checkbox',
        ),
      ),
		'#suffix'        => '<div id="div-node-share-pinterest-'.$type.'-collapse" class="node-share-wrap node-share-pinterest-wrap clearfix">',
  );
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_pinterest_layout_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Pin count'),
    '#default_value' => theme_get_setting('node_share_pinterest_layout_' . $type),
    '#options'       => array(
                          'none'   	=> t('No count'),
                          'horizontal' 		=> t('Horizontal)'),
													'vertical'  => t('Vertical'),
                        ),
		'#attributes' => array(
        'class' => array(
          'share-pinterest',
        ),
      ),
	);
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_pinterest_image_' . $type] = array(
		'#type'          	=> 'textfield',
		'#title'         	=> t('Image field'),
		'#description'			=> t('insert field machine name to get "pin" image. If your field machine name is <em>field_image</em>, type <em>image</em> here'),
		'#default_value' 	=> theme_get_setting('node_share_pinterest_image_' . $type),
	);
		
	$form['md_thenews_settings']['nodes'][$type]['node-pinterest-'.$type.'-div-closing'] = array(
    '#suffix'        => '</div>', // #div-node-collapse
  );
	// Google Plus
	$form['md_thenews_settings']['nodes'][$type]['node_share_gplus_' . $type] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Google +1 button'),
    '#default_value' => theme_get_setting('node_share_gplus_' . $type),
		'#attributes' => array(
        'class' => array(
          'node-share-checkbox',
        ),
      ),
		'#suffix'        => '<div id="div-node-share-gplus-'.$type.'-collapse" class="node-share-wrap node-share-gplus-wrap clearfix">',
  );
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_gplus_size_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Size'),
    '#default_value' => theme_get_setting('node_share_gplus_size_' . $type),
    '#options'       => array(
                          'small'   	=> t('Small (15px)'),
                          'medium' 		=> t('Medium (20px)'),
													'standard'  => t('Standard (24px)'),
													'tall'   		=> t('Tall (60px)'),
                        ),
		'#attributes' => array(
        'class' => array(
          'share-gplus',
        ),
      ),
	);
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_gplus_annotation_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Annotation'),
    '#default_value' => theme_get_setting('node_share_gplus_annotation_' . $type),
		'#options'       => array(
                          'bubble'   	=> t('bubble'),
                          'inline' 		=> t('inline'),
													'none'  		=> t('none'),
                        ),
		'#attributes' => array(
        'class' => array(
          'share-gplus-include-annotation',
        ),
      ),
  );
	
	$form['md_thenews_settings']['nodes'][$type]['node-gplus-'.$type.'-div-closing'] = array(
    '#suffix'        => '</div>', // #div-node-collapse
  );
	
	// Stumbleupon
	$form['md_thenews_settings']['nodes'][$type]['node_share_stumble_' . $type] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Stumbleupon Share Button'),
    '#default_value' => theme_get_setting('node_share_stumble_' . $type),
		'#attributes' => array(
        'class' => array(
          'node-share-checkbox',
        ),
      ),
		'#suffix'        => '<div id="div-node-share-stumble-'.$type.'-collapse" class="node-share-wrap node-share-stumble-wrap clearfix">',
  );
	
	$form['md_thenews_settings']['nodes'][$type]['node_share_stumble_style_' . $type] = array(
    '#type'          => 'select',
    '#title'         => t('Stumbleupon Button Style'),
    '#default_value' => theme_get_setting('node_share_stumble_style_' . $type),
    '#options'       => array(
                          '1'   => t('Style 1'),
                          '2' 	=> t('Style 2'),
              						'3'   => t('Style 3'),
              						'4'   => t('Style 4'),
              						'5'   => t('Style 5'),
                        ),
		'#attributes' => array(
        'class' => array(
          'share-stumble',
        ),
      ),
	);
	$form['md_thenews_settings']['nodes'][$type]['node-stumble-'.$type.'-div-closing'] = array(
    '#suffix'        => '</div>', // #div-node-collapse
  );
  
  
  $form['md_thenews_settings']['nodes']['article']['node_article_thumb'] = array(
    '#type'          => 'select',
    '#title'         => t('Thumnail Article Style'),
    '#default_value' => theme_get_setting('node_article_thumb'),
    '#options'       => array(
                          '1'   => t('Style 1'),
                          '2' 	=> t('Style 2'),
              						'3'   => t('Style 3'),
              						'4'   => t('Style 4'),
              						'5'   => t('Style 5'),
                          '6'   => t('Style 6'),
                        ),
		'#attributes' => array(
        'class' => array(
          'share-stumble',
        ),
      ),
	);
}
