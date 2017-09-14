<!DOCTYPE html>
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>>

<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>  
 
<meta name="description" content="Advance Publishing Company | Advance News Journal">
<meta name="keywords" content=" Advance Publishing Company | Advance News Journal">
<meta name="author" content="https://www.theadvancenewsjournal.com"/>
<meta name="rating" content="General"/>
<meta name="revisit-after" content="7 days"/>
<meta name="robots" content="index, follow"/>
<meta property="og:image" content="httpw://www.anjournal.com/sites/advance/files/400pxAdvanceforWeb.gif">
  
  
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body class="<?php print $classes; ?>"<?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>

</html>