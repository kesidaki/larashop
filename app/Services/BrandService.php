<?php

namespace App\Services;

use App\Eloquent\BrandRepository;
use Illuminate\Http\Request;

class BrandService
{
    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return void
     */
    public function getByName()
    {
        return $this->brandRepository->allBy('name', 'asc');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function createBrand(Request $request)
    {
        $data = $request->all();
        return $this->brandRepository->create($data);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateBrand(Request $request)
    {
        $id = $request->id;

        $action = $request->submit;

        if ($action == 'edit') {
            $data = [
                'name'        => $request->name,
                'slug'        => $request->slug,
                'description' => $request->description
            ];

            $this->brandRepository->update($data, $id);
        }
        else if ($action == 'delete')
        {
            $this->brandRepository->delete($id);
        }
    }
}