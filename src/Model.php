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

    public function getList($where, $orderBy=[], $take=null, $skip=null)
    {
        $query = $this->formatWhere($where)->select();
    }

    protected function formatWhere($where)
    {
        return $this->where(function($query) use ($where){
            foreach($where as $key=>$value){
                if(is_array($value)){
                    switch ($value[0]){
                        case 'in':
                            $query->whereIn($key,$value[1]);
                            break;
                        case 'notin':
                            $query->whereNotIn($key,$value[1]);
                            break;
                        case 'or':
                            $query->orWhere($value[1][0],$value[1][1]);
                            break;
                        case 'between':
                            $query->whereBetween($key,$value[1]);
                    }
                }
            }
        });
    }

    public function formatOrderBy($orderBy=[])
    {
        return $this->orderBy(function($query) use ($orderBy){
            foreach($orderBy as $key=>$value){
                if(!in_array($value,['asc','desc'])){
                    continue;
                }
                $query->orderby($key,$value);
            }
        });
    }

    public function getOne($id)
    {
        return $this->find($id);
    }
}