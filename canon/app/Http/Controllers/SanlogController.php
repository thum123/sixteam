<?php
namespace App\Http\Controllers;
use DB;
session_start();
class SanlogController extends Controller
{

		private $appid;
		private $token;	
		private $return_uri;
		private $access_token;
		private $url = 'http://open.51094.com/user/auth.html';

		function __construct(){
			// parent::__construct();
		$this->appid = "157adccbd0d869";
		$this->token = "6b48db208af7e51b741c53212c847d81";
		}
		function me( $code ){
		#$this->getAccessToken();
		$params=array(
				'type'=>'get_user_info',
				'code'=>$code,
				'appid'=>$this->appid,
				'token'=>$this->token
			);
		return $this->http( $params );
		}

	/*private function getAccessToken(){
		if( !isset( $_SESSION['open_51094_access_token'] ) || empty( $_SESSION['open_51094_access_token'] ) ){
			$params = array(
					'type'=>'get_access_token',
					'appid'=>$this->appid,
					'token'=>$this->token
				);
			$ret = $this->http( $params );
			if( isset( $ret['access_token'] ) && !empty( $ret['access_token'] ) &&  32 == strlen( $ret['access_token'] ) ){
				$this->access_token = $ret['access_token'];
				$_SESSION['open_51094_access_token'] = $ret['access_token'];
			}else{
				exit('time out');
			}
		}else{
			$this->access_token = $_SESSION['open_51094_access_token'];
		}
	}*/

	private function http( $postfields='', $method='POST', $headers=array()){
		$ci=curl_init();
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ci, CURLOPT_TIMEOUT, 30);
		if($method=='POST'){
			curl_setopt($ci, CURLOPT_POST, TRUE);
			if($postfields!='')curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
		}
		$headers[]="User-Agent: 51094PHP(open.51094.com)";
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ci, CURLOPT_URL, $this->url);
		$response=curl_exec($ci);
		curl_close($ci);
		$json_r=array();
		if(!empty( $response ))$json_r=json_decode($response, true);
		return $json_r;
	}

	public function back()
	{
		$code = $_GET['code'];
		$data = $this -> me($code);
		$res=DB::table('users')->where('user_nickname',"$data[name]")->first();
		if($res)
		{
			$_SESSION['username']=$data['name'];
			$_SESSION['u_id']=$res['user_id'];
			$_SESSION['img'] = isset($res['user_img'])?$res['user_img']:'0';
			echo "<script>alert('欢迎回来".$data['name']."')</script>";
			// Redirect::action('IndexController@index');
			header("refresh:0;url=index");
		}
		else
		{
			$sta = DB::insert("insert into users (user_name,user_nickname,user_img) values ('$data[name]','$data[name]','$data[img]')");
			if($sta)
			{
					$da=DB::table('users')->where('user_nickname',"$data[name]")->first();
					$_SESSION['username']=$data['name'];
					$_SESSION['u_id']=$da['user_id'];
					$_SESSION['img'] = isset($da['user_img'])?$da['user_img']:'0';
					echo "<script>alert('登陆成功".$data['name']."')</script>";
					//Redirect::action('IndexController@index');
					header("refresh:0;url=index");
			}
			else
			{
				echo "<script>alert('登陆失败重新登陆".$data['name']."')</script>";
				// Redirect::action('IndexController@index');
				header("refresh:0;url=index");
			}
		}
	}

}


?>