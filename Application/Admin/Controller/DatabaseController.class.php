<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Think\Db;
use OT\Database;

/**
 * 数据库备份还原控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class DatabaseController extends AdminController{

    /**
     * 数据库备份/还原列表
     * @param  String $type import-还原，export-备份
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index($type = null){
        switch ($type) {
            /* 数据还原 */
            case 'import':
                //列出备份文件列表
                $path = realpath(C('DATA_BACKUP_PATH'));
                $flag = \FilesystemIterator::KEY_AS_FILENAME;
                $glob = new \FilesystemIterator($path,  $flag);

                $list = array();
                foreach ($glob as $name => $file) {
                    if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)){
                        $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                        $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                        $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                        $part = $name[6];

                        if(isset($list["{$date} {$time}"])){
                            $info = $list["{$date} {$time}"];
                            $info['part'] = max($info['part'], $part);
                            $info['size'] = $info['size'] + $file->getSize();
                        } else {
                            $info['part'] = $part;
                            $info['size'] = $file->getSize();
                        }
                        $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                        $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                        $info['time']     = strtotime("{$date} {$time}");

                        $list["{$date} {$time}"] = $info;
                    }
                }
                $title = '数据还原';
                break;

            /* 数据备份 */
            case 'export':
                $Db    = Db::getInstance();
                $list  = $Db->query('SHOW TABLE STATUS');
                $list  = array_map('array_change_key_case', $list);
                $title = '数据备份';
                break;

            case 'in':
                $Db    = Db::getInstance();
                $list  = $Db->query('SHOW TABLE STATUS');
                $list  = array_map('array_change_key_case', $list);
                $title = '数据导入导出';
                break;

            default:
                $this->error('参数错误！');
        }

        //渲染模板
        $this->assign('meta_title', $title);
        $this->assign('list', $list);
        $this->display($type);
    }

    /**
     * 优化表
     * @param  String $tables 表名
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function optimize($tables = null){
        if($tables) {
            $Db   = Db::getInstance();
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = $Db->query("OPTIMIZE TABLE `{$tables}`");

                if($list){
                    $this->success("数据表优化完成！");
                } else {
                    $this->error("数据表优化出错请重试！");
                }
            } else {
                $list = $Db->query("OPTIMIZE TABLE `{$tables}`");
                if($list){
                    $this->success("数据表'{$tables}'优化完成！");
                } else {
                    $this->error("数据表'{$tables}'优化出错请重试！");
                }
            }
        } else {
            $this->error("请指定要优化的表！");
        }
    }

    /**
     * 修复表
     * @param  String $tables 表名
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function repair($tables = null){
        if($tables) {
            $Db   = Db::getInstance();
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = $Db->query("REPAIR TABLE `{$tables}`");

                if($list){
                    $this->success("数据表修复完成！");
                } else {
                    $this->error("数据表修复出错请重试！");
                }
            } else {
                $list = $Db->query("REPAIR TABLE `{$tables}`");
                if($list){
                    $this->success("数据表'{$tables}'修复完成！");
                } else {
                    $this->error("数据表'{$tables}'修复出错请重试！");
                }
            }
        } else {
            $this->error("请指定要修复的表！");
        }
    }

     public function in(){
    			$filenames= $_FILES['excel']['name'];
    			$tmp_name = $_FILES['excel']['tmp_name'];
				$table= $_POST['table'];		    			

    			$filePath = './Uploads/Download/';
        		//注意设置时区
			    $time=date("y-m-d-H-i-s");//去当前上传的时间 
			    //获取上传文件的扩展名
			    $extend=strrchr ($filenames,'.');

			    if($extend=='.xls'){ 

			    //上传后的文件名
			    $name=$time.$extend;
			    $filename=$filePath.$name;//上传后的文件名地址 

			    //move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
			    $result=move_uploaded_file($tmp_name,$filename);//假如上传到当前目录下
		
			    if($result){ 
				    
					import("Org.Util.PHPExcel");

					$PHPExcel=new \PHPExcel();
					//如果excel文件后缀名为.xls，导入这个类
					import("Org.Util.PHPExcel.Reader.Excel5");
					//如果excel文件后缀名为.xlsx，导入这下类
					//import("Org.Util.PHPExcel.Reader.Excel2007");
					//$PHPReader=new \PHPExcel_Reader_Excel2007();

					$PHPReader=new \PHPExcel_Reader_Excel5();
					$PHPExcel=$PHPReader->load($filename);
					$currentSheet=$PHPExcel->getSheet(0);
					$allColumn=$currentSheet->getHighestColumn();
					$allRow=$currentSheet->getHighestRow();
					$Db   = Db::getInstance();$suc=0;$err=0;
					for($currentRow=1;$currentRow<=$allRow;$currentRow++){
						//从哪列开始，A表示第一列
						$str = null;
						for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){
							//数据坐标
							$address=$currentColumn.$currentRow;
							//读取到的数据，保存到数组$arr中
							$arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
							$str .= "'{$arr[$currentRow][$currentColumn]}'";
							if($currentColumn<$allColumn){ 
								$str .= ",";
							}
						}					
						$res = $Db->execute("INSERT INTO `{$table}` VALUES ({$str})");
						if($res){ 
							$suc++;
						}else{ 
							$err++;
						}
					}
					$this->success("导入成功".$suc."条，失败".$err."条。");
			    }

				}else{ 
	 		    	$this->error("只支持xls格式！");
			    }
	       
    }


    public function out($tables = null){
        if($tables) {	
                $Db   = Db::getInstance();
                $data = $Db->query("SELECT * FROM `{$tables}`");
		    	//导入PHPExcel类库，因为PHPExcel没有用命名空间，只能import导入
				import("Org.Util.PHPExcel");
				import("Org.Util.PHPExcel.Writer.Excel5");
				import("Org.Util.PHPExcel.IOFactory.php");

				$filename="{$tables}";
				//$headArr=array("用户名","密码");
				$this->getExcel($filename,$headArr,$data);

        } else {
            $this->error("请指定要导出的表！");
        }
    }


    private	function getExcel($fileName,$headArr,$data){
			//对数据进行检验
		   // if(empty($data) || !is_array($data)){
		     //   die("data must be a array");
		   // }
		    //检查文件名
		    if(empty($fileName)){
		        exit;
		    }

		    $date = date("Y_m_d",time());
		    $fileName .= "_{$date}.xls";

			//创建PHPExcel对象，注意，不能少了\
		    $objPHPExcel = new \PHPExcel();
		    $objProps = $objPHPExcel->getProperties();
			
		    //设置表头
		    $key = ord("A");
		    foreach($headArr as $v){
		        $colum = chr($key);
		        $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
		        $key += 1;
		    }
		    
		    $column = 2;
		    $objActSheet = $objPHPExcel->getActiveSheet();
		    foreach($data as $key => $rows){ //行写入
		        $span = ord("A");
		        foreach($rows as $keyName=>$value){// 列写入
		            $j = chr($span);
		            $objActSheet->setCellValue($j.$column, $value);
		            $span++;
		        }
		        $column++;
	    }

		    $fileName = iconv("utf-8", "gb2312", $fileName);
		    //重命名表
		   	// $objPHPExcel->getActiveSheet()->setTitle('test');
		    //设置活动单指数到第一个表,所以Excel打开这是第一个表
		    $objPHPExcel->setActiveSheetIndex(0);
		    header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;filename=\"$fileName\"");
			header('Cache-Control: max-age=0');

		  	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		    $objWriter->save('php://output'); //文件通过浏览器下载

		    exit;
		}

    /**
     * 删除备份文件
     * @param  Integer $time 备份时间
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del($time = 0){
        if($time){
            $name  = date('Ymd-His', $time) . '-*.sql*';
            $path  = realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR . $name;
            array_map("unlink", glob($path));
            if(count(glob($path))){
                $this->success('备份文件删除失败，请检查权限！');
            } else {
                $this->success('备份文件删除成功！');
            }
        } else {
            $this->error('参数错误！');
        }
    }

    /**
     * 备份数据库
     * @param  String  $tables 表名
     * @param  Integer $id     表ID
     * @param  Integer $start  起始行数
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function export($tables = null, $id = null, $start = null){
        if(IS_POST && !empty($tables) && is_array($tables)){ //初始化
            //读取备份配置
            $config = array(
                'path'     => realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR,
                'part'     => C('DATA_BACKUP_PART_SIZE'),
                'compress' => C('DATA_BACKUP_COMPRESS'),
                'level'    => C('DATA_BACKUP_COMPRESS_LEVEL'),
            );

            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if(is_file($lock)){
                $this->error('检测到有一个备份任务正在执行，请稍后再试！');
            } else {
                //创建锁文件
                file_put_contents($lock, NOW_TIME);
            }

            //检查备份目录是否可写
            is_writeable($config['path']) || $this->error('备份目录不存在或不可写，请检查后重试！');
            session('backup_config', $config);

            //生成备份文件信息
            $file = array(
                'name' => date('Ymd-His', NOW_TIME),
                'part' => 1,
            );
            session('backup_file', $file);

            //缓存要备份的表
            session('backup_tables', $tables);

            //创建备份文件
            $Database = new Database($file, $config);
            if(false !== $Database->create()){
                $tab = array('id' => 0, 'start' => 0);
                $this->success('初始化成功！', '', array('tables' => $tables, 'tab' => $tab));
            } else {
                $this->error('初始化失败，备份文件创建失败！');
            }
        } elseif (IS_GET && is_numeric($id) && is_numeric($start)) { //备份数据
            $tables = session('backup_tables');
            //备份指定表
            $Database = new Database(session('backup_file'), session('backup_config'));
            $start  = $Database->backup($tables[$id], $start);
            if(false === $start){ //出错
                $this->error('备份出错！');
            } elseif (0 === $start) { //下一表
                if(isset($tables[++$id])){
                    $tab = array('id' => $id, 'start' => 0);
                    $this->success('备份完成！', '', array('tab' => $tab));
                } else { //备份完成，清空缓存
                    unlink(session('backup_config.path') . 'backup.lock');
                    session('backup_tables', null);
                    session('backup_file', null);
                    session('backup_config', null);
                    $this->success('备份完成！');
                }
            } else {
                $tab  = array('id' => $id, 'start' => $start[0]);
                $rate = floor(100 * ($start[0] / $start[1]));
                $this->success("正在备份...({$rate}%)", '', array('tab' => $tab));
            }

        } else { //出错
            $this->error('参数错误！');
        }
    }

    /**
     * 还原数据库
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function import($time = 0, $part = null, $start = null){
        if(is_numeric($time) && is_null($part) && is_null($start)){ //初始化
            //获取备份文件信息
            $name  = date('Ymd-His', $time) . '-*.sql*';
            $path  = realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR . $name;
            $files = glob($path);
            $list  = array();
            foreach($files as $name){
                $basename = basename($name);
                $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
                $gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
                $list[$match[6]] = array($match[6], $name, $gz);
            }
            ksort($list);

            //检测文件正确性
            $last = end($list);
            if(count($list) === $last[0]){
                session('backup_list', $list); //缓存备份列表
                $this->success('初始化完成！', '', array('part' => 1, 'start' => 0));
            } else {
                $this->error('备份文件可能已经损坏，请检查！');
            }
        } elseif(is_numeric($part) && is_numeric($start)) {
            $list  = session('backup_list');
            $db = new Database($list[$part], array(
                'path'     => realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR,
                'compress' => $list[$part][2]));

            $start = $db->import($start);

            if(false === $start){
                $this->error('还原数据出错！');
            } elseif(0 === $start) { //下一卷
                if(isset($list[++$part])){
                    $data = array('part' => $part, 'start' => 0);
                    $this->success("正在还原...#{$part}", '', $data);
                } else {
                    session('backup_list', null);
                    $this->success('还原完成！');
                }
            } else {
                $data = array('part' => $part, 'start' => $start[0]);
                if($start[1]){
                    $rate = floor(100 * ($start[0] / $start[1]));
                    $this->success("正在还原...#{$part} ({$rate}%)", '', $data);
                } else {
                    $data['gz'] = 1;
                    $this->success("正在还原...#{$part}", '', $data);
                }
            }

        } else {
            $this->error('参数错误！');
        }
    }
}
