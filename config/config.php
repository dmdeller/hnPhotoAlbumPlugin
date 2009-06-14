<?php

// adapted from http://www.symfony-project.org/book/1_2/17-Extending-Symfony#chapter_17_sub_anatomy_of_a_plug_in
//$this->dispatcher->connect('routing.load_configuration', array('hnPhotoAlbumPluginRouting', 'listenToRoutingLoadConfigurationEvent'));

// turns out the above isn't actually necessary; just dropping a routing.yml in config works fine. go figure?
