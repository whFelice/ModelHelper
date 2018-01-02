<?php
/**
 * User: yinjiangchi
 * Date: 2017/1/12
 * Time: 9:23
 */

namespace WhFelice\ModelHelper;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class ModelHelper extends EloquentModel
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);
    }

    public function newEloquentBuilder($query)
    {
        return new BuilderHelper($query);
    }
}