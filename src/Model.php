<?php
/**
 * User: yinjiangchi
 * Date: 2017/1/12
 * Time: 9:23
 */

namespace whFelice\ModelHelper;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
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