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
        
          <?php echo link_to(
            image_tag($thumbs[0]->getUrl()).'<br />'.$photoEntry->getTitle(),
            'photos/photo?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName(), 'photo_id' => (string)$photoEntry->getGphotoId()))
          ); ?><br />
          
          <?php $i++; ?>
        
        </td>
  
        <?php if ($i % 4 == 0): ?>
        
          </tr><tr>
        
        <?php endif; ?>
      
      <?php endforeach; ?>
      
    </tr>
  
  </table>

</div>