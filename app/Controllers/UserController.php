<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\User;
use App\Http\Response;

class UserController
{

  public static function store(Request $request)
  {
    User::create([
      'firstname' => $request()->firstname,
      'lastname' => $request()->lastname,
      'phone' => $request()->phone,
      'email' => $request()->email,
    ]);

    $response = new Response();
    $response->set_httpStatusCode(200);
    $response->set_success(true);
    $response->set_message("User registered!");
    $response->send();
  }
}
