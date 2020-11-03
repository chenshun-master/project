<?php /*a:1:{s:92:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\collection\comment_tpl.html";i:1548119468;}*/ ?>
<?php if(count($rows) > 0): foreach($rows as $vo): 
            $thumbnail = !empty($vo['thumbnail']) ? json_decode($vo['thumbnail'],true) :[];
         switch($vo['type']): case "1": if(count($thumbnail) >= 3): ?>
                    <div class="wl-fas">
                        <div class="wx-name9 wl-mnb" >
                            <div class="wl-one1-2" >
                                <img src="<?php echo htmlentities($vo['portrait']); ?>" alt="" class="wx-tou  cus-article-href2" onerror='this.src="/static/image/user/tou.png"' data-user_id="<?php echo htmlentities($vo['user_id']); ?>">
                                <dl class="wx-yh"><dt><?php echo htmlentities($vo['nickname']); ?></dt>
                                    <dd><?php echo htmlentities(formatTime(strtotime($vo['published_time']))); ?> </dd>
                                </dl>
                            </div>
                        </div>
                        <div  class="wl-neirong-8" > <span style="color: #7DB0E8"><?php echo !empty($vo['huifu_nickname']) ? '@'.$vo['huifu_nickname'] : ''; ?></span> <?php echo htmlentities($vo['comment_content']); ?></div>
                        <dl class="wl-dasiu  cus-click-href" data-id="<?php echo htmlentities($vo['id']); ?>" data-type="<?php echo htmlentities($vo['type']); ?>">
                            <div class="wl-dasda" > <?php echo htmlentities($vo['title']); ?></div>
                            <div class="wl-img" >
                                <?php foreach($thumbnail as $k=>$v): ?>
                                <dd ><img src="<?php echo htmlentities($v); ?>" alt="图片"/></dd>
                                <?php endforeach; ?>
                            </div>
                        </dl>
                            <ul  class="wl-tubiao">
                                <li><i class="iconfont icon-share_light" ></i><span></span></li>
                                <li><i class="iconfont icon-comment_light" ></i><span><?php echo htmlentities($vo['comment_count']); ?></span></li>
                                <li  data-click="<?php echo htmlentities($vo['isZan']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" class="cus-article-fabulous">
                                    <i class="iconfont   <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?>"></i>
                                    <span><?php echo htmlentities($vo['like']); ?></span>
                                </li>
                            </ul>
                        <!--<div style="position: relative;top:50px;">-->
                            <!--<ul class="wx-fen" style="position:absolute;bottom: 15px;">-->
                                <!--<li><i class="iconfont icon-share_light" ></i><span></span></li>-->
                                <!--<li><i class="iconfont icon-comment_light" ></i><span style="margin-left: 8px;"><?php echo htmlentities($vo['comment_count']); ?></span></li>-->
                                <!--<li  data-click="<?php echo htmlentities($vo['isZan']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" class="cus-article-fabulous" >-->
                                    <!--<i class="iconfont   <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?>"style=" font-size: 30px;"></i>-->
                                    <!--<span><?php echo htmlentities($vo['like']); ?></span>-->
                                <!--</li>-->
                            <!--</ul>-->
                        <!--</div>-->
                    </div>
                    <div style="clear: both"></div>
                <?php elseif(count($thumbnail)  == 0): ?>
                    <div style="width: 100%;min-height: 300px">
                        <div class="wx-name9 name1">
                            <div class="wl-one1-2">
                                <img src="<?php echo htmlentities($vo['portrait']); ?>" alt="" class="wx-tou cus-article-href2"
                                     onerror='this.src="/static/image/user/tou.png"' data-user_id="<?php echo htmlentities($vo['user_id']); ?>">
                                <dl class="wx-yh wl-on1-3">
                                    <dt><?php echo htmlentities($vo['nickname']); ?></dt>
                                    <dd><?php echo htmlentities(formatTime(strtotime($vo['published_time']))); ?></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="wx-moban" style="min-height: 300px">
                            <div class="wx-nei1 cus-click-href" data-id="<?php echo htmlentities($vo['id']); ?>" data-type="<?php echo htmlentities($vo['type']); ?>">
                                <div class="wl-mo1"><?php echo htmlentities($vo['comment_content']); ?></div>
                                <div class="wx-nei1 w-onr4  cus-click-href" data-id="<?php echo htmlentities($vo['id']); ?>" data-type="<?php echo htmlentities($vo['type']); ?>"style=" top: 5px;width: 95%;margin: 0 auto;min-height: 100px;">
                                    <dl class="w-oea">
                                        <?php echo htmlentities($vo['title']); ?>
                                    </dl>
                                </div>
                                <div style="position: relative">
                                    <ul class="wx-fen" style="position:relative;bottom: -15px">
                                        <li style="margin-left: 31px;"><i class="iconfont icon-share_light"></i><span></span></li>
                                        <li><i class="iconfont icon-comment_light"></i><span style="margin-left: 8px;"><?php echo htmlentities($vo['comment_count']); ?></span>
                                        </li>
                                        <li data-click="<?php echo htmlentities($vo['isZan']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" class="cus-article-fabulous">
                                            <i class="iconfont   <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?>"
                                               style=" font-size: 30px;"></i>
                                            <span><?php echo htmlentities($vo['like']); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="w-one3-1">
                        <div class="wx-name9 name1">
                            <div class="wl-one1-2" >
                                <img src="<?php echo htmlentities($vo['portrait']); ?>" alt="" class="wx-tou  cus-article-href2" onerror='this.src="/static/image/user/tou.png"' data-user_id="<?php echo htmlentities($vo['user_id']); ?>">
                                <dl class="wx-yh"><dt><?php echo htmlentities($vo['nickname']); ?></dt>
                                    <dd><?php echo htmlentities(formatTime(strtotime($vo['published_time']))); ?> </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="w-zhuij"> <span style="color: #7DB0E8"><?php echo !empty($vo['huifu_nickname']) ? '@'.$vo['huifu_nickname'] : ''; ?></span> <?php echo htmlentities($vo['comment_content']); ?></div>
                        <div class="wx-nei1 w-onr4  cus-click-href" data-id="<?php echo htmlentities($vo['id']); ?>" data-type="<?php echo htmlentities($vo['type']); ?>" style=" top: 5px;width: 90%;margin: 0 auto">
                            <dl class="w-oea">
                                <dt class="wl-daa" style="width: 58.1%;margin: 10px 0px 0px 15px;"><?php echo htmlentities($vo['title']); ?></dt>
                                <dd  style="width: 256px; height: 180px;float: right; position: absolute;top: 2px; right: -5px; margin: 5px;">
                                    
                                    <?php if(count($thumbnail) > 0):?>
                                        <img src="<?php echo htmlentities($thumbnail['img_1']); ?>" alt="图片" style="width: 247px;height: 162px"/>
                                    <?php else:?>
                                        <img src="" alt="图片" style="width: 247px;height: 162px"/>
                                    <?php endif;?>

                                </dd>
                            </dl>
                        </div>
                        <div style="position: relative">
                            <ul class="wx-fen " style="bottom: -40px" >
                                <li><i class="iconfont icon-share_light" ></i><span></span></li>
                                <li><i class="iconfont icon-comment_light" ></i><span style="margin-left: 8px;"><?php echo htmlentities($vo['comment_count']); ?></span></li>
                                <li  data-click="<?php echo htmlentities($vo['isZan']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" class="cus-article-fabulous" >
                                    <i class="iconfont   <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?>"style=" font-size: 30px;"></i>
                                    <span><?php echo htmlentities($vo['like']); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div style="clear: both"></div>
                <?php endif; break; case "2": ?>
                <div class="wo-ju" >
                    <div class="wx-name9 wl-mnb">
                        <div class="wl-one1-2">
                            <img src="<?php echo htmlentities($vo['portrait']); ?>" alt="" class="wx-tou  cus-article-href2" onerror='this.src="/static/image/user/tou.png"' data-user_id="<?php echo htmlentities($vo['user_id']); ?>">
                            <dl class="wx-yh"><dt><?php echo htmlentities($vo['nickname']); ?></dt>
                                <dd><?php echo htmlentities(formatTime(strtotime($vo['published_time']))); ?> </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="w-zhuij" ><span style="color: #7DB0E8"><?php echo !empty($vo['huifu_nickname']) ? '@'.$vo['huifu_nickname'] : ''; ?></span> <?php echo htmlentities($vo['comment_content']); ?></div>
                    <div class="wx-nei1 w-onr4">
                        <dl>
                            <div  class="wl-neirong-8  cus-click-href" data-id="<?php echo htmlentities($vo['id']); ?>" data-type="<?php echo htmlentities($vo['type']); ?>"> <?php echo htmlentities($vo['title']); ?></div>
                            <div class="wx-video">
                                <video src="" controls="controls" width="100%" height="420px"/>
                            </div>
                        </dl>
                    </div>
                    <div class="wl-dya">
                        <ul class="wx-fen " style="bottom: -9px">
                            <li><i class="iconfont icon-share_light" ></i><span></span></li>
                            <li><i class="iconfont icon-comment_light" ></i><span style="margin-left: 8px;"><?php echo htmlentities($vo['comment_count']); ?></span></li>
                            <li  data-click="<?php echo htmlentities($vo['isZan']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" class="cus-article-fabulous" >
                                <i class="iconfont   <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?>"style=" font-size: 30px;"></i>
                                <span  ><?php echo htmlentities($vo['like']); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php break; endswitch; endforeach; endif; ?>