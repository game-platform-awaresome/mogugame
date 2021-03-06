<?php
/**
 * Created by PhpStorm.
 * User: xmy 280564871@qq.com
 * Date: 2017/5/3
 * Time: 20:52
 */
namespace Admin\Controller;

use Open\Model\ContractModel;

class ContractController extends ThinkController{

	public function _initialize()
	{
		$this->meta_title = "合同管理";
		return parent::_initialize(); // TODO: Change the autogenerated stub
	}

	public function lists($p=1){
		$model = new ContractModel();
		if(!empty(I('get.status'))){
			$map['c.status'] = I("status") == 2 ? ['in',[2,3]] : I('status');
		}
		empty(I('develop_id')) || $map['c.develop_id'] = I("develop_id");
		$data = $model->getDataLists($map,$p);
		$this->assign("list_data",$data['data']);
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

	/**
	 * 确认合同
	 * @param $id
	 * author: xmy 280564871@qq.com
	 */
	public function setContractStatus($id,$end_time=""){
		if(empty($end_time)){
			$this->error("请设置合同终止日期");
		}
		$model = new ContractModel();
		$map['id'] = $id;
		$res = $model->sure_contract($map,$end_time);
		if($res){
			$this->success("确认成功");
		}else{
			$this->error("确认失败");
		}
	}
}