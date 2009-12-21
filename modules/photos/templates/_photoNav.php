<?php
/**
 * Undocumented options ahoy!
 * To change the opacity or duration of the AJAX loader, set the options:
 *  app_hnPhotoAlbumPlugin_interstitial_opacity     (default 0.85, i.e. 85%)
 *  app_hnPhotoAlbumPlugin_interstitial_duration    (default 0.25 seconds)
 */
?>

<?php if_javascript(); ?>
  
  <?php echo link_to_function(
    $text,
    "new Ajax.Updater(
      'hnPhotoAlbumPlugin',
      '".url_for($url)."',
      {
        asynchronous:true,
        evalScripts:false,
        onComplete:function(request, json)
        {
          Element.hide('photo_ajax_loader');
        },
        onLoading:function(request, json)
        {
          Element.show('photo_ajax_loader');
          new Effect.Opacity('photo_ajax_loader',
          {
            duration:".sfConfig::get('app_hnPhotoAlbumPlugin_interstitial_duration', 0.25).",
            from:0,
            to:".sfConfig::get('app_hnPhotoAlbumPlugin_interstitial_opacity', 0.85)."
          });
        }
      }
    ); return true;",
    array(
      'href' => '#'.$photo_id,
    )
  ); ?>
  
<?php end_if_javascript(); ?>

<noscript>
  <?php echo link_to($text, $url); ?>
</noscript>
