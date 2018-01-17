<?php
/**
 * User: yinjiangchi
 * Date: 2018/1/1
 * Time: 12:57
 */

namespace WhFelice\ModelHelper;


use Illuminate\Database\Eloquent\Builder;

class BuilderHelper extends Builder
{
    public function getList($where, $orderBy=[], $take=null, $skip=null,$fields='*')
    {
        $this->formatWhere($where)->select($fields);
        if(!empty($orderBy)){
            $this->formatOrderBy($orderBy);
        }
        if(!empty($skip)){
            $this->skip($skip);
        }
        if(!empty($take)){
            $this->take($take);
        }
        return $this->get();
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
                        default:
                            $query->where($key,$value[0],$value[1]);
                    }
                }else{
                    $query->where($key,'=',$value);
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