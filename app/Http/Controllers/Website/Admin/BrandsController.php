<?php

namespace App\Http\Controllers\Website\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Website\Controller;
use App\Services\BrandService;
use App\Http\Requests\BrandRequest;

class BrandsController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    /**
    * Brands Page
    * @param BrandService $brandService
    */
    public function brands(BrandService $brandService) 
    {
        return view('admin.brands', [
            'brands' => $brandService->getByName(),
        ]);
    }

    /**
    * Create Brand
    * @param request
    * @param BrandService $brandService
    */
    public function createBrand(BrandRequest $request, BrandService $brandService) 
    {
        $brandService->createBrand($request);
        return redirect()->back();
    }

    /**
    * Update or Delete Brand
    * @param request
    * @param BrandService $brandService
    */
    public function updateBrand(BrandRequest $request, BrandService $brandService) 
    {
        $brandService->updateBrand($request);

        return redirect()->back();
    }
}