<?php

namespace App\Services;

use App\Eloquent\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\CollectionManipulationTrait;

class ProductService
{
    use CollectionManipulationTrait;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Prepare products data for the products index page
     *
     * @param string $cat1
     * @param string $cat2
     * @param string $cat3
     * @param Request $request
     * @return array
     */
    public function prepareProductsIndex($cat1, $cat2, $cat3, Request $request): array
    {
        $categories    = $this->prepareCategories($cat1, $cat2, $cat3); 
        $subcategories = $this->prepareSubcategories($request);
        $products      = $this->getProducts($categories, $subcategories, '', $request);
        $prices        = $this->productRepository->getMinMax($products);

        // create filters data
        $ufProducts = $this->productRepository->getUnfilteredProducts($categories);
        $subCats    = $this->productRepository->getSubcategories($ufProducts, '');
        $brands     = $this->productRepository->getBrands($ufProducts);

        return [
            'categories'      => implode('/' , $categories),
            'products'        => $this->prepareResponse($products),
            'active'          => [
                'subcategories'   => implode(',' , $subcategories),
                'brand'           => $request->brand,
                'minPrice'        => ($request->minPrice != '') ? $request->minPrice : $prices['minPrice'],
                'maxPrice'        => ($request->maxPrice != '') ? $request->maxPrice : $prices['maxPrice'],
            ],
            'filter'          => [
                'prices'          => $prices,
                'avSubcategories' => $subCats,
                'brands'          => $brands
            ]
        ];
    }

    /**
     * Search for products by term
     *
     * @param string $term
     * @param Request $request
     * @return Collection
     */
    public function searchProducts($term, Request $request)
    {
        $products = $this->getProducts([], [], $term, $request);

        return $this->prepareResponse($products);
    }

    /**
     * Get products
     *
     * @param array $categories
     * @param array $subcategories
     * @param string $search
     * @param Request $request
     * @return Collection
     */
    public function getProducts($categories, $subcategories, $search = '', Request $request)
    {
        return $this->productRepository->getProducts($categories, $subcategories, $search, $request);
    }

    /**
     * Find product by slug
     *
     * @param int $slug
     * @return Collection
     */
    public function findProduct($slug)
    {
        return $this->productRepository->getProduct($slug);
    }

    /**
     * Get and check product's information based on id and price
     *
     * @param int $productID
     * @param float $price
     * @return Object
     */
    public function checkProduct($productID, $price)
    {
        return $this->productRepository->findForIdAndprice($productID, $price);
    }

    /**
     * Will return the most recent Products
     *
     * @param Request $request
     * @return void
     */
    public function getRecentProducts(Request $request)
    {
        $request->request->add(['sort' => 'recent']);
        $products = $this->productRepository->getProducts([], [], '', $request);

        return $this->prepareResponse($products);
    }

    /**
     * Prepare the categories array
     *
     * @param string $cat1
     * @param string $cat2
     * @param string $cat3
     * @return array
     */
    private function prepareCategories($cat1, $cat2, $cat3): array
    {
        $categories = [];

        if ($cat1 != '') {
            array_push($categories, $cat1);
        }
        if ($cat2 != '') {
            array_push($categories, $cat2);
        }
        if ($cat3 != '') {
            array_push($categories, $cat3);
        }

        return $categories;
    }

    /**
     * Create array for subcategories
     *
     * @param Request $request
     * @return array
     */
    private function prepareSubcategories(Request $request): array
    {
        $subcategories = [];

        if ($request->has('categories')) {
            $subcategories = explode(',',$request->categories);
        }
        
        return $subcategories;
    }

    /**
     * Cache and paginate data before sending to view
     *
     * @param Collection $collection
     * @return Collection
     */
    private function prepareResponse(Collection $collection)
    {
        $this->cacheResponse($collection);
        return $this->paginateData($collection);
    }
}