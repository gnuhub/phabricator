<?php

final class PhabricatorApplicationFeed extends PhabricatorApplication {

  public function getBaseURI() {
    return '/feed/';
  }

  public function getShortDescription() {
    return pht('Review Recent Activity');
  }

  public function getIconName() {
    return 'feed';
  }

  public function canUninstall() {
    return false;
  }

  public function getRoutes() {
    return array(
      '/feed/' => array(
        'public/' => 'PhabricatorFeedPublicStreamController',
        '(?P<id>\d+)/' => 'PhabricatorFeedDetailController',
        '(?:query/(?P<queryKey>[^/]+)/)?' => 'PhabricatorFeedListController',
      ),
    );
  }

}
