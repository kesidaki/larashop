<?php

namespace App\Http\Controllers\Website\Admin;

use Illuminate\Http\Request;
use App\Eloquent\ActionRepository;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
	public $actions;

    public function __construct(ActionRepository $resAction) 
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

       $this->actions = $resAction; 
    }
}
