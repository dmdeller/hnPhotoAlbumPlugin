<?php use_helper('JavascriptBase'); ?>

<div id="hnPhotoAlbumPlugin">

  <h2><?php echo $albumEntry->getTitle(); ?></h2>
  
  <p>
    <?php echo $albumEntry->getMediaGroup()->getDescription(); ?>
  </p>
  
  
  <table class="photos">
  
    <tr>
    
      <?php $i = 0; ?>
  
      <?php foreach ($albumFeed as $photoEntry): ?>
      
        <td style="max-width: <?php echo preg_replace('/[^\d]/', '', sfConfig::get('app_hnPhotoAlbumPlugin_photo_thumb_size', '160u')); ?>px;">
      
          <?php $thumbs = $photoEntry->getMediaGroup()->getThumbnail(); ?>
          
          <!-- AJAXy version for those who can use it -->
          <?php if_javascript(); ?>
            <?php echo link_to(
              image_tag($thumbs[0]->getUrl()).'<br />'.$photoEntry->getTitle(),
              '@photos_photo_placeholder?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName()))
              .'#'.(string)$photoEntry->getGphotoId()
            ); ?><br />
          <?php end_if_javascript(); ?>
          
          <!-- Plain HTML otherwise -->
          <noscript>
            <?php echo link_to(
              image_tag($thumbs[0]->getUrl()).'<br />'.$photoEntry->getTitle(),
              '@photos_photo?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName(), 'photo_id' => (string)$photoEntry->getGphotoId()))
            ); ?><br />
          </noscript>
          
          <?php $i++; ?>
        
        </td>
  
        <?php if ($i % 4 == 0): ?>
        
          </tr><tr>
        
        <?php endif; ?>
      
      <?php endforeach; ?>
      
    </tr>
  
  </table>

</div>