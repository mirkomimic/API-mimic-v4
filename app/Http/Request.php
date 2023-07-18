<?php

namespace App\Http;

class Request
{

  public function __invoke()
  {
    return $this->getArray();
  }

  public function getArray()
  {
    $request = file_get_contents('php://input');
    $request = json_decode($request);
    $params = Url::getParams();
    $params = (object) $params;

    $request = (object) array_merge(
      (array) $request,
      (array) $params
    );

    return $request;
  }
}
