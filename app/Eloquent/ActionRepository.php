<?php
namespace App\Eloquent;

use DB;
use App\Action;
use Carbon\Carbon;
use App\Eloquent\Repository;
use App\Interfaces\RepositoryInterface;

class ActionRepository extends Repository 
{ 

	function model() 
	{ 
		return 'App\Action';
	}

	/**
	* Return Statistics for Visits
	* @param forDays
	*
	* @return array
	*/
	public function statVisits($forDays) 
	{
		$labels  = [];
		$values  = [];
		$from    = Carbon::now()->subDays(($forDays) ? $forDays : 30)->format('Y-m-d H:i:s');

		$statistics = Action::select('created_at', 'url', DB::raw('COUNT(url) as count'));
		$statistics->where('type', '=', 'visit');
		$statistics->where('created_at', '>=', $from);
		$statistics->groupBy('url', 'visitor');
		$statistics->orderBy('count', 'desc');

		$results = $statistics->get();

		foreach ($results as $row) {
			array_push($labels, $row->url);
			array_push($values, $row->count);
		}

		return [
			'label' => $labels,
			'value' => $values
		];
	}

	/**
	* Return Product Statistics
	* @param id
	* @param forDays
	*
	* @return collection
	*/
	public function statProduct($id, $forDays) 
	{
		$labels  = [];
		$values  = [];
		$from    = Carbon::now()->subDays(($forDays) ? $forDays : 30)->format('Y-m-d H:i:s');
		$to      = Carbon::now()->format('Y-m-d H:i:s');

		// Visits
		// Add to Cart
		// Remove from Cart
		return Action::select('type', DB::raw('COUNT(id) as count'))
					  ->where('product_id', '=', $id)
					  ->where('created_at', '>=', $from)
					  ->groupBy('type')
					  ->get();
	}

	/**
	* Most Viewed Products
	* @param forDays
	* @param limit
	*
	* @return collection
	*/
	public function mostViewedProducts($forDays=30, $limit=10) 
	{
		$from    = Carbon::now()->subDays($forDays)->format('Y-m-d H:i:s');

		$viewed = Action::select('*', DB::raw('COUNT(id) as count'));
		$viewed->where('type', 'view');
		$viewed->whereNotNull('product_id');
		$viewed->where('created_at', '>=', $from);
		$viewed->groupBy('product_id');
		$viewed->orderBy('count', 'desc');
		$viewed->limit($limit);
		$viewed->with('product');

		return $viewed->get();
	}
}

?>