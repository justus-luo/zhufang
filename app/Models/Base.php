<?php

namespace App\Models;

use App\Models\Traits\Btn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Base extends Model
{
    //软删除
    use SoftDeletes,Btn;
    protected $dates = ['deleted_at'];

    //设置添加黑名单
    protected $guarded = [];

    //数组的合并，并加上HTML的标识前缀
    public function treelevel(array $data, int $pid = 0, string $html = '--', int $level = 0)
    {
        static $arr = [];
        foreach ($data as $val) {
            if ($pid == $val['pid']) {
                $val['html'] = str_repeat($html, $level * 2);
                $val['level'] = $level + 1;
                $arr[] = $val;
                $this->treelevel($data, $val['id'], $html, $val['level']);
            }
        }
        return $arr;
    }

    //数组多层级（递归
    public function subTree(array $data, int $pid = 0)
    {
        $arr = [];
        foreach ($data as $val) {
            if ($pid == $val['pid']) {
                $val['sub'] = $this->subTree($data,$val['id']);
                $arr[] = $val;
            }
        }
        return $arr;
    }
}
