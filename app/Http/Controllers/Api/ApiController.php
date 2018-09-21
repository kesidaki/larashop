<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Website\Controller;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct() {
        
    }
}
