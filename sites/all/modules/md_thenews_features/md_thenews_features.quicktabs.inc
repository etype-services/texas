<?php
/**
 * @file
 * md_thenews_features.quicktabs.inc
 */

/**
 * Implements hook_quicktabs_default_quicktabs().
 */
function md_thenews_features_quicktabs_default_quicktabs() {
  $export = array();

  $quicktabs = new stdClass();
  $quicktabs->disabled = FALSE; /* Edit this to true to make a default quicktabs disabled initially */
  $quicktabs->api_version = 1;
  $quicktabs->machine_name = 'accordion_block';
  $quicktabs->ajax = 0;
  $quicktabs->hide_empty_tabs = FALSE;
  $quicktabs->default_tab = 0;
  $quicktabs->title = 'Accordion block';
  $quicktabs->tabs = array(
    0 => array(
      'bid' => 'views_delta_latest_articles-block',
      'hide_title' => 1,
      'title' => 'Latest articles',
      'weight' => '-100',
      'type' => 'block',
    ),
    1 => array(
      'bid' => 'tagadelic_delta_1',
      'hide_title' => 1,
      'title' => 'Tags cloud',
      'weight' => '-99',
      'type' => 'block',
    ),
    2 => array(
      'bid' => 'comment_delta_recent',
      'hide_title' => 1,
      'title' => 'Recent comments',
      'weight' => '-98',
      'type' => 'block',
    ),
  );
  $quicktabs->renderer = 'accordion';
  $quicktabs->style = 'nostyle';
  $quicktabs->options = array(
    'history' => 0,
    'jquery_ui' => array(
      'autoHeight' => 1,
      'collapsible' => 0,
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Accordion block');
  t('Latest articles');
  t('Recent comments');
  t('Tags cloud');

  $export['accordion_block'] = $quicktabs;

  $quicktabs = new stdClass();
  $quicktabs->disabled = FALSE; /* Edit this to true to make a default quicktabs disabled initially */
  $quicktabs->api_version = 1;
  $quicktabs->machine_name = 'social_promote';
  $quicktabs->ajax = 0;
  $quicktabs->hide_empty_tabs = FALSE;
  $quicktabs->default_tab = 0;
  $quicktabs->title = 'Social promote';
  $quicktabs->tabs = array(
    0 => array(
      'bid' => 'md_thenews_bl_delta_md_facebook',
      'hide_title' => 1,
      'title' => 'Facebook',
      'weight' => '-100',
      'type' => 'block',
    ),
    1 => array(
      'bid' => 'twitter_pull_delta_0',
      'hide_title' => 1,
      'title' => 'Twitter',
      'weight' => '-99',
      'type' => 'block',
    ),
  );
  $quicktabs->renderer = 'quicktabs';
  $quicktabs->style = 'nostyle';
  $quicktabs->options = array();

  // Translatables
  // Included for use with string extractors like potx.
  t('Facebook');
  t('Social promote');
  t('Twitter');

  $export['social_promote'] = $quicktabs;

  return $export;
}
