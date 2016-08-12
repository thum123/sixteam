<?php

namespace App\Http\Controllers;
use DB;
class CourseController extends Controller
{
    public function course(){
        //学院
        $sql="select c_id,c_name from college where c_del=0";
        $arr=DB::select($sql);
        //专业
        $sql="select * from direction";
        $zhuan=DB::select($sql);
        //类型
        // var_dump($zhuan);die;
        $lei=DB::table('type')->get();
        //全部试题
        $shi=DB::table('college_questions')->simplePaginate(12);
        return view('course/course',['arr'=>$arr,'zhuan'=>$zhuan,'shi'=>$shi,'lei'=>$lei]);
    }
    public function sou(){
        if(!empty($_POST['leixing'])){
            $type= $_POST['leixing'];
        }else{
            $type='';
        }
        if($type==0){
            $sql="select d_id,d_name from direction";
        }else {
            $sql = "select d_id,d_name from direction where college_id=".$type;
        }
        $zhuan=DB::select($sql);
        //print_r($zhuan);die;
        //根据学院的id查询学院的名称
        $college = DB::table('college')->where('c_id',$type)->first();
        //类型的试题
       // $shi="select * from college_questions where c_college='".$college['c_name']."'";
        // $shi=DB::select($shi);
        $college_name=$college['c_name'];
        $shi=DB::table('college_questions')->where('c_college',"$college_name")->simplePaginate(12);

        return view('course/zhuan',['zhuan'=>$zhuan]);
    }
    public function s(){
        if(!empty($_POST['leixing'])){
            $type= $_POST['leixing'];
        }else{
            $type='';
        }
        if($type==0){
            //$shi="select * from college_questions";
            //$college_name=$college['c_name'];
            $shi=DB::table('college_questions')->simplePaginate(12);
        }else{
            $college = DB::table('college')->where('c_id',$type)->first();
            //类型的试题
            //$shi="select * from college_questions where c_college='".$college['c_name']."'";
            $college_name=$college['c_name'];
            $shi=DB::table('college_questions')->where('c_college',"$college_name")->simplePaginate(12);
        }
        $c_college = isset($_GET['c_college'])?$_GET['c_college']:'1';
        // echo $c_college;die;
        if($c_college==1)
        {
            $page = isset($_GET['page'])?$_GET['page']:"p";
            //如果有分页就走else
            if($page=="p")
            { 
              // echo $college_name;die;
                 
                  if(isset($college_name))
                  {
                     return view('course/shi6',['shi'=>$shi,'c_college'=>$college_name]);
                  }
                  else
                  {
                      return view('course/shi7',['shi'=>$shi]);
                  }
            }
            else
            {
                      $sql="select c_id,c_name from college where c_del=0";
                      $arr=DB::select($sql);
                      //专业
                      $sql="select * from direction";
                      $zhuan=DB::select($sql);
                      //类型
                      // var_dump($zhuan);die;
                      $lei=DB::table('type')->get();
                      //全部试题
                      $shi=DB::table('college_questions')->simplePaginate(12);
                      return view('course/course',['arr'=>$arr,'zhuan'=>$zhuan,'shi'=>$shi,'lei'=>$lei]);
            }
            
        }
        else
        {
            $sql1 = "select c_id from college where c_name = '$c_college'";
             $xueyuan=DB::select($sql1);
             $xy = $xueyuan[0]['c_id'];
            $sql="select c_id,c_name from college where c_del=0";
            $arr=DB::select($sql);
            //专业
            $sql="select * from direction where college_id = '$xy'";
            $zhuan=DB::select($sql);
            //类型
            $lei=DB::table('type')->get();
            //全部试题
            $shi=DB::table('college_questions')->where('c_college',"$c_college")->simplePaginate(12);
            return view('course/course2',['arr'=>$arr,'zhuan'=>$zhuan,'shi'=>$shi,'lei'=>$lei,'college_name'=>$c_college,'xy_id'=>$xy]);
        }
        //$shi=DB::select($shi);
        // return view('course/shi',['shi'=>$shi,'college_name'=>"$college_name"]);
    }
    public function zhuanye(){
    //这是ajax条件搜索用的
        // echo $_POST['leixing'];
        $xy = isset($_POST['leixing'])?$_POST['leixing']:'10';
        //这是分页链接用的
        // echo $xy;die;
        // echo $_POST['leixing'];die;
        $c_name = isset($_GET['c_college'])?$_GET['c_college']:'1';
        //进行判断如果c_college不等于1则是分页过来的值
        $c_type = isset($_GET['c_type'])?$_GET['c_type']:'2';

        if($c_type=='2')
        {
                   if($c_name=='1')
                    {
                      // echo 232;die;
                        $zhuan=isset($_POST['zhuan'])?$_POST['zhuan']:'';
                        // echo $_POST['zhuan'];die;
                        $lei=isset($_POST['lei'])?$_POST['lei']:'';
                        if($zhuan=='0'){
                          // echo 1232;die;
                                if($lei=='0'){
                                    $xy_id = $_POST['xy_id'];
                                    $sql2 = "select c_name from college where c_id = '$xy_id'";
                                     $xueyuan=DB::select($sql2);
                                     $c_name = $xueyuan[0]['c_name'];
                                   // $zhi='都为空';
                                     // echo 322;die;
                                    $arr=DB::table('college_questions')->where('c_college',"$c_name")->simplePaginate(12);
                                return view('course/shi4',['shi'=>$arr,'c_college'=>$c_name]);

                                }else{
                                  // echo $lei;die;
                                   // $zhi='类型非空专业为空';
                                    $leixing = isset($_POST['leixing'])?$_POST['leixing']:'no';
                                    if($leixing=='no')
                                    {
                                      $arr=DB::table('college_questions')->where('c_type',"$lei")->simplePaginate(12);
                                      return view('course/shi8',['shi'=>$arr,'c_type'=>$lei]);
                                    }
                                    else
                                    {
                                        $sql2s = "select c_name from college where c_id = '$xy'";
                                        $xueyuans=DB::select($sql2s);
                                        $c_name = $xueyuans[0]['c_name'];
                                        $arr=DB::table('college_questions')->where('c_college',"$c_name")->where('c_type',"$lei")->simplePaginate(12);
                                         return view('course/shi9',['shi'=>$arr,'c_type'=>$lei,'c_college'=>$c_name]);
                                    }

                                }

                            }else{
                                if($lei=='0'){

                                    //通过c_id查询出学院的名称
                                    $sql1 = "select c_name from college where c_id = '$xy'";
                                     $xueyuan=DB::select($sql1);
                                     $c_name = $xueyuan[0]['c_name'];
                                     // var_dump($c_name);die();
                                   // $zhi='专业非空类型为空'
                                    $arr=DB::table('college_questions')->where('c_college',"$c_name")->where('c_direction',"$zhuan")->simplePaginate(12);
                                    // var_dump($arr);die;
                                    return view('course/shi2',['shi'=>$arr,'c_name'=>$c_name,'c_direction'=>$zhuan]);
                                }else{

                                        $leixing = $_POST['leixing'];
                                        $zhuan = $_POST['zhuan'];
                                        $lei = $_POST['lei'];
                                        $sql1 = "select c_name from college where c_id = '$leixing'";
                                        // echo $sql1;die;
                                         $xueyuan=DB::select($sql1);
                                         $c_name = $xueyuan[0]['c_name'];
                                         if(is_numeric($zhuan))
                                         {
                                                $sql2 = "select d_name from direction where d_id = '$zhuan'";
                                            // echo $sql2;die;
                                             $zhuanye=DB::select($sql2);
                                             $d_name = $zhuanye[0]['d_name'];
                                         }
                                         else
                                         {
                                            $d_name = $zhuan;
                                         }
                                         //查询出专业的名称
                                        // $sql2 = "select d_name from direction where d_id = '$zhuan'";
                                        // echo $sql2;die;
                                        //  $zhuanye=DB::select($sql2);
                                        //  $d_name = $zhuanye[0]['d_name'];
                                         
                                         // echo $c_name;die;
                                         // echo $lei,'&nbxp;';
                                         // echo $zhuan;die;
                                        //$zhi="都不为空";
                                        //通过类型的名称
                                         $sql = "select * from college_questions where c_college = '$c_name' && c_type = '$lei' && c_direction = '$d_name'";
                                         // echo $sql;die;
                                        $arr=DB::table('college_questions')->where('c_college',"$c_name")->where('c_direction',"$d_name")->where('c_type',"$lei")->simplePaginate(12);
                                        return view('course/shi5',['shi'=>$arr,'c_name'=>$c_name,'c_direction'=>$d_name,'c_type'=>$lei]);

                                }
                            }
                        }
                        else
                        {
                                //查询出当前的专业方向
                                $c_direction = isset($_GET['c_direction'])?$_GET['c_direction']:'no';
                                if($c_direction!='no')
                                {
                                            $sqls="select * from direction where d_name = '$c_direction'";
                                          // echo $sqls;die;
                                          $reg=DB::select($sqls);
                                          $d_id = $reg[0]['d_id'];
                                          // echo $d_id;die;
                                          $sql1 = "select c_id from college where c_name = '$c_name'";
                                           $xueyuan=DB::select($sql1);
                                           $xy = $xueyuan[0]['c_id'];
                                          $sql="select c_id,c_name from college where c_del=0";
                                          $arr=DB::select($sql);
                                          //专业
                                          $sql="select * from direction where college_id = '$xy'";
                                          $zhuan=DB::select($sql);
                                          //类型
                                          // var_dump($zhuan);die;
                                          $lei=DB::table('type')->get();
                                          //全部试题
                                         
                                            $zy = $_GET['c_direction'];
                                          // var_dump($zhuan);die;
                                          $shi=DB::table('college_questions')->where('c_college',"$c_name")->where('c_direction',"$zy")->simplePaginate(12);
                                          // var_dump($arr);die;
                                          return view('course/course3',['d_id'=>$d_id,'c_direction'=>$zy,'shi'=>$shi,'arr'=>$arr,'zhuan'=>$zhuan,'lei'=>$lei,'c_name'=>$c_name,'xy_id'=>$xy]);
                                }
                                else
                                {
                                  // echo 1232;die;
                                  $page = isset($_GET['page'])?$_GET['page']:'no';
                                  if($page=='no')
                                  {
                                      $arr=DB::table('college_questions')->where('c_college',"$c_name")->simplePaginate(12);
                                     return view('course/shi4',['shi'=>$arr,'c_college'=>$c_name]);
                                  }
                                  else
                                  {
                                              $sql1 = "select c_id from college where c_name = '$c_name'";
                                             $xueyuan=DB::select($sql1);
                                             $xy = $xueyuan[0]['c_id'];
                                            $sql="select c_id,c_name from college where c_del=0";
                                            $arr=DB::select($sql);
                                            //专业
                                            $sql="select * from direction where college_id = '$xy'";
                                            $zhuan=DB::select($sql);
                                            //类型
                                            $lei=DB::table('type')->get();
                                            //全部试题
                                            $shi=DB::table('college_questions')->where('c_college',"$c_name")->simplePaginate(12);
                                            return view('course/course2',['arr'=>$arr,'zhuan'=>$zhuan,'shi'=>$shi,'lei'=>$lei,'college_name'=>$c_name,'xy_id'=>$xy]);
                                  }
                                    
                                }
                        

                            }
        }
        else //有类型的搜索分页
        {
                    $c_direction = isset($_GET['c_direction'])?$_GET['c_direction']:'no';
                    $c_type = $_GET['c_type'];
                    if($c_direction=='no')
                    { 
                         $c_college = $_GET['c_college'];
                           $sql1 = "select c_id from college where c_name = '$c_college'";
                           $xueyuan=DB::select($sql1);
                           $xy = $xueyuan[0]['c_id'];
                          $sql="select c_id,c_name from college where c_del=0";
                          $arr=DB::select($sql);
                          //专业
                          $sql="select * from direction where college_id = '$xy'";
                          $zhuan=DB::select($sql);
                          //类型
                          $lei=DB::table('type')->get();
                          //全部试题
                          $shi=DB::table('college_questions')->where('c_type',"$c_type")->where('c_college',"$c_name")->simplePaginate(12);
                    return view('course/course5',['c_type'=>$c_type,'c_direction'=>$c_college,'shi'=>$shi,'arr'=>$arr,'zhuan'=>$zhuan,'lei'=>$lei,'c_name'=>$c_name,'xy_id'=>$xy]);

                    }
                    
                    if(is_numeric($c_direction)){
                        $d_id = $c_direction;
                            $sqls="select * from direction where d_id = '$c_direction'";
                         // echo $sqls;die;
                            $reg=DB::select($sqls);
                            // var_dump($reg);die;
                            $d_name = $reg[0]['d_name'];
                    }
                    else
                    {
                        $d_name = $c_direction;
                        $sqls="select * from direction where d_name = '$c_direction'";
                         // echo $sqls;die;
                        $reg=DB::select($sqls);
                        // var_dump($reg);die;
                        $d_id = $reg[0]['d_id'];
                        
                    }
                    
                    // echo $d_id;die;
                    $sql1 = "select c_id from college where c_name = '$c_name'";
                     $xueyuan=DB::select($sql1);
                     $xy = $xueyuan[0]['c_id'];
                    $sql="select c_id,c_name from college where c_del=0";
                    $arr=DB::select($sql);
                    //专业
                    $sql="select * from direction where college_id = '$xy'";
                    $zhuan=DB::select($sql);
                    //类型
                    // var_dump($zhuan);die;
                    $lei=DB::table('type')->get();
                    //全部试题
                    // echo $c_name;die;
                      // $zy = $_GET['c_direction'];
                      // //查询出专业名称
                      //   $sql1s = "select d_name from direction where d_id = '$zy'";
                      //   // echo $sql1s;die;
                      //    $zhuanye=DB::select($sql1s);
                      //     // echo $d_id;echo $zy;echo $zhuan;echo $lei;echo $xy;echo c_name;die;
                      //    $d_name = $zhuanye[0]['d_name'];
                      //    // echo $d_name;die;
                    // var_dump($zhuan);die;
                    $shi=DB::table('college_questions')->where('c_type',"$c_type")->where('c_college',"$c_name")->where('c_direction',"$d_name")->simplePaginate(12);
                    // var_dump($arr);die;
                    return view('course/course4',['c_type'=>$c_type,'d_id'=>$d_id,'c_direction'=>$d_name,'shi'=>$shi,'arr'=>$arr,'zhuan'=>$zhuan,'lei'=>$lei,'c_name'=>$c_name,'xy_id'=>$xy]);
        }



        //print_r($arr);die;
       // return view('course/shi2',['shi'=>$arr]);
    }
    //根据类型进行搜索
    public function types()
    {
         $leixing = $_POST['leixing'];
        $zhuan = $_POST['zhuan'];
        $lei = $_POST['lei'];
        $sql1 = "select c_name from college where c_id = '$leixing'";
         $xueyuan=DB::select($sql1);
         $c_name = $xueyuan[0]['c_name'];
         //查询出专业的名称
        $sql2 = "select d_name from direction where d_id = '$zhuan'";
         $zhuanye=DB::select($sql2);
         $d_name = $zhuanye[0]['d_name'];
         // echo $c_name;die;
         // echo $lei,'&nbxp;';
         // echo $zhuan;die;
        //$zhi="都不为空";
        //通过类型的名称
         $sql = "select * from college_questions where c_college = '$c_name' && c_type = '$lei' && c_direction = '$d_name'";
         // echo $sql;die;
       $arr=DB::table('college_questions')->where('c_college',"$c_name")->where('c_direction',"$d_name")->where('c_type',"$lei")->simplePaginate(12);
       return view('course/shi5',['shi'=>$arr,'c_name'=>$c_name,'c_direction'=>$zhuan,'c_type'=>$lei]);
    }
    public function xiang(){
        $id=$_GET['id'];
	//echo $id;die;
	$num=DB::table('college_questions')->where("c_id",$id)->first();
        $num=$num['c_num']+=1;
        $sq=DB::update("update college_questions set c_num='$num' where c_id=".$id);
        $arr=DB::table('college_questions')->where('c_id',$id)->first();
//print_r($arr);die;
	if(!isset($_SESSION)){
		session_start();
	}
	if(!empty($_SESSION['username'])){

		$username=$_SESSION['username'];

	//$username=$_SESSION['username'];
	$u_id=DB::table('users')->where("user_phone","$username")->orwhere("user_email","$username")->first();
	$u_id=$u_id['user_id'];
        $ping=DB::select("select * from users inner join e_ping on users.user_id=e_ping.u_id where u_id=$u_id order by p_id desc");
	//print_r($ping);die;
	}else{
		$ping=array();
	}
        if($arr['c_college']=='软工学院'){
            $arr['img']='http://123.56.249.121/api/logo/软工.jpg';
        }elseif($arr['c_college']=='移动通信学院'){
            $arr['img']='http://123.56.249.121/api/logo/移动.jpg';
        }elseif($arr['c_college']=='云计算学院'){
            $arr['img']='http://123.56.249.121/api/logo/云计算.jpg';
        }elseif($arr['c_college']=='高翻学院'){
            $arr['img']='http://123.56.249.121/api/logo/高翻.jpg';
        }elseif($arr['c_college']=='国际经贸学院'){
            $arr['img']='http://123.56.249.121/api/logo/经贸.jpg';
        }elseif($arr['c_college']=='建筑学院'){
            $arr['img']='http://123.56.249.121/api/logo/建筑.jpg';
        }elseif($arr['c_college']=='游戏学院'){
            $arr['img']='http://123.56.249.121/api/logo/游戏.jpg';
        }elseif($arr['c_college']=='网工学院'){
            $arr['img']='http://123.56.249.121/api/logo/网工.jpg';
        }elseif($arr['c_college']=='传媒学院'){
            $arr['img']='http://123.56.249.121/api/logo/传媒.jpg';
        }
      //  echo $arr['img'];die;
        return view('course/xiang',['arr'=>$arr,'ping'=>$ping]);
    }
	 public function con()
    {
        $con = $_POST['con'];
        $c_id = $_POST['c_id'];
        $e_addtime=date("Y-m-d H:i:s");
        if(!empty($_SESSION['username'])){
            echo "1";
        }else{
            //$username=$_SESSION['username'];
            //$u_id=table('users')->where("user_phone","$username")->orwhere("user_email","$username")->pluck('user_id');
           // $u_id=1;
		 if(!isset($_SESSION)){
                  session_start();
	         }
         $username=$_SESSION['username'];
         $u_id=DB::table('users')->where("user_phone","$username")->orwhere("user_email","$username")->first();
	$u_id=$u_id['user_id'];
            $sql="insert into e_ping(p_con,u_id,e_id,e_addtime) values('$con',$u_id,'$c_id','$e_addtime')";
            $re=DB::insert($sql);
            $ping=DB::select("select * from users inner join e_ping on users.user_id=e_ping.u_id where u_id=$u_id order by p_id desc");
            return view('course/ping',['ping'=>$ping]);
        }
    }

    public function ceshi()
    {
                   $sql1 = "select c_name from college where c_id = '1'";
                 $xueyuan=DB::select($sql1);
                 var_dump($xueyuan);die;
                 $c_name = $xueyuan[0]['c_name'];
             var_dump($xy);
    }

}
