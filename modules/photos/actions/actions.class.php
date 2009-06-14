<?php

/**
 * photos actions.
 *
 * @package    sf_sandbox
 * @subpackage photos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class photosActions extends sfActions
{

  public function preExecute()
  {
    $this->username = sfConfig::get('app_hnPhotoAlbumPlugin_picasa_username', 'tester');
    $this->picasa = new Zend_Gdata_Photos();
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
    $query_album = new Zend_Gdata_Photos_AlbumQuery();
    $query_album->setUser($this->username);
    $query_album->setAlbumName($request->getParameter('album_name'));
    
    $query = new Zend_Gdata_Photos_PhotoQuery();
    $query->setUser($this->username);
    $query->setAlbumName($request->getParameter('album_name'));
    $query->setPhotoId($request->getParameter('photo_id'));
    $query->setImgMax(sfConfig::get('app_hnPhotoAlbumPlugin_photo_display_size', 800));
    
    try
    {
      $this->albumEntry = $this->picasa->getAlbumEntry($query_album);
      
      $this->photoEntry = $this->picasa->getPhotoEntry($query);
      
      $mediaGroup = $this->photoEntry->getMediaGroup()->getContent();
      
      $this->image_src = $mediaGroup[0]->getUrl();
      $this->image_width = $mediaGroup[0]->getWidth();
      $this->image_height = $mediaGroup[0]->getHeight();
/*       print_r($this->photoEntry);die(); */
      
      $found = false;
      $this->previous = null;
      $this->next = null;
      
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
