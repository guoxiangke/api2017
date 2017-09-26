<?php
namespace Drupal\wechat_sso_client\Controller;
/**
 * Created by PhpStorm.
 * User: dale.guo
 * Date: 1/4/17
 * Time: 2:22 PM
 */
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SsoController extends ControllerBase
{
	public function ssoResponse()
	{
		$openid = \Drupal::request()->query->get('openid');
		$access_token = \Drupal::request()->query->get('token');
        $destination = \Drupal::request()->query->get('dest');
		/* @var $account User */
		$account = user_load_by_name($openid);
		if (!$account) {
			$uid = 4;
			$weObj = _mp_service_init_wechat($uid);
//			$user_info = $weObj->getUserInfo($openid);
			$user_info = $weObj->getOauthUserinfo($access_token, $openid);
			$account = wechat_api_save_account($user_info);
			user_login_finalize($account);
			drupal_set_message('登记会员成功,左上角关闭本页,回复编码获取资源吧!','status');
			\Drupal::logger('SSO login & create account')->notice($account->id().'login success');
		}else {
			user_login_finalize($account);
			\Drupal::logger('SSO login')->notice($account->id().' : login success');
		}
        $url = Url::fromUri('internal:/'.$destination);
		return new RedirectResponse($url->toString());//Url::fromRoute('<front>')->toString()
	}
}
