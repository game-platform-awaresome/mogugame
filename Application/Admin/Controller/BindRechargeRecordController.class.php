<?php
/**
 * Created by PhpStorm.
 * User: xmy 280564871@qq.com
 * Date: 2017/4/8
 * Time: 9:41
 */

namespace Admin\Controller;

use Admin\Model\BindRechargeModel;

class BindRechargeRecordController extends ThinkController{

	public function _initialize()
	{
		$this->meta_title = "绑币充值记录";
		return parent::_initialize(); // TODO: Change the autogenerated stub
	}

	public function lists($p=1){

		$model = new BindRechargeModel();
		empty(I('game_id')) || $map['game_id'] = I('game_id');
		empty(I("account")) || $map['user_account'] = ["like","%".I("account")."%"];
		empty(I("time_start")) || $map['create_time'] = ["between",[strtotime(I("time_start")),empty(I("time_end"))?time():strtotime(I("time_end"))+86400-1]];
		$data = $model->getLists($map,"create_time desc",$p);

		$this->assign("data",$data);

		//分页
		$count = $data['count'];
		$row = 10;
		if($count > $row){
			$page = new \Think\Page($count, $row);
			$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
			$this->assign('_page', $page->show());
		}

		$this->display();
	}
}