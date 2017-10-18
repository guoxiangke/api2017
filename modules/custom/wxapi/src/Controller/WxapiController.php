<?php
/**
 * Created by PhpStorm.
 * User: dale.guo
 * Date: 11/29/16
 * Time: 10:04 AM
 */

/**
 * @file
 * Contains \Drupal\wechat_api\Controller\DemoController.
 */

namespace Drupal\wxapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\comment\CommentInterface;
use Drupal\comment\Entity\Comment;
use Drupal\Component\Utility\Unicode;

class WxapiController extends ControllerBase {
	public function getUid(Request $request) {
		$uid =0;
		if ( 0 === strpos( $request->headers->get( 'Content-Type' ), 'application/json' ) ) {
      $data = json_decode( $request->getContent(), TRUE );
			$user_info['openid'] = $data['openid'];
			$user_info['province'] = $data['province'];
			$user_info['nickname'] = $data['nickName'];
			$user_info['language'] = $data['language'];
			$user_info['sex'] = $data['gender'];
			$user_info['country'] = $data['country'];
			$user_info['city'] = $data['city'];
			$user_info['headimgurl'] = $data['avatarUrl'];
			$user = user_load_by_name($user_info['openid']); //$users = \Drupal::entityTypeManager()->
			if(!$user){//create this wx user!
				$user = wechat_api_save_account($user_info,'wxuser');
			}else{//update profiles
	    	wechat_api_save_profile($user, $user_info);
			}
			$uid = $user->id();
    }
		return new JsonResponse([$uid]);
	}
	//创建一个grace node from fuyin.tv 0点执行
	public function graceInit(){
		$html = file_get_html('https://m.fuyin.tv/movie/detail/movid/2784.html');
    if (!$html) {
        \Drupal::logger(__FUNCTION__)->notice('error get m.fuyin.tv/');
        return new JsonResponse(['error get m.fuyin.tv']);
    }
    $res=[];
    $count=0;
    foreach($html->find('.am-padding-top-xs') as $element) { //init!!!
    	$count ++; if($count<(date('z')-5)) continue;
    // $element = $html->find('.am-padding-top-xs',-1);
    // {
				$title = $element->find('.am-text-truncate',0)->plaintext;//第02天 20170102单独来面对神
				$href = $element->find('a',0)->href;// /movie/player/movid/2784/urlid/45054.html
				preg_match_all('/\d+/', $title,$matches);
				$date = $matches[0][1]; //20170102
				preg_match_all('/\d+/', $href,$matches);
				$video_id = $matches[0][1];// 45054
				//save node!!!
				preg_match_all('/第\d+天 \d+(\S+)/',$title,$matches);
				$title = $matches[1][0];// 45054
				$time_str = implode('-',[substr($date, 0,4),substr($date, 4,2),substr($date, 6,2) ]) . ' 00:00:00';
				$created = strtotime($time_str);

				$fields = ['status'=>1,'created'=>$created];
				$nid = tools_wxapi_get_nid($fields,'grace');
				
				if($nid) {
					$node = Node::load($nid);
					if($node->getTitle() !== $title){
						$node->set('title',$title);
						$node->set('field_fytv_video_id',$video_id);
						$node->save();
			 			\Drupal::logger('title udpated')->notice($title);
					}
			 		// \Drupal::logger($nid.$time_str)->notice($title);
					if($time_str === date("Y-m-d 00:00:00")){//today!!!
						$res[] = $node->id();
					}
				}else {
				 \Drupal::logger('title created')->notice($title);
	       	$newNode = [
	          'type'             => 'grace',
	          'created'          => $created,
	          'changed'          => $created,
	          'uid'              => 46, //恩典365基督之家 https://api.yongbuzhixi.com/user/46
	          'title'            => $title,
	          // An array with taxonomy terms.
	          'field_fytv_video_id' => [$video_id],
	          'body'             => [
	              'summary' => '这里是经文',
	              'value'   => '内容待填充',
	              'format'  => 'full_html',
	          ],
	        ];
	        $node = Node::create($newNode);
	        $node->save();
	        \Drupal::service('path.alias_storage')->save("/node/" . $node->id(), "/grace/$date", "und");
					$res[] = $node->id();
			}
    }
		return new JsonResponse($res);
	}
	//cron every day!!!
	public function graceUpdate(){
		$url = 'http://www.hvsha-tpehoc.com/api/PortalIPS/vwInfoCategory/GetvwInfoByCategoryIDPage?CategoryID=0f4b33a2-be09-4ed5-80d3-c0fc58713680&page=1&pageSize='.'5';
		$str = file_get_contents($url);
		$str=json_decode($str);
    $res=[];
		foreach ($str->data as $key => $item) {
			$time_str = $item->ShowTime; //2017-09-23 00:00:00
			$created = strtotime($time_str);
			$date = date('Ymd',$created);
			$fields = ['status'=>1,'created'=>$created];
			$nid = tools_wxapi_get_nid($fields,'grace');
			if($nid){// load set save
				$node = Node::load($nid);
				if($node->body->summary !==$item->Description){
					$node->body->value = $item->ContentNoHTML;
					$node->body->summary = $item->Description;
					$node->save();
				}
			}else{//create the node!!!
				$new_title = explode('》', $item->Title);
				if(isset($new_title[1])) {
					$new_title=$new_title[1];
				}else{
					$new_title=$item->Title;
				}
				$newNode = [
          'type'             => 'grace',
          'created'          => $created,
          'changed'          => $created,
          'uid'              => 46, //恩典365基督之家 https://api.yongbuzhixi.com/user/46
          'title'            => $new_title,
          // An array with taxonomy terms.
          // 'field_fytv_video_id' => [$video_id],
          'body'             => [
              'summary' => $item->Description,
              'value'   => $item->ContentNoHTML,
              'format'  => 'full_html',
          ],
        ];
        $node = Node::create($newNode);
				$node->save();
	      \Drupal::service('path.alias_storage')->save("/node/" . $node->id(), "/grace/$date", "und");
					
			}

			$res[] = $node->id();
		}
		return new JsonResponse($res);
	}
	public function getWxPost(Request $request){
		$data = array();
    if ( 0 === strpos( $request->headers->get( 'Content-Type' ), 'application/json' ) ) {
      $data = json_decode( $request->getContent(), TRUE );
      $link = $data['link'];// http://mp.weixin.qq.com/s/NjVh2b8woG5Fng5lckJdgw
      $data = mp_getwxcontent($link);
    }
    $response['data'] = $data;
    return new JsonResponse($response);
	}
  /**
   * @param $id == nid == node->id()
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   * @see statistics.php &statistics_get()
   */
	public function getNodeStatistics($id){
		\Drupal::service('statistics.storage.node')->recordView($id); //+1
		$statistics = statistics_get($id);
		$counts = 0;
		if ($statistics) {
			$counts = $statistics['totalcount'];
		}
		return new JsonResponse($counts);
	}

	public function postComment(Request $request){
		$data = array();
    if ( 0 === strpos( $request->headers->get( 'Content-Type' ), 'application/json' ) ) {
      $data = json_decode( $request->getContent(), TRUE );
      $comment = Comment::create([
                'uid'          => $data['uid'],
                'field_name'   => isset($data['field_name'])?$data['field_name']:'comment' ,// 'field_wechat_comments',
                'entity_type'  => isset($data['entity_type'])?$data['entity_type']:'node' ,//node
                'entity_id'    => $data['entity_id'],//nid
                'subject'      => Unicode::truncate( $data['comment_body'], '100', TRUE, TRUE),
                'comment_body' => array(
                    'value'  => $data['comment_body'],
                    'format' => 'plain_text',
                ),
                'status'       => CommentInterface::PUBLISHED,
            ]
        );
        $comment->save();
        \Drupal::logger(__FUNCTION__)->notice('comment->save:' . $comment->id());
        // $url = $comment->toUrl('canonical', array('absolute' => true))->toString();
      // $link = $data['link'];// http://mp.weixin.qq.com/s/NjVh2b8woG5Fng5lckJdgw
      // $data = mp_getwxcontent($link);

    	return new JsonResponse($comment->id());
    }
    return new JsonResponse($response);
	}

}
