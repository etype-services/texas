<!DOCTYPE html>
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>>

<head>
<style>
 .sf-menu.sf-style-default a {
 /* border-left: 1px solid #000 !important;
  border-top: 1px solid #000 !important;
  padding: 0.75em 1em !important; */
  }
  .sf-menu.sf-style-pomegranate li, .sf-menu.sf-style-pomegranate.sf-navbar {
  background: #A8141A !important;
  text-transform: uppercase !important;
  font-size: 15px !important;
  border-bottom:0px !important;
  height:38px !important;
  min-height:38px !important;
  }
  .sf-menu.sf-style-pomegranate a
  {
color: #ffebee !important; 
  text-shadow:0px 0px !important;
  border:0px !important;
  padding: 0em 1em !important;
  height:38px !important;
  line-height:38px !important;
  } 
 .sf-menu.sf-style-pomegranate li:hover, .sf-menu.sf-style-pomegranate li.sfHover, .sf-menu.sf-style-pomegranate li.active a, .sf-menu.sf-style-pomegranate a:focus, .sf-menu.sf-style-pomegranate a:hover, .sf-menu.sf-style-pomegranate a:active, .sf-menu.sf-style-pomegranate.sf-navbar li li
 {
   background: #000 !important;
  color: #ffffff !important;
}
 .sf-menu.sf-style-pomegranate a:hover { text-decoration:underline !important; line-height: 38px !important;}
 .block-inner {overflow:hidden;}
 #block-simpleads-ad-groups-65 .block-inner .content .adslist {margin-top:15px;}
 .preface-wrapper .block .content {  height: 310px !important;
  overflow: hidden !important;}
  .postscript-wrapper {
  padding: 20px 0;
  margin: 0 -10px;
  background: url(/sites/anjournal.com/themes/masthead/images/style1/postscript-bg.png) !important; }
  .postscript-wrapper h3 span {
  padding-right: 5px !important;
  background: #333333 !important;
  color: #999999 !important;
  font-size: 11px;
  font-weight: normal;
}
</style>
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