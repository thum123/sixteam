
                            <li class="course-nav-item on" id="zhuan">
                               <a href="#" class="zhuan" value="0"> 全部</a>
                            </li>

                        <?php foreach($zhuan as $k=>$v){?>
                            <li class="course-nav-item " id="zhuan">
                                <a href="#" class="zhuan" value="<?php echo $v['d_name']?>">
                                <?php echo $v['d_name']?></a>
                                <input type="hidden" value="<?php echo $v['d_id']?>" id="one<?php echo $v['d_id']?>">

                            </li>
                        <?php } ?>
                       
 </div>


