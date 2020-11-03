<?php /*a:1:{s:80:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\index_tpl.html";i:1544174961;}*/ ?>
<?php if(count($rows) > 0):foreach($rows as $val):if($val['type'] == 1):if($val['thumbnail']):$thumbnail = json_decode($val['thumbnail'],true); if(count($thumbnail) >=3 ): ?>
                                <div class="wx-b2 cus-article-href" data-id="<?php echo htmlentities($val['id']); ?>" data-type="<?php echo htmlentities($val['type']); ?>" >
                                    <p class="wx-n2"  onclick="clickHref(<?php echo htmlentities($val['id']); ?>)"  ><?php echo htmlentities($val['title']); ?></p>
                                    <p class="img" onclick="clickHref(<?php echo htmlentities($val['id']); ?>)">
                                        <?php foreach($thumbnail as $_v):?>
                                            <img src="<?php echo htmlentities($_v); ?>" alt=""/>
                                        <?php endforeach;?>
                                    </p>
                                    <p class="wx-n3" style="bottom: 2px" >
                                        <?php if($val['is_top'] == 1):?><span class="zd">置顶</span><?php endif;if($val['recommended'] == 1):?><span class="zd">推荐</span><?php endif;?>
                                        <span class="yh cus-to-usermain"  data-uid="<?php echo htmlentities($val['user_id']); ?>" ><?php echo !empty($val['nickname']) ? htmlentities($val['nickname']) : htmlentities($val['mobile']); ?></span>
                                        <span class="ck"><?php echo htmlentities($val['hits']); ?>+</span>
                                        <span class="pl">
                                            <?php if($val['comment_count'] == 0):elseif($val['comment_count'] >= 1000 ):?>
                                                999+
                                            <?php else:?>
                                            <?php echo htmlentities($val['comment_count']); endif;?>
                                        </span>
                                    </p>
                                </div>
                            <?php else:if($val['is_top'] == 1 || $val['recommended'] == 1):?>
                                    <div class="wx-b2 cus-article-href" data-id="10" data-type="1" style="margin-bottom: 50px">
                                        <p class="wx-n2" onclick="clickHref(<?php echo htmlentities($val['id']); ?>)">第一批出家的90后，已经拥有了自己的寺庙</p>
                                        <p class="wl-img" onclick="clickHref(<?php echo htmlentities($val['id']); ?>)">
                                            <img src="<?php echo htmlentities($thumbnail['img_1']); ?>" alt="" width="100%" height="300px">
                                        </p>
                                        <p class="wx-zhid">
                                            <?php if($val['is_top'] == 1):?><span class="zd">置顶</span><?php endif;if($val['recommended'] == 1):?><span class="zd">推荐</span><?php endif;?>
                                            <span class="yh cus-to-usermain"  data-uid="<?php echo htmlentities($val['user_id']); ?>"><?php echo !empty($val['nickname']) ? htmlentities($val['nickname']) : htmlentities($val['mobile']); ?></span>
                                            <span class="ck"><?php echo htmlentities($val['hits']); ?>+</span>
                                            <span class="pl">
                                                <?php if($val['comment_count'] == 0):elseif($val['comment_count'] >= 1000 ):?>
                                                    999+
                                                <?php else:?>
                                                <?php echo htmlentities($val['comment_count']); endif;?>
                                            </span>
                                        </p>
                                    </div>
                                <?php else:?>
                                    <div class="wx-b3 cus-article-href" data-id="<?php echo htmlentities($val['id']); ?>" data-type="<?php echo htmlentities($val['type']); ?>">
                                        <div style="height: 140px;margin-top: 20px;">
                                            <p class="wx-bn1" onclick="clickHref(<?php echo htmlentities($val['id']); ?>)"><?php echo htmlentities($val['title']); ?></p>
                                            <img src="<?php echo htmlentities($thumbnail['img_1']); ?>" onclick="clickHref(<?php echo htmlentities($val['id']); ?>)" />
                                        </div>
                                        <p class="wx-n3" >
                                            <?php if($val['is_top'] == 1):?><span class="zd">置顶</span><?php endif;if($val['recommended'] == 1):?><span class="zd">推荐</span><?php endif;?>
                                            <span class="yh cus-to-usermain"  data-uid="<?php echo htmlentities($val['user_id']); ?>"><?php echo !empty($val['nickname']) ? htmlentities($val['nickname']) : htmlentities($val['mobile']); ?></span>
                                            <span class="ck"><?php echo htmlentities($val['hits']); ?>+</span>
                                            <span class="pl">
                                                <?php if($val['comment_count'] == 0):elseif($val['comment_count'] >= 1000 ):?>
                                                    999+
                                                <?php else:?>
                                                <?php echo htmlentities($val['comment_count']); endif;?>
                                            </span>
                                        </p>
                                    </div>
                                <?php endif;endif;else:?>
                            <div class="wx-n1 cus-article-href" data-id="<?php echo htmlentities($val['id']); ?>" data-type="<?php echo htmlentities($val['type']); ?>" onclick="clickHref(<?php echo htmlentities($val['id']); ?>)" >
                                <p class="wx-n2"><?php echo htmlentities($val['title']); ?></p>
                                <p class="wx-n3" style="bottom: 5px">
                                    <?php if($val['is_top'] == 1):?><span class="zd">置顶</span><?php endif;if($val['recommended'] == 1):?><span class="zd">推荐</span><?php endif;?>
                                    <span class="yh cus-to-usermain"  data-uid="<?php echo htmlentities($val['user_id']); ?>"><?php echo !empty($val['nickname']) ? htmlentities($val['nickname']) : htmlentities($val['mobile']); ?></span>
                                    <span class="ck"><?php echo htmlentities($val['hits']); ?>+</span>
                                    <span class="pl">
                                        <?php if($val['comment_count'] == 0):elseif($val['comment_count'] >= 1000 ):?>
                                                999+
                                        <?php else:?>
                                        <?php echo htmlentities($val['comment_count']); endif;?>
                                    </span>
                                </p>
                            </div>
                        <?php endif;elseif($val['type'] == 2): $thumbnail = json_decode($val['thumbnail'],true); ?>
                        <div class="wx-b1 cus-article-href" data-id="<?php echo htmlentities($val['id']); ?>" data-type="<?php echo htmlentities($val['type']); ?>" >
                            <p class="wx-n2"><?php echo htmlentities($val['title']); ?></p>
                            <video src="<?php echo htmlentities($val['video_url']); ?>" controls="controls"  poster="<?php echo htmlentities($thumbnail['img_1']); ?>"></video>
                            <p class="wx-n3">
                                <span class="yh cus-to-usermain"  data-uid="<?php echo htmlentities($val['user_id']); ?>"><?php echo !empty($val['nickname']) ? htmlentities($val['nickname']) : htmlentities($val['mobile']); ?></span>
                                <span class="ck"><?php echo htmlentities($val['hits']); ?>+</span>
                                <span class="pl">
                                    <?php if($val['comment_count'] == 0):elseif($val['comment_count'] >= 1000 ):?>
                                        999+
                                    <?php else:?>
                                        <?php echo htmlentities($val['comment_count']); endif;?>
                                </span>
                            </p>
                        </div>
                <?php elseif($val['type'] == 3):elseif($val['type'] == 4):elseif($val['type'] == 5):endif;endforeach;endif;?>