<?php

final class ConduitAPI_file_info_Method extends ConduitAPI_file_Method {

  public function getMethodDescription() {
    return 'Get information about a file.';
  }

  public function defineParamTypes() {
    return array(
      'phid' => 'optional phid',
      'id'   => 'optional id',
    );
  }

  public function defineReturnType() {
    return 'nonempty dict';
  }

  public function defineErrorTypes() {
    return array(
      'ERR-NOT-FOUND'     => 'No such file exists.',
    );
  }

  protected function execute(ConduitAPIRequest $request) {
    $phid = $request->getValue('phid');
    $id   = $request->getValue('id');

    $query = id(new PhabricatorFileQuery())
      ->setViewer($request->getUser());
    if ($id) {
      $query->withIDs(array($id));
    } else {
      $query->withPHIDs(array($phid));
    }

    $file = $query->executeOne();

    if (!$file) {
      throw new ConduitException('ERR-NOT-FOUND');
    }

    $uri = $file->getBestURI();

    return array(
      'id'            => $file->getID(),
      'phid'          => $file->getPHID(),
      'objectName'    => 'F'.$file->getID(),
      'name'          => $file->getName(),
      'mimeType'      => $file->getMimeType(),
      'byteSize'      => $file->getByteSize(),
      'authorPHID'    => $file->getAuthorPHID(),
      'dateCreated'   => $file->getDateCreated(),
      'dateModified'  => $file->getDateModified(),
      'uri'           => PhabricatorEnv::getProductionURI($uri),
    );
  }

}
