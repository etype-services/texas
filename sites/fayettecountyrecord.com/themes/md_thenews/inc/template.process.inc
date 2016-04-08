<?php
/**
 * Add body classes if certain regions have content.
 */
function md_thenews_preprocess_html(&$vars) {
	$css = "";
	if (!empty($vars['page']['headlines'])) {
		drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jPages.min.js');
		$headline_pager = theme_get_setting('headlines_pager')? theme_get_setting('headlines_pager') : 5;
		$headlines_js = '(function ($) {	$(function(){
		$("#headlines .holder").jPages({
      containerID : "hlitemContainer",
      perPage     : ' . $headline_pager . ',
      first       : false,
      previous    : false,
      next        : false,
      last        : false
    });;
	}); })(jQuery);';
		drupal_add_js($headlines_js, "inline");
		$css .= '#hlitemContainer li:nth-child(' . $headline_pager . 'n+' . $headline_pager . ') {border: none;}';
	}

	drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jquery.cycle2.min.js');
  drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/owl.carousel.min.js');
	drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jquery.cycle2.carousel.js');
	drupal_add_js('jQuery.fn.cycle.defaults.autoSelector = \'.mdslideshow\';', "inline");
	drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/script.js');

	// remove no-sidebars class
	if ($index = array_search('no-sidebars', $vars['classes_array'])) {
    unset($vars['classes_array'][$index]);
  }

	if (theme_get_setting('extra_page_classes')) {
    if (function_exists('locale')) {
      $vars['classes_array'][] = 'lang-'. $vars['language']->language;
    }
  }
  if (theme_get_setting('extra_page_classes') == 0) {
    foreach($vars['classes_array'] as $i =>$class) {
      if(preg_match('/page*/', $class)) {
        unset($vars['classes_array'][$i]);
      }
    }
  }

	if (empty($vars['page']['sidebar']) && empty($vars['page']['sidebar_col1']) && empty($vars['page']['sidebar_col2'])  && empty($vars['page']['sidebar_bottom'])) {
    $vars['classes_array'][] = 'no-sidebars';
  }

	// Sidebar position
	switch (theme_get_setting('sidebar_position')) {
		case 1:
			$vars['classes_array'][] = 'sidebar-left';
			break;
		case 2:
			$vars['classes_array'][] = 'sidebar-right';
			break;
	}
	// Bottom blocks
	switch (theme_get_setting('bottom_blocks')) {
    case 0:
			break;
    case 1:
			$vars['classes_array'][] = 'bottom-1columns';
			break;
    case 2:
			$vars['classes_array'][] = 'bottom-2columns';
			break;
		case 3:
			$vars['classes_array'][] = 'bottom-3columns';
			break;
    case 4:
			$vars['classes_array'][] = 'bottom-4columns';
			break;
		case 8:
			$vars['classes_array'][] = 'bottom-4columnsb';
			break;
	}

	if (!empty($vars['page']['footer_firstcolumn'])
    || !empty($vars['page']['footer_secondcolumn'])
    || !empty($vars['page']['footer_thirdcolumn'])
    || !empty($vars['page']['footer_fourthcolumn'])) {
    $vars['classes_array'][] = 'footer-columns';
  }

	// Custom Background

	if (theme_get_setting('choose_bg') == 2) {
		$bg_path = theme_get_setting('bg_path');
		$css .= "body {";
		if ($bg_path) {
      $filescheme = file_uri_scheme($bg_path);
			if ($filescheme == 'public') {
				$css .= "background-image:url(". file_create_url($bg_path) .");\n";
			} else if (($filescheme == 'http') || ($filescheme == 'https')) {
				$css .= "background-image:url(". $bg_path .");\n";
			} else {
				$css .= "background-image:url(". file_create_url(file_build_uri($bg_path)) .");\n";
			}
			if (theme_get_setting('bg_repeat')) {$css .= "background-repeat:". theme_get_setting('bg_repeat').";\n";}
			if (theme_get_setting('bg_attachment')) {$css .= "background-attachment:". theme_get_setting('bg_attachment').";\n";}
			if (theme_get_setting('bg_position')) {$css .= "background-position:". theme_get_setting('bg_position') .";\n";}
		}
    if (theme_get_setting('bg_color')) {
			$css .= "background-color:#".theme_get_setting('bg_color').";\n";
			if (!$bg_path) { $css .= "background-image: none;\n"; }
		}
	  $css .= "}";
	} elseif (theme_get_setting('choose_bg') == 1) {
		$bg_color = '';
		if (theme_get_setting('bg_color'))
			$bg_color = ' #' . theme_get_setting('bg_color');
		$css = "body {background:url(" . base_path() . drupal_get_path('theme', 'md_thenews') ."/images/texture/". theme_get_setting('choose_pattern') . ".png)" . $bg_color . " repeat left top;}\n";
	}

	// Superfish menu
	if (!empty($vars['page']['superfish'])) {
		drupal_add_css(drupal_get_path('theme', 'md_thenews') . '/css/superfish.css');
        $vars['classes_array'][] = 'nav-superfish';
  }

	/* Design
	---------------------------------------------------------------------------------------- */
  // Design general
  if (!theme_get_setting('design_fluid')) {
      $vars['classes_array'][] = 'design-box';
  }
  // Skin
  if (theme_get_setting('skins') != '0') {
    drupal_add_css(drupal_get_path('theme', 'md_thenews') . '/css/colors/'.theme_get_setting('skins').'.css', array('group' => CSS_THEME));
  }

	if (theme_get_setting('header_bg_color')) {
		$css .= '#header {background-color: #'.theme_get_setting('header_bg_color').';}';
	}
  // Design footer
	if (theme_get_setting('footer_bg_color')) {
		$css .= '#bottom, #footer {background-color: #'.theme_get_setting('footer_bg_color').';}';
	}
  if (theme_get_setting('footer_bo_type')) {
    $css .= '#footer {border-top-style: '.theme_get_setting('footer_bo_type').';}';
  }
	if (theme_get_setting('footer_bo_color')) {
		$css .= '#footer {border-top-color: #'.theme_get_setting('footer_bo_color').';}';
	}
	if (theme_get_setting('footer_bo_size')) {
		$css .= '#footer {border-top-width: '.theme_get_setting('footer_bo_size').'px;}';
	}
  // Design block
  if (theme_get_setting('block_title_bg_color')) {
    $css .= '.block h3.block-title {background-color: #'.theme_get_setting('block_title_bg_color').';}';
  }
  if (theme_get_setting('block_title_content_space')) {
    $css .= '.block h3.block-title {margin-bottom: '.theme_get_setting('block_title_content_space').'px;}';
  }
  if (theme_get_setting('block_content_bg_color')) {
    $css .= '.blcontent {background-color: #'.theme_get_setting('block_content_bg_color').';}';
  }
  if (theme_get_setting('block_bo_type')) {
    $css .= '.blcontent {border-bottom-style: '.theme_get_setting('block_bo_type').';}';
  }
  if (theme_get_setting('block_bo_color')) {
    $css .= '.blcontent {border-bottom-color: #'.theme_get_setting('block_bo_color').';}';
  }
  if (theme_get_setting('block_bo_size')) {
    $css .= '.blcontent {border-bottom-width: '.theme_get_setting('block_bo_size').'px;}';
  }

   $vars['theme_setting_css'] = $css;

	// Custom Web clip
	$webclip_path = theme_get_setting('webclip_path');
	if ($webclip_path) {
    $wc_href = "";
		if (file_uri_scheme($webclip_path) == 'public') {
			$wc_href = file_create_url($webclip_path);
		} else {
			$wc_href = file_create_url(file_build_uri($webclip_path));
		}

		$wc_rel = "apple-touch-icon";
	  if (theme_get_setting('webclip_precomp')) { // no output if $url_precomp = ''
	    $wc_rel = "apple-touch-icon-precomposed";
	  }
		$wc = array(
			'#tag' => 'link',
			'#attributes' => array(
				'href' => $wc_href,
				'rel' => $wc_rel,
				'type' => file_get_mimetype($wc_href),
			),
		);
		drupal_add_html_head($wc, 'webclip');
	}

	// Enable Responsive
	if (theme_get_setting('responsive')) {
    drupal_add_css(drupal_get_path('theme', 'md_thenews') . '/css/media-queries.css', array('group' => CSS_THEME));
    drupal_add_js(drupal_get_path('theme', 'md_thenews') . '/js/jquery.cbFlyout.js');
		$vp = array(
          '#type' => 'html_tag',
          '#tag' => 'meta',
          '#attributes' => array(
            'name' =>  'viewport',
            'content' =>  'width=100%, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no'
          )
        );
        drupal_add_html_head($vp, 'viewport');
	}

	/* Enable custom font
	---------------------------------------------------------------------------------------- */
	// Google web fonts
	if (theme_get_setting('googlewebfonts')) {
		$googlewebfonts = theme_get_setting('googlewebfonts');
		if (strpos($googlewebfonts, '@import url(') !== FALSE) {
			preg_match("/http:\/\/\s?[\'|\"]?(.+)[\'|\"]?\s?(\)|\')/Uix", $googlewebfonts, $ggwflink);
			$googlewebfonts = 'http://'.$ggwflink[1];
		}
		drupal_add_css($googlewebfonts, 'external');
	}
	// Typekit
	if (theme_get_setting('typekit_id')) {
		drupal_add_js('http://use.typekit.net/'.theme_get_setting('typekit_id').'.js', 'external');
		drupal_add_js('try{Typekit.load();}catch(e){}', 'inline');
	}


	/* Text/typography
	---------------------------------------------------------------------------------------- */
	$typography = '';
	// common text
	if (theme_get_setting('text_font') || theme_get_setting('ts_font_color')) {
    $typography = "body {";
    $typography .= md_thenews_font_to_css(theme_get_setting('text_font'));
		if (theme_get_setting('ts_font_color')) {
      $typography .= 'color: #' . theme_get_setting('ts_font_color') . ';';
		}
    $typography   .= "}\n";
	}
    /////
  $text_font_arr = explode("|", theme_get_setting('text_font'));
  if (count($text_font_arr) == 5 && $text_font_arr[0] != '0') {
    $typography   .= '#forum, ul.quicktabs-tabs, #nav ul.sf-menu li li,.ui-widget {font-family: '.$text_font_arr[4].';}';
  }
    /////
	// Text selection
	if (theme_get_setting('tss_bgcolor') || theme_get_setting('tss_tcolor')) {
    $tss_bgcolor = '';
    $tss_tcolor = '';
		if (theme_get_setting('tss_bgcolor')) {
		  $tss_bgcolor   = 'background: #'.theme_get_setting('tss_bgcolor').';';
		}
		if (theme_get_setting('tss_tcolor')) {
		  $tss_tcolor   = 'color: #'.theme_get_setting('tss_tcolor').';';
		}
    $typography   .= "::-moz-selection {". $tss_bgcolor . $tss_tcolor . "text-shadow: none;}\n";
    $typography   .= "::selection {" . $tss_bgcolor . $tss_tcolor. "text-shadow: none;}\n";
	}
	// link regular
	if (theme_get_setting('l_regular_color') || theme_get_setting('l_regular_st') || theme_get_setting('l_regular__hl') || theme_get_setting('l_regular_ts')) {
    $typography   .= "a:link, .node-content a {";
		if (theme_get_setting('l_regular_color')) {
      $typography   .= 'color: #'.theme_get_setting('l_regular_color').';';
		}
		if (theme_get_setting('l_regular__hl')) {
		  $typography   .= 'background-color: #'.theme_get_setting('l_regular__hlc').';';
		}
		$l_text_style = theme_get_setting('l_regular_ts');
		if ($l_text_style['bold']) {
		  $typography   .= 'font-weight: '.$l_text_style['bold'].';';
		}
		if ($l_text_style['italic']) {
		  $typography   .= 'font-style: '.$l_text_style['italic'].';';
		}
		if ($l_text_style['underline']) {
		  $typography   .= 'text-decoration: '.$l_text_style['underline'].';';
		}
		$typography   .= "}\n";
	}
	// link rollover
	if (theme_get_setting('l_rollover_color') || theme_get_setting('l_rollover_st') || theme_get_setting('l_rollover__hl') || theme_get_setting('l_rollover_ts')) {
		$typography   .= "a:hover, .node-content a:hover {";
		if (theme_get_setting('l_rollover_color')) {
		  $typography   .= 'color: #'.theme_get_setting('l_rollover_color').';';
		}
		if (theme_get_setting('l_rollover__hl')) {
		  $typography   .= 'background-color: #'.theme_get_setting('l_rollover__hlc').';';
		}
		$l_text_style = theme_get_setting('l_rollover_ts');
		if ($l_text_style['bold']) {
		  $typography   .= 'font-weight: '.$l_text_style['bold'].';';
		}
		if ($l_text_style['italic']) {
		  $typography   .= 'font-style: '.$l_text_style['italic'].';';
		}
		if ($l_text_style['underline']) {
		  $typography   .= 'text-decoration: '.$l_text_style['underline'].';';
		}
		$typography   .= "}\n";
	}

	// link visited
	if (theme_get_setting('l_visited_color') || theme_get_setting('l_visited_st') || theme_get_setting('l_visited__hl') || theme_get_setting('l_visited_ts')) {
		$typography   .= "a:visited, .node-content a:visited {";
		if (theme_get_setting('l_visited_color')) {
		  $typography   .= 'color: #'.theme_get_setting('l_visited_color').';';
		}
		if (theme_get_setting('l_visited__hl')) {
		  $typography   .= 'background-color: #'.theme_get_setting('l_visited__hlc').';';
		}
		$l_text_style = theme_get_setting('l_visited_ts');
		if ($l_text_style['bold']) {
		  $typography   .= 'font-weight: '.$l_text_style['bold'].';';
		}
		if ($l_text_style['italic']) {
		  $typography   .= 'font-style: '.$l_text_style['italic'].';';
		}
		if ($l_text_style['underline']) {
		  $typography   .= 'text-decoration: '.$l_text_style['underline'].';';
		}
		$typography   .= "}\n";
	}

	// link on
	if (theme_get_setting('l_on_color') || theme_get_setting('l_on_st') || theme_get_setting('l_on__hl') || theme_get_setting('l_on_ts')) {
		$typography   .= "a:focus, a:active, .node-content a:focus, .node-content a:active {";
		if (theme_get_setting('l_on_color')) {
		  $typography   .= 'color: #'.theme_get_setting('l_on_color').';';
		}
		if (theme_get_setting('l_on__hl')) {
		  $typography   .= 'background-color: #'.theme_get_setting('l_on__hlc').';';
		}
		$l_text_style = theme_get_setting('l_on_ts');
		if ($l_text_style['bold']) {
		  $typography   .= 'font-weight: '.$l_text_style['bold'].';';
		}
		if ($l_text_style['italic']) {
		  $typography   .= 'font-style: '.$l_text_style['italic'].';';
		}
		if ($l_text_style['underline']) {
		  $typography   .= 'text-decoration: '.$l_text_style['underline'].';';
		}
		$typography   .= "}\n";
	}


	// navigation
	if (theme_get_setting('typo_nav_style') || theme_get_setting('nav_color')) {
		$typography   .= "#nav {";
		if (theme_get_setting('text_font')) {
		  $typography   .= md_thenews_font_to_css(theme_get_setting('typo_nav_style'));
		}

		if (theme_get_setting('nav_color')) {
		  $typography   .= 'color: #'.theme_get_setting('nav_color').';';
		}
		$typography   .= "}\n";

		if (theme_get_setting('nav_color')) {
		  $typography   .= 'ul#main-menu-links li a, #nav ul.sf-menu li a {color: #'.theme_get_setting('nav_color').';}';
		}
		if (theme_get_setting('nav_hover_color')) {
		  $typography   .= '#nav ul.sf-menu li > a:hover,#nav ul.sf-menu li.sfHover > a, ul#main-menu-links li:hover a {color: #'.theme_get_setting('nav_hover_color').';}'."\n";
		}
		if (theme_get_setting('nav_active_color')) {
		  $typography   .= '#nav ul.sf-menu li > a:hover, #nav ul.sf-menu li.sfHover > a, #nav ul.sf-menu li a.active,ul#main-menu-links li.active a {color: #'.theme_get_setting('nav_active_color').';}'."\n";
		}
	}


	// Page title
	if (theme_get_setting('typo_pagetitle_style') || theme_get_setting('pagetitle_color')) {
		$typography   .= "h1#page-title {";
		if (theme_get_setting('typo_pagetitle_style')) {
		  $typography   .= md_thenews_font_to_css(theme_get_setting('typo_pagetitle_style'));
		}

		if (theme_get_setting('pagetitle_color')) {
		  $typography   .= 'color: #'.theme_get_setting('pagetitle_color').';';
		}
		$typography   .= "}\n";
	}

	// Node title
	if (theme_get_setting('typo_nodetitle_style') || theme_get_setting('nodetitle_color')) {
		$typography   .= "#content .node h2 {";
		if (theme_get_setting('typo_nodetitle_style')) {
		  $typography   .= md_thenews_font_to_css(theme_get_setting('typo_nodetitle_style'));
		}

		if (theme_get_setting('nodetitle_color')) {
		  $typography   .= 'color: #'.theme_get_setting('nodetitle_color').';';
		}
		$typography   .= "}\n";

		if (theme_get_setting('nodetitle_color')) {
		  $typography   .= '.node h2 a {color: #'.theme_get_setting('nodetitle_color').';}'."\n";
		}

		if (theme_get_setting('nodetitle_hover_color')) {
		  $typography   .= '.node h2 a:hover {color: #'.theme_get_setting('nodetitle_hover_color').';}'."\n";
		}
	}

	if (theme_get_setting('nodetitle_enable') == 1) {
		foreach (node_type_get_types() as $type => $name) {
			if (theme_get_setting('typo_n'.$type.'title_style') || theme_get_setting('n'.$type.'title_color')) {
				$typography   .= "#content .node-$type h2 {";
				if (theme_get_setting('typo_n'.$type.'title_style')) {
				  $typography   .= md_thenews_font_to_css(theme_get_setting('typo_n'.$type.'title_style'));
				}

				if (theme_get_setting('n'.$type.'title_color')) {
				  $typography   .= 'color: #'.theme_get_setting('n'.$type.'title_color').';';
				}
				$typography   .= "}\n";

				if (theme_get_setting('n'.$type.'title_color')) {
				  $typography   .= '.article-type-'.$type.' h2 a {color: #'.theme_get_setting('n'.$type.'title_color').';}'."\n";
				}

				if (theme_get_setting('n'.$type.'title_hover_color')) {
				  $typography   .= '.article-type-'.$type.' h2 a:hover {color: #'.theme_get_setting('n'.$type.'title_hover_color').';}'."\n";
				}
			}
		}
	}

	// Block title
	if (theme_get_setting('typo_blocktitle_style') || theme_get_setting('blocktitle_color')) {
		$typography   .= ".block h3.block-title {";
		if (theme_get_setting('typo_blocktitle_style')) {
		  $typography   .= md_thenews_font_to_css(theme_get_setting('typo_blocktitle_style'));
		}

		if (theme_get_setting('blocktitle_color')) {
		  $typography   .= 'color: #'.theme_get_setting('blocktitle_color').';';
		}
		$typography   .= "}\n";
	}

	// Bottom block title
	if (theme_get_setting('typo_bblocktitle_style') || theme_get_setting('bblocktitle_color')) {
		$typography   .= "#bottom .block h3.block-title {";
		if (theme_get_setting('typo_bblocktitle_style')) {
		  $typography   .= md_thenews_font_to_css(theme_get_setting('typo_bblocktitle_style'));
		}

		if (theme_get_setting('bblocktitle_color')) {
		  $typography   .= 'color: #'.theme_get_setting('bblocktitle_color').';';
		}
		$typography   .= "}\n";
	}
	$vars['typography'] = $typography;
	/* Get theme settings
	---------------------------------------------------------------------------------------- */

	$vars['header_code']   = theme_get_setting('header_code');
	$vars['footer_code']   = theme_get_setting('footer_code');
	if (theme_get_setting('custom_css')) {
		$vars['custom_css']  = theme_get_setting('custom_css');
	}

	drupal_add_css(path_to_theme() . '/css/ie7.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
}

function md_thenews_font_to_css($font) {
	$font_arr = explode("|", $font);
	$css = "";
  if(count($font_arr) == 5) {
    if ($font_arr[0] != '0') {
      $css = 'font-family: '.$font_arr[4].';';
      if ($font_arr[2]) {
        $css .= 'font-size: '.$font_arr[2].$font_arr[3].';';
      }
      $css .= md_thenews_expand_font_weight($font_arr[1]);
    }
  }
	return $css;
}

function md_thenews_expand_font_weight($fw) {
				switch($fw) {
					case 'n1':
						$fontExpand = "font-style: normal; font-weight: 100;";
				  	break;
					case 'i1':
						$fontExpand = "font-style: italic; font-weight: 100;";
						break;
					case 'n2':
						$fontExpand = "font-style: normal; font-weight: 200;";
				  	break;
					case 'i2':
						$fontExpand = "font-style: italic; font-weight: 200;";
						break;
					case 'n3':
						$fontExpand = "font-style: normal; font-weight: 300;";
				  	break;
					case 'i3':
						$fontExpand = "font-style: italic; font-weight: 300;";
						break;
					case 'n4':
						$fontExpand = "font-style: normal; font-weight: normal;";
				  	break;
					case 'i4':
						$fontExpand = "font-style: italic; font-weight: normal";
						break;
					case 'n5':
						$fontExpand = "font-style: normal; font-weight: 500;";
				  	break;
					case 'i5':
						$fontExpand = "font-style: italic; font-weight: 500;";
						break;
					case 'n6':
						$fontExpand = "font-style: normal; font-weight: 600;";
				  	break;
					case 'i6':
						$fontExpand = "font-style: italic; font-weight: 600;";
						break;
					case 'n7':
						$fontExpand = "font-style: normal; font-weight: bold;";
				  	break;
					case 'i7':
						$fontExpand = "font-style: italic; font-weight: bold;";
						break;
					case 'n8':
						$fontExpand = "font-style: normal; font-weight: 800;";
				  	break;
					case 'i8':
						$fontExpand = "font-style: italic; font-weight: 800;";
						break;
					case 'n9':
						$fontExpand = "font-style: normal; font-weight: 800;";
				  	break;
					case 'i9':
						$fontExpand = "font-style: italic; font-weight: 800;";
						break;
					default:
						$fontExpand = "";
				}

				return $fontExpand;
			}

/**
 * Override or insert vars into the page template for HTML output.
 */
function md_thenews_process_html(&$vars) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_html_alter($vars);
  }

	$classes = explode(' ', $vars['classes']);
  if ($node = menu_get_object()) {
    $node_type_class = drupal_html_class('node-type-' . $node->type);
    if (in_array($node_type_class, $classes)) {
      theme_get_setting('extra_page_classes') == 0 ? '' : $classes = str_replace($node_type_class, '', $classes);
      $classes = str_replace('node-type-', 'page-type-', $classes);
    }
  }
  $vars['classes'] = trim(implode(' ', $classes));
}



/**
 * Override or insert vars into the page template.
 */
function md_thenews_process_page(&$vars) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $vars['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $vars['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($vars['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $vars['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($vars['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $vars['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
  // Since the title and the shortcut link are both block level elements,
  // positioning them next to each other is much simpler with a wrapper div.
  if (!empty($vars['title_suffix']['add_or_remove_shortcut']) && $vars['title']) {
    // Add a wrapper div using the title_prefix and title_suffix render elements.
    $vars['title_prefix']['shortcut_wrapper'] = array(
      '#markup' => '<div class="shortcut-wrapper clearfix">',
      '#weight' => 100,
    );
    $vars['title_suffix']['shortcut_wrapper'] = array(
      '#markup' => '</div>',
      '#weight' => -99,
    );
    // Make sure the shortcut link is the first item in title_suffix.
    $vars['title_suffix']['add_or_remove_shortcut']['#weight'] = -100;
  }

	$vars['mainclass'] = '';
	if ($vars['page']['slider']) {
		$vars['mainclass'] = 'withslider ';
	}
	$vars['withheadlines'] = '';
	if ($vars['page']['headlines']) {
		$vars['withheadlines'] = 'withheadlines ';
	}
	if (drupal_is_front_page()) {
		$vars['front_page_content']   = theme_get_setting('front_page_content');
	} else {
		$vars['front_page_content'] = 1;
	}

	$vars['themepath'] = base_path().drupal_get_path('theme', 'md_thenews');

	$vars['bottom_blocks']   = theme_get_setting('bottom_blocks');
	$vars['bottom_columns']   = array(
															'10' => array('col col4b1','col col4b1','col col4b2','col col4b2'),
															'4' => array('col col4','col col4','col col4','col col4'),
															'3'	=> array('col col3','col col3','col col3'),
															'2' => array('col col2','col col2'),
															'1' => array('')
														);
	$vars['contentop_blocks']   = theme_get_setting('contentop_blocks');
	$vars['contenttop_columns']   = array(
															'4' => array('col col4','col col4','col col4','col col4'),
															'3'	=> array('col col3','col col3','col col3'),
															'2' => array('col col2','col col2'),
															'1' => array('')
														);
}

/**
 * Implements hook_preprocess_page().
 */
function md_thenews_preprocess_page(&$vars) {
	$blogcolumnclass = "";
	$photocolumnclass = "";
	$videocolumnclass = "";
	switch (theme_get_setting('node_article_display')) {
		case 1:
			$blogcolumnclass = 'article-1col600';
			break;
		case 2:
			$blogcolumnclass = 'article-1col300';
			break;
		case 3:
			$blogcolumnclass = 'article-1col200';
			break;
		case 4:
			$blogcolumnclass = 'article-1col0';
			break;
		case 5:
			$blogcolumnclass = 'article-2col300';
			break;
		case 6:
			$blogcolumnclass = 'article-2col150';
			break;
	}
	switch (theme_get_setting('node_photo_display')) {
		case 1:
			$photocolumnclass = ' photo-1col';
			break;
		case 2:
			$photocolumnclass = ' photo-2col';
			break;
		case 3:
			$photocolumnclass = ' photo-3col';
			break;
		case 4:
			$photocolumnclass = ' photo-4col';
			break;
	}
	switch (theme_get_setting('node_video_display')) {
		case 1:
			$videocolumnclass = ' video-1col';
			break;
		case 2:
			$videocolumnclass = ' video-2col';
			break;
		case 3:
			$videocolumnclass = ' video-3col';
			break;
		case 4:
			$videocolumnclass = ' video-4col';
			break;
	}
	$vars['columclass'] = $blogcolumnclass.$photocolumnclass.$videocolumnclass;
   // Primary nav.
  $vars['primary_nav'] = FALSE;
  if ($vars['main_menu']) {
    // Build links.
    $vars['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $vars['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

}

/**
 * Implements hook_preprocess_maintenance_page().
 */
function md_thenews_preprocess_maintenance_page(&$vars) {
  if (!$vars['db_is_active']) {
    unset($vars['site_name']);
  }
  drupal_add_css(drupal_get_path('theme', 'md_thenews') . '/css/maintenance-page.css');
}

/**
 * Override or insert vars into the maintenance page template.
 */
function md_thenews_process_maintenance_page(&$vars) {
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $vars['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $vars['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($vars['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $vars['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($vars['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $vars['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
}

/**
 * Override or insert vars into the node template.
 */
function md_thenews_preprocess_node(&$vars) {
	if (theme_get_setting('extra_article_classes')) {
    if (module_exists('translation')) {
      if ($vars['node']->language) {
        global $language;
        $vars['classes_array'][] = 'article-lang-'. $vars['node']->language;
      }
    }
  }

  $vars['classes_array'][] = $vars['zebra'];

  $vars['submitted'] = t('Published by !username on !datetime', array('!username' => $vars['name'], '!datetime' => $vars['date']));

  if ($vars['view_mode'] == 'full' && node_is_page($vars['node'])) {
    $vars['classes_array'][] = 'node-full';
  }

	if ($vars['view_mode'] == 'teaser') {
    $vars['classes_array'][] = "node-".$vars['node']->type."-teaser";
  }

	// For articles page display
	$vars['node_display'] = "";
	$vars['infowithimage'] = "";
	if ($vars['node']->type == 'article') {
    if (isset($vars['node']->field_image) && !empty($vars['node']->field_image['und'][0]['filename'])) {
			$vars['node_display'] = theme_get_setting('node_article_display');
      $image_uri = $vars['node']->field_image['und'][0]['uri'];
			switch (theme_get_setting('node_article_display')) {
				case 1:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'article600', 'path' => $image_uri));
					$vars['classes_array'][] = 'article-image600';
					break;
				case 2:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'article300x170', 'path' => $image_uri));
					$vars['classes_array'][] = 'article-image300';
					$vars['classes_array'][] = 'clearfix';
					break;
				case 3:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'article200x125', 'path' => $image_uri));
					$vars['classes_array'][] = 'article-image200';
					$vars['classes_array'][] = 'clearfix';
					break;
				case 4:
					$vars['classes_array'][] = 'article-noimage';
					break;
				case 5:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'article300x170', 'path' => $image_uri));
					$vars['classes_array'][] = 'article-image300';
					break;
				case 6:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'article150x150', 'path' => $image_uri));
					$vars['classes_array'][] = 'article-image150';
					break;
			}
		} else {
			$vars['classes_array'][] = 'info-noimage';
		}
  }

	// For photo page display
	if ($vars['node']->type == 'photo') {
    if (isset($vars['node']->field_photo) && !empty($vars['node']->field_photo['und'][0]['filename'])) {
			$vars['node_display'] = theme_get_setting('node_photo_display');
            $image_uri = $vars['node']->field_photo['und'][0]['uri'];
			switch (theme_get_setting('node_photo_display')) {
				case 1:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'article600 ', 'path' => $image_uri));
					break;
				case 2:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'photo500x280', 'path' => $image_uri));
					break;
				case 3:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'photo330x180', 'path' => $image_uri));
					break;
				case 4:
					$vars['articleimage'] = theme('image_style', array('style_name' => 'photo240x135', 'path' => $image_uri));
					break;
			}
		}
  }

  // For video page display
  	if ($vars['node']->type == 'video') {
      if (isset($vars['node']->field_image) && !empty($vars['node']->field_image['und'][0]['filename'])) {
  			$vars['node_display'] = theme_get_setting('node_video_display');
  			$image_uri = $vars['node']->field_image['und'][0]['uri'];
  			switch (theme_get_setting('node_video_display')) {
  				case 1:
  					$vars['articleimage'] = theme('image_style', array('style_name' => 'photo330x180', 'path' => $image_uri));
  					break;
  				case 2:
  					$vars['articleimage'] = theme('image_style', array('style_name' => 'photo500x280', 'path' => $image_uri));
  					break;
  				case 3:
  					$vars['articleimage'] = theme('image_style', array('style_name' => 'photo330x180', 'path' => $image_uri));
  					break;
  				case 4:
  					$vars['articleimage'] = theme('image_style', array('style_name' => 'photo240x135', 'path' => $image_uri));
  					break;
  			}
  		}
    }

	$vars['nodeurl'] = url("node/".$vars['node']->nid, array('absolute' => TRUE));

	$node_content_type = (theme_get_setting('node_enable') == 1) ? $vars['node']->type : 'default';

	$vars['node_share_position'] = theme_get_setting('node_share_position_'. $node_content_type);

  $vars['facebook_display'] = theme_get_setting('node_share_facebook_'. $node_content_type);
	if (theme_get_setting('node_share_facebook_'. $node_content_type)){
		$vars['facebook_layout'] = theme_get_setting('node_share_facebook_layout_'. $node_content_type);
		$vars['facebook_display_font'] = theme_get_setting('node_share_facebook_font_'. $node_content_type);
		$vars['facebook_display_color'] = theme_get_setting('node_share_facebook_color_'. $node_content_type);
	}

	$vars['twitter_display'] = theme_get_setting('node_share_twitter_'. $node_content_type);
	if (theme_get_setting('node_share_twitter_'. $node_content_type)){
		$vars['twitter_display_style'] = theme_get_setting('node_share_twitter_style_'. $node_content_type);
		$vars['twitter_display_lang'] = theme_get_setting('node_share_twitter_lang_'. $node_content_type);
	}

	$vars['gplus_display'] = theme_get_setting('node_share_gplus_'. $node_content_type);
	if (theme_get_setting('node_share_gplus_'. $node_content_type)){
		drupal_add_js('https://apis.google.com/js/plusone.js', 'external');
		$vars['gplus_display_size'] = theme_get_setting('node_share_gplus_size_'. $node_content_type);
		$vars['gplus_annotation'] = theme_get_setting('node_share_gplus_annotation_'. $node_content_type);
	}

	$vars['pinterest_display'] = theme_get_setting('node_share_pinterest_'. $node_content_type);
	if (theme_get_setting('node_share_pinterest_'. $node_content_type)){
		drupal_add_js('http://assets.pinterest.com/js/pinit.js', 'external');
		$vars['pinterest_layout'] = theme_get_setting('node_share_pinterest_layout_'. $node_content_type);
		$vars['pinterest_media'] = '';
		if (theme_get_setting('node_share_pinterest_image_'. $node_content_type)) {
			$pinterest_image_field = 'field_'.theme_get_setting('node_share_pinterest_image_'. $node_content_type);
			$pinterest_image = $vars['node']->$pinterest_image_field;
			if (isset($pinterest_image) && !empty($pinterest_image['und'][0]['filename'])) {
				$vars['pinterest_media'] = file_create_url(file_build_uri($pinterest_image['und'][0]['filename']));
			}
		}
	}

	$vars['stumble_display'] = theme_get_setting('node_share_stumble_'. $node_content_type);
	if (theme_get_setting('node_share_stumble_'. $node_content_type)){
		$vars['stumble_display_style'] = theme_get_setting('node_share_stumble_style_'. $node_content_type);
	}

}

// template_preprocess_comment
function md_thenews_preprocess_comment(&$vars) {
  if (theme_get_setting('extra_comment_classes')) {
    $vars['classes_array'][] = $vars['zebra'];
  }
  $vars['title_attributes_array']['class'][] = 'comment-title';
  $vars['content_attributes_array']['class'][] = 'comment-content';
  $uri = entity_uri('comment', $vars['comment']);
  $uri['options'] += array('attributes' => array('rel' => 'bookmark'));
  $vars['title'] = l($vars['comment']->subject, $uri['path'], $uri['options']);
  $vars['permalink'] = l(t('Permalink'), $uri['path'], $uri['options']);
  $vars['created'] = '<span class="date-time permalink">' . l($vars['created'], $uri['path'], $uri['options']) . '</span>';
  $vars['datetime'] = format_date($vars['comment']->created, 'custom', 'c');
  $vars['unpublished'] = '';
  if ($vars['status'] == 'comment-unpublished') {
    $vars['unpublished'] = '<div class="unpublished">' . t('Unpublished') . '</div>';
  }
}
// template_process_comment
function md_thenews_process_comment(&$vars) {
  $classes = explode(' ', $vars['classes']);
  if (in_array('comment-by-anonymous', $classes)) {
    theme_get_setting('extra_comment_classes') ? '' : $classes = str_replace('comment-by-anonymous', '', $classes);
  }
  if (in_array('comment-by-node-author', $classes)) {
    $classes = str_replace('comment-by-node-author', 'comment-by-article-author', $classes);
    theme_get_setting('extra_comment_classes') ? '' : $classes = str_replace('comment-by-article-author', '', $classes);
  }
  if (in_array('comment-by-viewer', $classes)) {
    theme_get_setting('extra_comment_classes') ? '' : $classes = str_replace('comment-by-viewer', '', $classes);
  }
  if (in_array('comment-new', $classes)) {
    theme_get_setting('extra_comment_classes') ? '' : $classes = str_replace('comment-new', '', $classes);
  }
  $vars['classes'] = trim(implode(' ', $classes));
}

/**
 * Override or insert vars into the block template.
 */
function md_thenews_preprocess_block(&$vars) {
	if (theme_get_setting('extra_block_classes')) {
    $vars['classes_array'][] = 'block-' . $vars['block_zebra'];
  }
  if (theme_get_setting('extra_block_classes')) {
    $vars['classes_array'][] = 'block-count-'. $vars['id'];
  }
  if (theme_get_setting('extra_block_classes')) {
    $vars['classes_array'][] = drupal_html_class('block-region-' . $vars['block']->region);
  }
  // In the header region visually hide block titles.
  if ($vars['block']->region == 'header') {
    $vars['title_attributes_array']['class'][] = 'element-invisible';
  }
	$vars['header'] = NULL;
}



// Modify search results based on theme settings.
function md_thenews_preprocess_search_result(&$vars) {
  $result = $vars['result'];
  $vars['url'] = check_url($result['link']);
  $vars['title'] = check_plain($result['title']);
  $vars['snippet'] = '';
  if (!empty($result['snippet']) && theme_get_setting('search_snippet')) {
    $vars['snippet'] = $result['snippet'];
  }
  $info = array();
  if (!empty($result['type']) && theme_get_setting('search_info_type')) {
    $info['type'] = check_plain($result['type']);
  }
  if (!empty($result['user']) && theme_get_setting('search_info_user')) {
    $info['user'] = $result['user'];
  }
  if (!empty($result['date']) && theme_get_setting('search_info_date')) {
    $info['date'] = format_date($result['date'], 'small');
  }
  if (isset($result['extra']) && is_array($result['extra'])) {
    if (!empty($result['extra'][0]) && theme_get_setting('search_info_comment')) {
      $info['comment'] = $result['extra'][0];
    }
    if (!empty($result['extra'][1]) && theme_get_setting('search_info_upload')) {
      $info['upload'] = $result['extra'][1];
    }
  }
  $vars['info_split'] = $info;
  $vars['info'] = implode(' - ', $info);
  $vars['info_separator'] = filter_xss(theme_get_setting('search_info_separator'));
}
