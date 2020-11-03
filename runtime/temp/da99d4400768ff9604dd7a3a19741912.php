<?php /*a:1:{s:89:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\userArticleList_tpl.html";i:1545872677;}*/ ?>

<?php if(count($rows) > 0):foreach($rows as $val):if(empty($val['thumbnail'])):?>
            <div class="ont-3" data-id="<?php echo htmlentities($val['id']); ?>"  style="min-height: 315px;padding-top:20px;border-bottom: 10px solid #EEEEEE;position: relative;">
                <div class="wx-name">
                    <img src="<?php echo !empty($val['nickname']) ? htmlentities($val['portrait']) : ''; ?>"  class="wx-tou cus-article-href2" data-user_id="<?php echo htmlentities($val['user_id']); ?>" onerror='this.src="/static/image/user/tou.png"'>
                    <dl class="wx-yh">
                        <dt style="font-size:28px;color: #1D1D1D;font-weight: bold;"   class="cus-article-href2" data-user_id="<?php echo htmlentities($val['user_id']); ?>" ><?php echo htmlentities($val['nickname']); ?></dt>
                        <dd style="font-size:24px;color: #898989;"><?php echo htmlentities(formatTime(strtotime($val['published_time']))); ?></dd>
                    </dl>
                   <!-- <span class="wx-rig"></span>-->
                </div>
                <p class="on1 cus-article-href " data-id="<?php echo htmlentities($val['id']); ?>" ><?php echo htmlentities($val['title']); ?></p>
                <ul class="wx-fen" >
                    <li><span><i class="iconfont icon-share_light cc" ></i></span></li>
                    <li style="margin-left: 100px;">
                        <span class="iconfont icon-comment_light cc" ></span>
                        <span class="ee"><?php echo !empty($val['comment_count']) ? htmlentities($val['comment_count']) : ''; ?></span>
                    </li>
                    <li style="margin-left: 100px;">
                        <span data-click="<?php echo htmlentities($val['isZan']); ?>" data-id="<?php echo htmlentities($val['id']); ?>" class="cus-article-fabulous" >
                            <?php if($val['isZan'] == 0):?>
                                 <span class="iconfont icon-appreciate_light cus-tubiao cc"></span>
                            <?php else:?>
                                 <span class="iconfont icon-appreciate_fill_light souBak cus-tubiao cc"></span>
                            <?php endif;?>
                            <span class="ee" class="cus-article-like-num"><?php echo htmlentities($val['like']); ?></span>
                        </span>
                    </li>
                </ul>
            </div>
        <?php else:
               $thumbnail = json_decode($val['thumbnail'],true);
               if(count($thumbnail) < 3):
            ?>
                    <div class="one-1" data-id="<?php echo htmlentities($val['id']); ?>" style="min-height: 360px;border-bottom: 10px solid #EEEEEE;position: relative">
                        <div class="wx-name" style="border:none;">
                            <img src="<?php echo !empty($val['nickname']) ? htmlentities($val['portrait']) : ''; ?>" class="wx-tou cus-article-href2"  data-user_id="<?php echo htmlentities($val['user_id']); ?>" onerror='this.src="/static/image/user/tou.png"' >
                            <dl class="wx-yh">
                                <dt style="font-size:28px;color: #1D1D1D;font-weight: bold;" class="cus-article-href2" data-user_id="<?php echo htmlentities($val['user_id']); ?>"><?php echo htmlentities($val['nickname']); ?></dt>
                                <dd style="font-size:24px;color: #898989;"><?php echo htmlentities(formatTime(strtotime($val['published_time']))); ?></dd>
                            </dl>
                           <!-- <span class="wx-rig"></span>-->
                        </div>
                        <div class="wx-nei1 cus-article-href" data-id="<?php echo htmlentities($val['id']); ?>">
                            <dl>
                                <dt style="font-size: 34px;color: #1F1F1F;margin-left: 36px;"><?php echo htmlentities($val['title']); ?></dt>
                                <dd><img src="<?php echo htmlentities($thumbnail['img_1']); ?>"  width="220" height="150"/></dd>
                            </dl>
                        </div>
                        <ul class="wx-fen">
                            <li><span><i class="iconfont icon-share_light cc"></i></span></li>
                            <li style="margin-left: 100px;"><span class="iconfont icon-comment_light cc" ></span><span
                                    class="ee"><?php echo !empty($val['comment_count']) ? htmlentities($val['comment_count']) : ''; ?></span></li>
                            <li style="margin-left: 100px;">
                                <span data-click="<?php echo htmlentities($val['isZan']); ?>" data-id="<?php echo htmlentities($val['id']); ?>" class="cus-article-fabulous" >
                                    <?php if($val['isZan'] == 0):?>
                                            <span class="iconfont icon-appreciate_light cus-tubiao cc"></span>
                                            <?php else:?>
                                            <span class="iconfont icon-appreciate_fill_light souBak cus-tubiao cc" ></span>
                                            <?php endif;?>
                                            <span  class="cus-article-like-num ee"><?php echo htmlentities($val['like']); ?></span>
                                </span>
                            </li>
                        </ul>
                    </div>
            <?php else:?>
                    <div class="one-2 " data-id="<?php echo htmlentities($val['id']); ?>" style="padding-top:20px;min-height:450px;border-bottom: 10px solid #EEEEEE;position: relative">
                        <div class="wx-name">
                            <img src="<?php echo !empty($val['nickname']) ? htmlentities($val['portrait']) : ''; ?>" class="wx-tou cus-article-href2"  data-user_id="<?php echo htmlentities($val['user_id']); ?>" onerror='this.src="/static/image/user/tou.png"'>
                            <dl class="wx-yh">
                                <dt style="font-size:28px;color: #1D1D1D;font-weight: bold;" class="cus-article-href2" data-user_id="<?php echo htmlentities($val['user_id']); ?>"><?php echo htmlentities($val['nickname']); ?></dt>
                                <dd style="font-size:24px;color: #898989;"><?php echo htmlentities(formatTime(strtotime($val['published_time']))); ?></dd>
                            </dl>
                            <!--<span class="wx-rig"></span>-->
                        </div>
                        <p class="on1 cus-article-href" data-id="<?php echo htmlentities($val['id']); ?>"><?php echo htmlentities($val['title']); ?></p>
                        <div class="on1-img cus-article-href" data-id="<?php echo htmlentities($val['id']); ?>">
                            <?php foreach($thumbnail as $_v):?>
                                <dd><img src="<?php echo htmlentities($_v); ?>" /></dd>
                            <?php endforeach;?>
                        </div>
                        <ul class="wx-fen" style="bottom: 0">
                            <li><span><i class="iconfont icon-share_light cc "></i></span></li>
                            <li style="margin-left: 100px;"><span class="iconfont icon-comment_light cc"></span><span class="ee"><?php echo !empty($val['comment_count']) ? htmlentities($val['comment_count']) : ''; ?></span ></li>
                            <li style="margin-left: 100px;">
                                <span data-click="<?php echo htmlentities($val['isZan']); ?>" data-id="<?php echo htmlentities($val['id']); ?>" class="cus-article-fabulous" >
                                    <?php if($val['isZan'] == 0):?>
                                    <span class="iconfont icon-appreciate_light cus-tubiao cc"></span>
                                    <?php else:?>
                                    <span class="iconfont icon-appreciate_fill_light souBak cus-tubiao cc" ></span>
                                    <?php endif;?>
                                    <span class="ee" class="cus-article-like-num"><?php echo htmlentities($val['like']); ?></span>
                                </span>
                            </li>
                        </ul>
                    </div>
            <?php endif;endif;endforeach;endif;?>








