<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/24
 * Time: 16:48
 */

namespace Admin\Model;


use Think\Model;

class SupplierModel extends Model
{
    protected $patchValidate = true;//开启批量验证
    /**
     * 自动验证
     */
    protected $_validate = [
        ['name', 'require', '供货商名称不能为空'],
        ['name', '', '供货商已存在', self::EXISTS_VALIDATE, 'unique'],
        ['status', '0,1', '供货商状态不合法', self::EXISTS_VALIDATE,'in'],
        ['sort', 'number', '排序必须为数字'],
    ];

    /**
     * 分页
     * @param $cond
     * @return mixed
     */
    public function getPage($cond)
    {
        $count = $this->where($cond)->select();
        $page = new \Think\Page($count, 2);
        //$html = $page->show();
        //  dump($html);
        return $this->where($cond)->page(I('get.p', 1), 2)->select();
        //return compact(['rows','html']);
    }


}