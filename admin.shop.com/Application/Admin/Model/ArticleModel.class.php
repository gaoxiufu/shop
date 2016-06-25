<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25
 * Time: 14:30
 */

namespace Admin\Model;


use Think\Model;

class ArticleModel extends Model
{
    protected $patchValidate = true;//开启批量验证
    /**
     * 自动验证
     */
    protected $_validate = [
        ['name', 'require', '文章名不能为空'],
        ['name', '', '文章已存在', self::EXISTS_VALIDATE, 'unique'],
        ['status', '0,1', '状态不合法', self::EXISTS_VALIDATE, 'in'],
        ['sort', 'number', '排序必须为数字'],
        ['article_category_id', '1,2,3,4,5,6,7,8', '文章类别不合法', self::EXISTS_VALIDATE, 'in'],
    ];

    // 自动完成
    protected $_auto = [
        // ['password','md5',self::MODEL_INSERT,'function','register'],
        ['inputtime', NOW_TIME],
    ];

    /**
     *自定义getListPage方法
     * 1.模糊搜索
     * 2.分页
     * 3.重新组装数据
     * @return mixed
     */
    public function getListPage($cont)
    {
        // 获取文章类别表数据
        $model = M('ArticleCategory');
        $datas = $model->select();
        // 获取文章表数据总条数
        $count = $this->where($cont)->count();
        // 调用分页工具
        $page = new \Think\Page($count, 5);
        // 获取分页样式
        $page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        // 获取分页代码
        $html = $page->show();
        // 获取分页数据
        $rows = $this->where($cont)->page(I('get.p', 1), 5)->select();
        // 获取文章表数据
        // $rows = $this->select();
        // 循环文章类别表和文章表，如果文章类别ID相等，就将文章类别名赋值给category字段
        foreach ($rows as &$row) {
            foreach ($datas as $data) {
                if ($data['id'] == $row['article_category_id']) {
                    $row['category'] = $data['name'];
                }
            }
        }
        // 返回重新组织的数据和分页代码
        return compact('rows', 'html');

    }

}