<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25
 * Time: 14:30
 */

namespace Admin\Controller;


use Think\Controller;

class ArticleController extends Controller
{
    /**
     * 自动创建model对象
     * @var \Admin\Model\ArticleModel
     */
    private $model = null;

    protected function _initialize()
    {
        $this->model = D('Article');
    }

    /**
     *显示文章列表
     */
    public function index()
    {
        // 获取模糊搜索条件
        $name = I('get.name');
        if ($name) {
            $cont['name'] = ['like', '%' . $name . '%'];
        }
        $rows = $this->model->getListPage($cont);
        $this->assign($rows);
        $this->display();
    }

    /**
     * 添加文章
     */
    public function add()
    {
        if (IS_POST) {
            if ($this->model->create() === false) {
                $this->error(getError($this->model));
            }

            if ($this->model->add() === false) {
                $this->error(getError($this->model));
            } else {
                $this->success('文章添加成功！', U('index'));
            }

        } else {
            $type_model = M('ArticleCategory');
            $types = $type_model->select();
            $this->assign('types', $types);
            $this->display('add');
        }

    }

}