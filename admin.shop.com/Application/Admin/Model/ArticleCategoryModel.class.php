<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25
 * Time: 11:40
 */

namespace Admin\Model;


use Think\Model;

class ArticleCategoryModel extends Model
{
    protected $patchValidate = true;//开启批量验证
    /**
     * 自动验证
     */
    protected $_validate = [
        ['name', 'require', '文章类名不能为空'],
        ['name', '', '文章类已存在', self::EXISTS_VALIDATE, 'unique'],
        ['status', '0,1', '状态不合法', self::EXISTS_VALIDATE, 'in'],
        ['sort', 'number', '排序必须为数字'],
        ['is_help', '0,1', '是否帮助类文档', self::EXISTS_VALIDATE, 'in'],
    ];


    /**
     * 分页
     * @param $cond
     * @return mixed
     */
    public function getPage($cond)
    {
        $count = $this->where($cond)->count();  // 获取中条数
        // 分页工具
        $page = new  \Think\Page($count, 5);
        $page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $html = $page->show();
        $rows = $this->where($cond)->page(I('get.p', 1), 5)->select();
        return compact(['rows', 'html']);
    }

}