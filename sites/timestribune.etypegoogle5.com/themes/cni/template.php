<?php

/* First and Last Classes on Teasers */

function cni_preprocess_page(&$variables) {
  if (isset ($variables['page']['content']['system_main']['nodes'])) {
    $nodes = $variables['page']['content']['system_main']['nodes'];
    $i = 1;
    $len = count($nodes);
    if ($len > 0) {
      foreach (array_keys($nodes) as $nid) {
        if ($i == 1) {
          $variables['page']['content']['system_main']['nodes'][$nid]['#node']->classes_array = array('first');
        }
        if ($i == $len - 1) {
          $variables['page']['content']['system_main']['nodes'][$nid]['#node']->classes_array = array('last');
        }
        $i++;
        /* So I don't get "Warning: Cannot use a scalar value as an array" */
        unset($nodes,$nid);
      }
    }
  }
}

function cni_preprocess_node(&$variables) {
  $node = $variables['node'];
  if (!empty($node->classes_array)) {
    $variables['classes_array'] = array_merge($variables['classes_array'], $node->classes_array);
  }

  if (node_is_page($node) !== false) {
    drupal_add_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56e774978692f861', 'external');
  }
}

/* Breadcrumbs */

function cni_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
   
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.

    $output = '<div class="breadcrumb"><div class="breadcrumb-inner">' . implode(' / ', $breadcrumb) . '</div></div>';
    return $output;
  }
}

/* Span Tag on Links */

function cni_link($variables) {
  return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '><span>' . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text'])) . '</span></a>';
}

/* Some text in ye old Search Form */

function cni_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {

// Add extra attributes to the text box
    $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Search';}";
    $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == 'Search') {this.value = '';}";
    // Prevent user from searching the default text
    $form['#attributes']['onsubmit'] = "if(this.search_block_form.value=='Search'){ alert('Please enter a search'); return false; }";
  }
}

/**
 * @param $vars
 */
function cni_preprocess_html(&$vars) {

  /* Add Page Body Class */
  $path = drupal_get_path_alias($_GET['q']);
  $aliases = explode('/', $path);
  foreach($aliases as $alias) {
    $vars['classes_array'][] = drupal_clean_css_identifier($alias);
  }

  /*
   * Hide Log In link from logged in users
   * A call to hook_menu_alter in etype.module does not do the trick
   */
  global $user;
  if ($user->uid > 0) {
    drupal_add_js(drupal_get_path('theme', 'cni'). '/js/user-menu.js', 'file');
  }

}