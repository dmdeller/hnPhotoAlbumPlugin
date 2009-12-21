<?php use_helper('JavascriptBase'); ?>

<div id="hnPhotoAlbumPlugin">

  <p id="placeholder_loader">
    <?php echo image_tag('/hnPhotoAlbumPlugin/images/ajax-loader.gif'); ?>
  </p>
  
  <?php /* if_javascript(); */ ?>
  
    <?php echo javascript_tag(
      "new Ajax.Updater(
        'hnPhotoAlbumPlugin',
        '".url_for('@photos_photo?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName(), 'photo_id' => '')))."'+(location.hash.substring(1)),
        {
          asynchronous:true,
          evalScripts:false,
        }
      );"
    ); ?>
    
  <?php /* end_if_javascript(); */ ?>
  
  <noscript>
    Looks like you don't have JavaScript turned on. Please <?php echo link_to('return to the album page', 'photos/album?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName()))); ?> and choose a photo that way.
  </noscript>

</div>