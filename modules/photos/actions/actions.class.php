<?php

class photosActions extends sfActions
{

  public function preExecute()
  {
    $this->username = sfConfig::get('app_hnPhotoAlbumPlugin_picasa_username', 'picasateam');
    $this->picasa = new Zend_Gdata_Photos();
    
    $response = $this->getResponse();
    $response->addJavascript(sfConfig::get('app_hnPhotoAlbumPlugin_path_js_prototype', '/js').'/prototype');
    $response->addJavascript(sfConfig::get('app_hnPhotoAlbumPlugin_path_js_scriptaculous', '/js').'/builder');
    $response->addJavascript(sfConfig::get('app_hnPhotoAlbumPlugin_path_js_scriptaculous', '/js').'/effects');
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $query = new Zend_Gdata_Photos_UserQuery();
    $query->setUser($this->username);
    $query->setThumbsize(sfConfig::get('app_hnPhotoAlbumPlugin_album_thumb_size', '160c')); // see: http://code.google.com/apis/picasaweb/reference.html#Parameters
    
    try
    {
      $this->userFeed = $this->picasa->getUserFeed(null, $query);
    }
    catch (Zend_Gdata_App_Exception $e)
    {
      $this->forward404();
    }
  }
  
  public function executeAlbum(sfWebRequest $request)
  {
    $query = new Zend_Gdata_Photos_AlbumQuery();
    $query->setUser($this->username);
    $query->setAlbumName($request->getParameter('album_name'));
    $query->setThumbsize(sfConfig::get('app_hnPhotoAlbumPlugin_photo_thumb_size', '160u')); // see: http://code.google.com/apis/picasaweb/reference.html#Parameters
    
    try
    {
      $this->albumEntry = $this->picasa->getAlbumEntry($query);
      $this->albumFeed = $this->picasa->getAlbumFeed($query);
    }
    catch (Zend_Gdata_App_Exception $e)
    {
      $this->forward404();
    }
  }
  
  public function executePhoto(sfWebRequest $request)
  {
    // Query Google for details of this photo album via the Zend GData API
    $query_album = new Zend_Gdata_Photos_AlbumQuery();
    $query_album->setUser($this->username);
    $query_album->setAlbumName($request->getParameter('album_name'));
    
    // Also query for the individual photo
    $query = new Zend_Gdata_Photos_PhotoQuery();
    $query->setUser($this->username);
    $query->setAlbumName($request->getParameter('album_name'));
    
    // If there was a photo ID specified as a GET parameter, we know which photo we need to look for.
    if ($request->getParameter('photo_id'))
    {
      $query->setPhotoId($request->getParameter('photo_id'));
    }
    // Otherwise, display the 'placeholder' page which will asynchronously load the first photo.
    else
    {
      try
      {
        $this->albumEntry = $this->picasa->getAlbumEntry($query_album);
        
        return 'Placeholder';
      }
      catch (Zend_Gdata_App_Exception $e)
      {
        $this->forward404();
      }
    }
    
    $query->setImgMax(sfConfig::get('app_hnPhotoAlbumPlugin_photo_display_size', 800));
    
    try
    {
      $this->albumEntry = $this->picasa->getAlbumEntry($query_album);
      
      $this->photoEntry = $this->picasa->getPhotoEntry($query);
      
      $mediaGroup = $this->photoEntry->getMediaGroup()->getContent();
      
      $this->image_src = $mediaGroup[0]->getUrl();
      $this->image_width = $mediaGroup[0]->getWidth();
      $this->image_height = $mediaGroup[0]->getHeight();
      
      $found = false;
      $this->previous = null;
      $this->next = null;
      
      // Loop through the album and find three photos: current, next and previous
      // There might be a better way to do this...
      foreach ($this->picasa->getAlbumFeed($query_album) as $photoEntry)
      {
        if ((string)$photoEntry->getGphotoId() == (string)$this->photoEntry->getGphotoId())
        {
          $found = true;
        }
        else if ($found)
        {
          $this->next = $photoEntry;
          break;
        }
        else
        {
          $this->previous = $photoEntry;
        }
      }
      
      return sfView::SUCCESS;
    }
    catch (Zend_Gdata_App_Exception $e)
    {
      $this->forward404();
    }
  }
  
  public function executeDownload(sfWebRequest $request)
  {
    $response = $this->getResponse();
    
    $query = new Zend_Gdata_Photos_PhotoQuery();
    $query->setUser($this->username);
    $query->setAlbumName($request->getParameter('album_name'));
    $query->setPhotoId($request->getParameter('photo_id'));
    
    try
    {
      $this->photoEntry = $this->picasa->getPhotoEntry($query);
      
      header('Content-Type: '.$this->photoEntry->getContent()->getType());
      header('Content-disposition: attachment; filename='.$this->photoEntry->getTitle());

      echo file_get_contents($this->photoEntry->getContent()->getSrc());
      
      exit();
    }
    catch (Zend_Gdata_App_Exception $e)
    {
      $this->forward404();
    }
  }
}
