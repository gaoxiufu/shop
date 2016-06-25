<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25
 * Time: 9:32
 */

namespace Admin\Controller;


use Think\Controller;

class BrandController extends Controller
{
    /**
     * @var \Admin\Model\SupplierModel
     */
    private $model = null;
    protected function _initialize()
    {
        $this->model = D('Brand');
    }

}