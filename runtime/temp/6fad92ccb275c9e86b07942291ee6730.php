<?php /*a:1:{s:93:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\collection\favorite_tpl.html";i:1549940378;}*/ ?>
<?php if(count($rows) > 0): foreach($rows as $vo): 
            $thumbnail = !empty($vo['thumbnail']) ? json_decode($vo['thumbnail'],true) :[];
         switch($vo['type']): case "1": if(count($thumbnail) >= 3): ?>
<div class="wl-img-3">
    <div class="wl-main href">
        <div>
            <div class="wl-tou-img href">
                <img src="<?php echo htmlentities($vo['portrait']); ?>" class="cus-article-href2" alt="" onerror='this.src="/static/image/user/tou.png"' data-user_id="<?php echo htmlentities($vo['user_id']); ?>">
            </div>
            <div class="wl-tou-yonghu href">
                <dl><?php echo htmlentities($vo['nickname']); ?></dl>
                <dt><?php echo htmlentities(formatTime(strtotime($vo['published_time']))); ?> </dt>
            </div>
        </div>
        <div style="clear:both"></div>
    </div>

    <div class="wl-neirong cus-click-href"   data-id="<?php echo htmlentities($vo['id']); ?>"  data-type="<?php echo htmlentities($vo['type']); ?>">
        <div class="wl-nei1"><?php echo htmlentities($vo['title']); ?> </div>
        <div class="wl-nei3 href" >
            <?php foreach($thumbnail as $k=>$v): ?>
            <img src="<?php echo htmlentities($v); ?>" alt="" class="cus-click-href"  data-id="<?php echo htmlentities($vo['id']); ?>">
            <?php endforeach; ?>
        </div>
    </div>
    <ul class="wl-tubiao">
        <li><i class="iconfont icon-share_light" ></i><span></span></li>
        <li><i class="iconfont icon-comment_light" ></i><span><?php echo htmlentities($vo['comment_count']); ?></span></li>
        <li class="cus-article-fabulous" data-type="<?php echo htmlentities($vo['isZan']); ?>"  data-id="<?php echo htmlentities($vo['id']); ?>">
            <i class="iconfont  <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?> wl-fabulous-icon"></i>
            <span class="wl-dian-one"><?php echo htmlentities($vo['like']); ?></span>
        </li>
    </ul>
</div>

                <?php elseif(count($thumbnail)  == 0): ?>
<div class="wl-neirong cus-click-href">
    <div class="wl-main href">
        <div>
            <div class="wl-tou-img href">
                <img src="<?php echo htmlentities($vo['portrait']); ?>" alt="" onerror='this.src="/static/image/user/tou.png"'  class="cus-article-href2" data-user_id="<?php echo htmlentities($vo['user_id']); ?>">
            </div>
            <div class="wl-tou-yonghu href">
                <dl><?php echo htmlentities($vo['nickname']); ?></dl>
                <dt><?php echo htmlentities(formatTime(strtotime($vo['published_time']))); ?></dt>
            </div>
        </div>
        <div style="clear:both"></div>
    </div>
    <div class="wl-nei1 cus-click-href" data-id="<?php echo htmlentities($vo['id']); ?>"  data-type="<?php echo htmlentities($vo['type']); ?>"><?php echo htmlentities($vo['title']); ?></div>
    <ul class="wl-tubiao">
        <li><i class="iconfont icon-share_light" ></i><span></span></li>
        <li><i class="iconfont icon-comment_light" ></i><span><?php echo htmlentities($vo['comment_count']); ?></span></li>
        <li class="cus-article-fabulous" data-type="<?php echo htmlentities($vo['isZan']); ?>"  data-id="<?php echo htmlentities($vo['id']); ?>">
            <i class="iconfont  <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?> wl-fabulous-icon"></i>
            <span class="wl-dian-one"><?php echo htmlentities($vo['like']); ?></span>
        </li>
    </ul>
</div>

                <?php else: ?>
<div class="wl-img-1">
    <div class="wl-main href">
        <div>
            <div class="wl-tou-img href">
                <img src="<?php echo htmlentities($vo['portrait']); ?>" alt="" class="cus-article-href2" onerror='this.src="/static/image/user/tou.png"'  data-user_id="<?php echo htmlentities($vo['user_id']); ?>">
            </div>
            <div class="wl-tou-yonghu href">
                <dl><?php echo htmlentities($vo['nickname']); ?></dl>
                <dt><?php echo htmlentities(formatTime(strtotime($vo['published_time']))); ?> </dt>
            </div>
        </div>
        <div style="clear:both"></div>
    </div>
    <div class="wl-neirong cus-click-href" data-id="<?php echo htmlentities($vo['id']); ?>"  data-type="<?php echo htmlentities($vo['type']); ?>">
        <div class="wl-nei5"> <?php echo htmlentities($vo['title']); ?> </div>
        <div class="wl-left-img">
            <?php if(count($thumbnail) > 0):?>
            <img src="<?php echo htmlentities($thumbnail['img_1']); ?>" alt="图片"/>
            <?php else:?>
            <img src="" alt="图片"/>
            <?php endif;?>
        </div>
        <div style="clear: both"></div>
    </div>
    <ul class="wl-tubiao">
        <li><i class="iconfont icon-share_light" ></i><span></span></li>
        <li><i class="iconfont icon-comment_light" ></i><span>2</span></li>
        <li class="cus-article-fabulous" data-type="<?php echo htmlentities($vo['isZan']); ?>"  data-id="<?php echo htmlentities($vo['id']); ?>">
            <i class="iconfont  <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?> wl-fabulous-icon"></i>
            <span class="wl-dian-one"><?php echo htmlentities($vo['like']); ?></span>
        </li>
    </ul>
</div>
                <?php endif; break; case "2": ?>
                <div style="width: 100%;min-height: 400px;border-bottom: 10px solid #EEEEEE;position: relative">
                    <div class="wx-name9 neme2" >
                        <div class="name2-1" >
                            <img src="<?php echo htmlentities($vo['portrait']); ?>" alt="" class="wx-tou cus-article-href2"  onerror='this.src="/static/image/user/tou.png"' data-user_id="<?php echo htmlentities($vo['user_id']); ?>">
                            <dl class="wx-yh"><dt><?php echo htmlentities($vo['nickname']); ?></dt>
                                <dd><?php echo htmlentities(formatTime(strtotime($vo['published_time']))); ?> </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="wl-jh cus-click-href" data-id="<?php echo htmlentities($vo['id']); ?>" data-type="<?php echo htmlentities($vo['type']); ?>">
                        <?php echo htmlentities($vo['title']); ?>
                    </div>
                    <div class="wx-video" >
                        <video src="<?php echo htmlentities($vo['video_url']); ?>" controls="controls" width="100%" height="420px"/>
                    </div>
                    <div style="height: 80px">
                        <ul class="wl-tubiao">
                            <li><i class="iconfont icon-share_light" ></i><span></span></li>
                            <li><i class="iconfont icon-comment_light" ></i><span><?php echo htmlentities($vo['comment_count']); ?></span></li>
                            <li class="cus-article-fabulous" data-type="<?php echo htmlentities($vo['isZan']); ?>"  data-id="<?php echo htmlentities($vo['id']); ?>">
                                <i class="iconfont  <?php echo $vo['isZan']==1 ? 'icon-dianzan1 cus-blue' : 'icon-dianzan'; ?> wl-fabulous-icon"></i>
                                <span class="wl-dian-one"><?php echo htmlentities($vo['like']); ?></span>
                            </li>
                        </ul>

                    </div>
                </div>
            <?php break; endswitch; endforeach; endif; ?>