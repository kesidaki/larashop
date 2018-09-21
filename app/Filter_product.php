<?php

namespace App;

use App\Filter;
use App\Product;
use App\FilterValue;
use Illuminate\Database\Eloquent\Model;

class Filter_product extends Model
{
    public function product()
    {
    	// belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
    	return $this->belongsTo(Product::class);
    }

    public function filter()
    {
    	// belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
    	return $this->belongsTo(Filter::class);
    }

    public function value()
    {
    	// belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
    	return $this->belongsTo(FilterValue::class);
    }
}
