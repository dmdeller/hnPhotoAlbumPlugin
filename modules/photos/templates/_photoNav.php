<?php
/**
 * Undocumented options ahoy!
 * To change the opacity or duration of the AJAX loader, set the options:
 *  app_hnPhotoAlbumPlugin_interstitial_opacity     (default 0.85, i.e. 85%)
 *  app_hnPhotoAlbumPlugin_interstitial_duration    (default 0.25 seconds)
 */
?>

<?php if_javascript(); ?>
  <?php echo link_to_remote($text, array('update' => 'article', 'url' => $url, 'loading' => "Element.show('photo_ajax_loader');".visual_effect('opacity', 'photo_ajax_loader', array('from' => 0, 'to' => sfConfig::get('app_hnPhotoAlbumPlugin_interstitial_opacity', 0.85), 'duration' => sfConfig::get('app_hnPhotoAlbumPlugin_interstitial_duration', 0.25))), 'complete' => "Element.hide('photo_ajax_loader')")); ?>
<?php end_if_javascript(); ?>

<noscript>
  <?php echo link_to($text, $url); ?>
</noscript>
