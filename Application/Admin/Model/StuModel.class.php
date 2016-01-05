<?php
// +----------------------------------------------------------------------
// | Author: 陈强
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 学生信息模型
 * @author 陈强
 */
class StuModel extends Model{

    protected $_validate = array(
        array('csdm', 'require', '出生地不能为空'),
        array('hkszd', 'require', '户口所在地不能为空'),
        array('xbqsh', 'require', '寝室号不能为空'),
        array('lxdh', 'require', '联系电话不能为空'), 
        array('dzxx','/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/','电子邮箱不正确','regx'),  
        array('xbsjhm','/^0?\\d{11}$/','手机号码不正确','regx'),
        array('lxdh','/^(0?1[358]\d{9})$|^((0(10|2[1-3]|[3-9]\d{2}))?[1-9]\d{6,7})$/','联系方式不正确','regx'),
        array('zjxy','/^[1-9]\d{5}$/','邮政编码不正确','regx'),
        array('xbqq','/^[1-9]*[1-9][0-9]*$/','QQ不正确','regx'),
    );

    protected $_auto = array(
        // array('model', 'arr2str', self::MODEL_BOTH, 'function'),
        // array('model', null, self::MODEL_BOTH, 'ignore'),
        // array('model_sub', 'arr2str', self::MODEL_BOTH, 'function'),
        // array('model_sub', null, self::MODEL_BOTH, 'ignore'),
        // array('type', 'arr2str', self::MODEL_BOTH, 'function'),
        // array('type', null, self::MODEL_BOTH, 'ignore'),
        // array('allow_publish', '1', self::MODEL_BOTH),
        // array('display', '1', self::MODEL_BOTH),
        // array('type', '2', self::MODEL_BOTH),
        // array('model', '2', self::MODEL_BOTH),
        // array('model_sub', '2', self::MODEL_BOTH),
    );

}
