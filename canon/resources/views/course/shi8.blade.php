 <!-- <base href="../public/"> -->
             <div class="course-list">
                <!-- <div class="js-course-lists" id="list"> -->
 <div class="js-course-lists">
                    <ul>


                    <?php foreach($shi as $k=>$v){?>
                        <li class="course-one">
                            <a href="#" target="_self">
                               <div class="course-list-img">
                                               <img width="240" height="135" alt="" src="<?php                                         if($v['c_college']=="软工学院"){
                                                   echo "images/logo/软工.jpg";
                                               }elseif($v['c_college']=="移动通信学院"){
                                                   echo "images/logo/移动.jpg";
                                               }else if($v['c_college']=="云计算学院"){
                                                  echo  "images/logo/云计算.jpg";
                                               }elseif($v['c_college']=="高翻学院"){
                                                   echo  "images/logo/高翻.jpg";
                                               }elseif($v['c_college']=="国际经贸学院"){
                                                   echo  "images/logo/经贸.jpg";
                                               }elseif($v['c_college']=="建筑学院"){
                                                   echo  "images/logo/建筑.jpg";
                                               }elseif($v['c_college']=="游戏学院"){
                                                   echo  "images/logo/游戏.jpg";
                                               }elseif($v['c_college']=="网工学院"){
                                                   echo  "images/logo/网工.jpg";
                                               }elseif($v['c_college']=="传媒学院"){
                                                   echo  "images/logo/传媒.jpg";
                                               }?>">
                                           </div>

                                <h5>
                                    <span><a href="xiang?id=<?php echo $v['c_id']?>" target="_self"><?php echo $v['c_name']?></a></span>
                                </h5>
                                <div class="tips">
                                    <p class="text-ellipsis">类型:<?php echo $v['c_type']?></p>
                                    <p class="text-ellipsis">专业:<?php echo $v['c_direction']?></p>
                                    <span class="l ">更新完毕</span>

                <span class="l ml20">
                                <?php  echo $v['c_num']?>
                                人学习</span>
                                </div>
            <span class="time-label">
                                    9小时17分钟 | 初级
                            </span>
                                <b class="follow-label">跟我学</b>
                            </a>
                        </li>
                    <?php } ?>

                    </ul>
                </div>
                              <!--   </div> -->

            </div>
                                     <style>
      .pager{
          position:absolute;
          left:400px;
          bottom:-20px;
      }
                        .pager li{
                            float:left;
                            margin-left:100px;
          font-size:xx-large;
                        }
                    </style>
                <div>
                  
                  <?php echo 888; echo $shi->appends(['c_type' => "$c_type"]); ?>
                </div>
                
