<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

<head profile="<?php print $grddl_profile; ?>">
<!-- Outbrain script tag, place in header -->
<script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>
<?php print $head; ?>
<title><?php print $head_title; ?></title>
<?php 
	print $styles;
	print $scripts; 
?>
<style type="text/css">
	<?php if (isset($googlewebfonts)): print $googlewebfonts; endif; ?>
	<?php if (isset($theme_setting_css)): print $theme_setting_css; endif; ?>
	<?php 
	// custom typography
	if (isset($typography)): print $typography; endif; 
	
	?>

	<?php if (isset($custom_css)): print $custom_css; endif; ?>
</style>
<?php if (isset($header_code)): print $header_code; endif;?>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '308322346502400');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=308322346502400&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code —>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php 
		print $page_bottom; 
		if ($footer_code): print $footer_code; endif;
	?>
</body>
</html>
