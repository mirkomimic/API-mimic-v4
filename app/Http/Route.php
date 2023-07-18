<?php

namespace App\Http;

use AlEmran\PHPDependencyInjection\DependencyInjectionContainer;

class Route
{
  public static function get(string $route, array $callback)
  {
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
      $params = [];
      $paramKey = '';
      $uri = (new self)->getUri();
      $class = $callback[0];
      $method = $callback[1];

      // poredi uri sa paternom
      if (preg_match('/^[a-z0-9_-]+\/[a-z0-9_-]+$/', $uri)) {

        // poredi uri sa rutom
        if ((new self)->compareUriAndRoute($uri, $route)) {
          // uzima string izmedju zagrada u ruti
          preg_match_all("/(?<={).+?(?=})/", $route, $matches);
          foreach ($matches[0] as $key) {
            $paramKey = $key; // id
          }

          // uzima vrednost iz uri i pravi parametre za prosledjivanje
          $value = (new self)->getValueParamFromUri($uri);
          $params[$paramKey] = $value;

          $container = DependencyInjectionContainer::instance();
          $container->call($class . '@' . $method, $params);
          exit;
        }
      } elseif (preg_match('/^[a-z0-9]+$/', $uri)) {

        if ((new self)->compareUriAndRoute($uri, $route)) {
          $container = DependencyInjectionContainer::instance();
          $container->call($class . '@' . $method);
          exit;
        }
      } elseif (empty($uri)) {

        if ((new self)->compareUriAndRoute($uri, $route)) {
          $container = DependencyInjectionContainer::instance();
          $container->call($class . '@' . $method);
          exit;
        }
      }
    }
  }

  public static function post(string $route, array $callback)
  {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      $params = [];
      $paramKey = '';
      $uri = (new self)->getUri();
      $class = $callback[0];
      $method = $callback[1];

      // poredi uri sa paternom
      if (preg_match('/^[a-z0-9_-]+\/[a-z0-9_-]+$/', $uri)) {

        // poredi uri sa rutom
        if ((new self)->compareUriAndRoute($uri, $route)) {
          // uzima string izmedju zagrada u ruti
          preg_match_all("/(?<={).+?(?=})/", $route, $mathes);
          foreach ($mathes[0] as $key) {
            $paramKey = $key; // id
          }

          // uzima vrednost iz uri i pravi parametre za prosledjivanje
          $value = (new self)->getValueParamFromUri($uri);
          $params[$paramKey] = $value;

          $container = DependencyInjectionContainer::instance();
          $container->call($class . '@' . $method, $params);
          exit;
        }
      } elseif (preg_match('/^[a-z0-9]+$/', $uri)) {

        if ((new self)->compareUriAndRoute($uri, $route)) {
          $container = DependencyInjectionContainer::instance();
          $container->call($class . '@' . $method);
          exit;
        }
      } elseif (empty($uri)) {
        if ((new self)->compareUriAndRoute($uri, $route)) {
          $container = DependencyInjectionContainer::instance();
          $container->call($class . '@' . $method);
          exit;
        }
      }
    }
  }

  private function getUri()
  {
    $home = '/MirkoXAMPP/API-mimic/v5/';
    $uri = str_replace($home, '', $_SERVER['REQUEST_URI']);
    if (str_contains($uri, '?')) {
      $uri = substr($uri, 0, strpos($uri, "?"));
    }
    return $uri;
  }

  private function getValueParamFromUri($uri)
  {
    $array = explode('/', $uri);
    return $array[1];
  }

  private function getKeyParamFromUri($uri)
  {
    $array = explode('/', $uri);
    return $array[0];
  }

  private function compareUriAndRoute($uri, $route)
  {
    if (str_contains($route, '/') && str_contains($uri, '/')) {
      $uriArray = explode('/', $uri);
      $routeArray = explode('/', $route);

      $route = $routeArray[0] . '/' . $uriArray[1];

      return $uri == $route ? true : false;
    } elseif ($route !== '' && $uri !== '') {
      return $uri == $route ? true : false;
    } elseif ($route == '' && $uri == '') {
      return true;
    }
  }
}
