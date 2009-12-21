<?php use_helper('JavascriptBase'); ?>

<div id="hnPhotoAlbumPlugin">

  <h3 id="from_album">
    From album: <?php echo link_to($albumEntry->getTitle(), 'photos/album?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName()))); ?>
  </h3>
  
  
  
  <!-- <h2><?php echo $photoEntry->getTitle(); ?></h2> -->
  
  <div class="previous">
  
    <?php if (!is_null($previous)): ?>
    
      <?php $previous_url = 'photos/photo?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName(), 'photo_id' => (string)$previous->getGphotoId())); ?>
      
      <?php include_partial('photoNav', array('text' => '&lt; Previous', 'url' => $previous_url, 'photo_id' => (string)$previous->getGphotoId())); ?>
      
    <?php else: ?>
    
      &lt; Previous
      
    <?php endif; ?>
    
  </div>
  
  <div class="next">
  
    <?php if (!is_null($next)): ?>
    
      <?php $next_url = 'photos/photo?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName(), 'photo_id' => (string)$next->getGphotoId())); ?>
      
      <?php include_partial('photoNav', array('text' => 'Next &gt;', 'url' => $next_url, 'photo_id' => (string)$next->getGphotoId())); ?>
      
    <?php else: ?>
    
      Next &gt;
      
    <?php endif; ?>
    
  </div>
  
  <div id="photo">
    <div style="width: <?php echo $image_width; ?>px; height: <?php echo $image_height; ?>px; margin-left: auto; margin-right: auto; background:url(<?php echo _compute_public_path('/hnPhotoAlbumPlugin/images/checkerboard.png', 'images', 'png'); ?>);">
        <div id="photo_ajax_loader" style="width: <?php echo $image_width; ?>px; height: <?php echo $image_height; ?>px; position: absolute; background-color: black; opacity: 0; display: none;">
          <?php echo image_tag('/hnPhotoAlbumPlugin/images/ajax-loader.gif', array('style' => 'margin-top: '.(($image_height-32)/2).'px;')); ?>
        </div>
      <?php echo image_tag($image_src, array('width' => $image_width, 'height' => $image_height)); ?>
    </div>
  </div>
  
  <div class="previous">
  
    <?php if (!is_null($previous)): ?>
    
      <?php include_partial('photoNav', array('text' => '&lt; Previous', 'url' => $previous_url, 'photo_id' => (string)$previous->getGphotoId())); ?>
      
    <?php else: ?>
    
      &lt; Previous
      
    <?php endif; ?>
    
  </div>
  
  <div class="next">
  
    <?php if (!is_null($next)): ?>
    
      <?php include_partial('photoNav', array('text' => 'Next &gt;', 'url' => $next_url, 'photo_id' => (string)$next->getGphotoId())); ?>
      
    <?php else: ?>
    
      Next &gt;
      
    <?php endif; ?>
    
  </div>
  
  <p id="description">
    <?php echo $photoEntry->getMediaGroup()->getDescription(); ?>
  </p>
  
  <p id="download">
    <?php echo link_to('Download full-size', 'photos/download?'.http_build_query(array('album_name' => (string)$albumEntry->getGphotoName(), 'photo_id' => (string)$photoEntry->getGphotoId()))); ?>
  </p>

</div>
