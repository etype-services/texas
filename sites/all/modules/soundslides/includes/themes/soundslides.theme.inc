<?php
/**
 * Preprocess function for theme('soundslides_video').
 */
function soundslides_preprocess_soundslides_video(&$variables) {
  $fid = soundslides_get_fid_from_uri($variables['uri']);
  $project_path = soundslides_get_project_path($fid);
  $index_height = soundslides_get_height($fid);
  $index_width = soundslides_get_width($fid);
  $variables['id'] = $fid;
  $variables['index_height'] = $index_height;
  $variables['index_width'] = $index_width;
  $variables['wrapper_id'] = 'slideshow';
  $variables['path_to_swf'] = '/' . $project_path . '/soundslider.swf';
  $variables['path_to_project'] = '/' . $project_path;

  $variables['output'] = '<div id ="project_path" style="display:none;">' . $project_path . '</div><object type="application/x-shockwave-flash" id="myDynamicContent" name="myDynamicContent" data="' . $variables['path_to_swf'] . '" width="' . $index_width . '" height="' . $index_height . '"><param name="menu" value="false"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="flashvars" value="pathToProject=' . $variables['path_to_project'] . '&amp;format=xml&amp;resize_mode=AUTOSIZE"></object>';
}
