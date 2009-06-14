<div id="hnPhotoAlbumPlugin">

  <h1>Albums</h1>
  
  <?php $i = 0; ?>
  
  <table class="albums">
  
    <tr>
  
      <?php foreach ($userFeed as $albumEntry): ?>
      
        <td style="max-width: <?php echo preg_replace('/[^\d]/', '', sfConfig::get('app_hnPhotoAlbumPlugin_album_thumb_size', '160c')); ?>px;">
      
          <?php $thumbs = $albumEntry->getMediaGroup()->getThumbnail(); ?>
        
          <?php echo link_to(
            image_tag($thumbs[0]->getUrl()).'<br />'.$albumEntry->getTitle(),
            'photos/album?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName()))
          ); ?><br />
          
          <?php $i++; ?>
        
        </td>
        
        <?php if ($i % 4 == 0): ?>
        
          </tr><tr>
        
        <?php endif; ?>
      
      <?php endforeach; ?>
  
    </tr>
  
  </table>
  
  <p>
    You can also view these photos on <?php echo link_to('Picasa Web Albums', 'http://picasaweb.google.com/'.$username); ?>.
  </p>

</div>