<?php
namespace wechat;

trait WxTrait{

	/**
     * 判断微信请求是否正确
     * @param array $wx_result
     * @return blooean
     */
	public function CheckError($wx_result){
		return isset($wx_result['errcode'])?true:false;
	}


}