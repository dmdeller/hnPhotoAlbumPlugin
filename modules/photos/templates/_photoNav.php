<?php if_javascript(); ?>
  <?php echo link_to_remote($text, array('update' => 'article', 'url' => $url, 'loading' => "Element.show('ajax_loader');".visual_effect('scroll_to', 'ajax_loader', array('duration' => 0.5)), 'complete' => "Element.hide('ajax_loader')")); ?>
<?php end_if_javascript(); ?>

<noscript>
  <?php echo link_to($text, $url); ?>
</noscript>