<?php

namespace App\Controllers;

use App\Http\Url;
use App\Http\Request;
use App\Http\Response;
use App\Models\Product;
use App\Utilities\Query;
use App\Utilities\Paginator;
use App\Resources\ProductResource;
use App\Controllers\Auth\SessionController;

class ProductController
{

  public static function index(Request $request)
  {
    // echo 'ovde';
    // $params = Url::getParams();
    $page = $request()->page ?? 1;

    $products = Product::filter($request());
    $products = ProductResource::collection($products);
    $products = Paginator::paginate($products, $page, 5);

    $response = new Response();
    $response->set_httpStatusCode(200);
    $response->set_success(true);
    $response->set_data($products);
    $response->send();
    exit;
  }

  public static function store(Request $request)
  {

    $accesstoken = $_SERVER['HTTP_AUTHORIZATION'];

    if (!SessionController::check($accesstoken)) {
      $response = new Response();
      $response->set_httpStatusCode(401);
      $response->set_success(false);
      $response->set_message("Access token not valid or it has expired");
      $response->send();
      exit;
    }

    $product = Product::create([
      'name' => $request()->name,
      'price' => $request()->price
    ]);

    $data = new ProductResource($product);

    $response = new Response();
    $response->set_httpStatusCode(200);
    $response->set_success(true);
    $response->set_data($data);
    $response->set_message("Product Added");
    $response->send();
    exit;
  }

  public static function checkIfProductsExists($stdClass)
  {
    // $productIds = array_column($array, 'id');
    // var_dump($stdClass);
    $productIds = [];
    foreach ($stdClass as $class) {
      $productIds[] = $class->id;
    }
    $query = Query::select('id')->table('products')->getArray();
    $query = array_column($query, 'id');

    if (!empty(array_diff($productIds, $query))) {
      return false;
    }

    return true;
  }
}
