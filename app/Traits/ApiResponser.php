<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;


trait ApiResponser 
{

	/**
	* Return a successfull response, contains the data we will transfer and an HTTP response code
	* @param data
	* @param code
	* 
	* @return json response
	*/
	private function successResponse($data, $code) 
	{
		return response()->json($data, $code);
	}

	/**
	* Returns an error message, with the message generated and it's code
	* @param message
	* @param code
	*
	* @return json response
	*/
	protected function errorResponse($message, $code) 
	{
		return response()->json([
			'error' => $message,
			'code'  => $code
		], $code);
	}

	/**
	*	Returns a collection of items
	*	If collection is empty, it will just return that empty object
	*	Else
	*		It will obtain the transformer (used to change the name of columns)
	*		Filter Data if necessary by using query parameters
	*		Sort Data if asked to by a given attribute, must be executed before transform
	*		Paginate Data
	*		Transform Data, thus changing the columns name
	*	Finally, we will return that collection to the success response function
	* @param collection
	* @param code
	*/
	protected function showAll(Collection $collection, $code=200) 
	{
		if ($collection->isEmpty()) {
			return $this->successResponse(['data'=>$collection], $code);
		}

		$transformer = $collection->first()->transformer;
		# $collection  = $this->filterData($collection, $transformer);
		# $collection  = $this->sortData($collection, $transformer);
		$collection  = $this->paginateData($collection);
		$collection  = $this->transformData($collection, $transformer);
		$collection  = $this->cacheResponse($collection);

		return $this->successResponse($collection, $code);
	}

	/**
	* Will return only 1 result, after transforming it
	* @param model
	* @param code
	*/
	protected function showOne(Model $model, $code=200) 
	{
		# $transformer = $model->transformer;
		# $model       = $this->transformData($model, $transformer);

		return $this->successResponse($model, $code);
	}

	/**
	* Will return a message
	* @param message
	* @param code
	*/
	protected function showMessage($message, $code=200) 
	{
		return $this->successResponse(['data'=>$message], $code);
	}

	/**
	*	Filters Data
	*	Get every query parameter sent at the request by using request()->query()
	*	Loop the parameters
	*	Get their original attribute name
	*	If attribute exists and value is not empty, then filter results by that attribute
	* @param collection
	* @param transformer
	*
	* @return collection
	*/
	protected function filterData(Collection $collection, $transformer) 
	{
		foreach (request()->query() as $query => $value) {
			$attribute = $transformer::originalAttribute($query);

			if (isset($attribute, $value)) {
				$collection = $collection->where($attribute, $value);
			}
		}

		return $collection;
	}

	/**
	*	If attribute sort exists
	*	Get the original name of the sort_by attribute
	*	And then sort results by it
	* @param collection
	* @param transformer
	*
	* @return collection
	*/
	protected function sortData(Collection $collection, $transformer) 
	{
		if (request()->has('sort')) {
			# $attribute  = $transformer::originalAttribute(request()->sort);
			$collection = request()->sort;
		}

		return $collection;
	}

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
	*
	* @return paginated collection, along with links
	*/
	protected function paginateData(Collection $collection) 
	{
		$rules = [
			'per_page' => 'integer|min:2|max:50'
		];

		Validator::validate(request()->all(), $rules);

		// Pages
		$page      = LengthAwarePaginator::resolveCurrentPage();
		$perPage   = 15;
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
	* Transforms the data, thus changing the column's names/format
	* @param data
	* @param transformer
	*
	* @return tranformed collection
	*/
	protected function transformData($data, $transformer) 
	{
		$transformation = fractal($data, new $transformer);

		return $transformation->toArray();
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