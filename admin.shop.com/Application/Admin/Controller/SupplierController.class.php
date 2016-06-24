<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/24
 * Time: 16:47
 * https://note.wiz.cn/pages/manage/biz/applyInvited.html?code=ucv7m6 未知比较群组
 */

namespace Admin\Controller;


use Think\Controller;

class SupplierController extends Controller
{
    /**
     * 供货商信息展示
     * 1.实现模糊查询
     *2.数据分页
     */
    public function index()
    {
        $name = I('get.name');// 获取搜索框的内容
        $cond['status'] = ['egt', 0];// 排除状态小于等于0 的数据
        if ($name) {
            // 如果搜索框有内容，就使用like模糊查询
            $cond['name'] = ['like', '%' . $name . '%'];
        }
        $model = D('Supplier');
        $rows = $model->where($cond)->select();
        // $rows = $model->select();
        //$rows = $model->getPage($cond);
        $this->assign('rows', $rows);
        $this->display();
    }

    /**
     * 1.新增供货商信息
     * 2.修改供货商信息
     */
    public function add()
    {
        if (IS_POST) {
            $model = D('Supplier');
            if ($model->create() === false) {
                $this->error(getError($model));
            }

            if ($model->add() === false) {
                $this->error(getError($model));
            } else {
                $this->success('添加成功', U('index'));
            }

        } else {
            $this->display();
        }

    }


    /**
     * 修改供货商信息
     * @param $id
     */
    public function edit($id)
    {

        $model = D('Supplier');
        if (IS_POST) {
            if($model->create()===false){
                $this->error(getError($model));
            }
          //  dump($model->data());
            if($model->save()===false){
                $this->error(getError($model));
            }else{
                $this->success('修改成功',U('index'));
            }

        } else {
            // 回显数据
            $row = $model->find($id);
            $this->assign($row);
            $this->display('add');
        }
    }

    /**
     * 逻辑删除信息
     * @param $id
     */
    public function remove($id){
        $model=D('Supplier');
        $data=[
            'id'=>$id,
            'status'=>-1,
            'name'=>['exp','concat(name,"_del")']
        ];

        if($model->setField($data)===false){
            $this->error(getError($model));
        }else{
            $this->success('删除成功',U('index'));
        }

    }


}