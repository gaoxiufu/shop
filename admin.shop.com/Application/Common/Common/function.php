<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/24
 * Time: 21:51
 */

/**
 * 把错误信息编辑成有序列表
 * @param \Think\Model $model
 * @return string 有序列表
 */
function getError(\Think\Model $model)
{
    $errors = $model->getError();
    if(!is_array($errors)){
        $errors = [$errors];
    }

    $html = '<ol>';
    foreach($errors as $error){
        $html .= '<li>' . $error . '</li>';
    }
    $html .= '</ol>';
    return $html;

}

