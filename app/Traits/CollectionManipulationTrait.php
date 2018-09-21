<?php 

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait CollectionManipulationTrait 
{

	/**
	*	Paginate Results
	*	Access the page query parameter
	*	Limits number of results per page
	*	Calculate the offset by the number of page times perPage
	*	Take only the part of the collection we want
	*	Generate laravel's pagination, which will return aditional info like:
	*		- Number of total results
	*		- Count of results returned
	*		- Results per Page
	*		- Current Page
	*		- Number of Pages generated
	*		- Links containg the link for the next page
	*	Finally, we make sure the paginator includes the rest of the query requests
	* @param collection
	* @param perPage
	*
	* @return paginated collection
	*/
	protected function paginateData(Collection $collection, $perPage=15) 
	{
		// Pages
		$page      = LengthAwarePaginator::resolveCurrentPage();

		// Per Page
		if (request()->has('per_page')) {
			$perPage = (int) request()->per_page;
		}

		// Offset and limiting results
		$offset    = ($page-1)*$perPage;
		$results   = $collection->slice($offset, $perPage)->values();

		// Generating pagination
		$paginator = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
			'path' => LengthAwarePaginator::resolveCurrentPath()
		]);
		$paginator->appends(request()->all());

		return $paginator;
	}

	/**
	*	Cache results
	*	Get the url and use it to cache the data based on it
	* 	Cache Facade expects 3 parameters,
	*	- The name of the cache
	*	- How long it will stay cached
	*	- A function of what it will cache, in this case just return the data
	* @param data
	*/
	protected function cacheResponse($data) 
	{
		$url   = request()->url();
		$query = request()->query();

		// sort query
		ksort($query);

		$newQuery = http_build_query($query);
		$fullUrl  = $url.'?'.$newQuery;

		return Cache::remember($fullUrl, 30/60, function() use ($data) {
			return $data;
		});
	}

}

?>