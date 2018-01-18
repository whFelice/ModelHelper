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

    public function saveInfo($saveArr)
    {
        if(!empty($saveArr[$this->primaryKey])){
            $this->exists = true;
            $keyArr[$this->primaryKey] = $saveArr[$this->primaryKey];
            //只同步主键到original attributes，用作更新时主键
            $this->setRawAttributes($keyArr,true);
        }
        $this->fill($saveArr);
        return parent::save();
    }
}