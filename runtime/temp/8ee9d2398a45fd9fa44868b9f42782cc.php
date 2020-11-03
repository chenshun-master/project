<?php /*a:5:{s:82:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\user\certification.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\layout.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\header.html";i:1549940378;s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\navigation.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\footer.html";i:1549940378;}*/ ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="applicable-device" content="pc,mobile">
    <title><?php echo config('conf.title'); ?></title>
    <link rel="stylesheet" type="text/css" href="/static/web/css/main.css"/>
    <link rel="stylesheet" href="/static/css/iconfont.css">
    
<link rel="stylesheet" href="/static/web/css1/certification1.css">
<link rel="stylesheet" href="/static/plugin/layui/css/layui.css">

</head>

<body >
    
        <header>
    <div class="layui-row">
        <div class="layui-col-xs12 layui-col-md12">
            <div class="web-header">
                <div class="web-header-content">
                    <div class="web-header-logo">
                         欢迎 <?php echo htmlentities($u['nickname']); ?> 来到薇琳医美！
                    </div>
                    <div class="web-head-portrait">
                        <ul class="web-article">
                          <li>  <a href="/index/user/certification">实名认证</a></li>
                            <?php if(($u && in_array($u['type'],[3,4]))): ?>
                               <li><a id="click-to-merchant">商户管理</a></li>
                            <?php endif; ?>
                           <li> <a href="/index/user/modifyUserInfo">账号设置</a></li>
                            <li><a href="/index/user/signOut">退出登录</a></li>
                        </ul>

                        <!--<ul class="web-reg">-->
                            <!--<li class="web-top-login">登录</li>-->
                            <!--<li class="web-top-login">注册</li>-->
                        <!--</ul>-->
                        <div style="clear: both"></div>
                    </div>
            </div>
        </div>
            <div style="width: 100%;min-height: 80px;background-color: #7DB0E8;">
                <div class="web-logo">
                    <div class="wl-logo-one">
                        <img src="/static/web/image/logo1.png" alt="">
                    </div>
                    <!--<div class="web-top-input">-->
                        <!--<a href="/index/shop/myshoplist"> <input type="text" placeholder="搜索的商品"></a>-->
                    <!--</div>-->
                    <div class="web-top-rigth">
                        <img src="/static/web/image/bj_logo.png" alt="" width="50" height="50">
                        <div class="web-zhengxing">
                            <dl>中国整形美容协会</dl>
                            <dt>互联网分会理事单位</dt>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
    

    

<div class="web-content">
    <div class="web-content-left">
        <content>
    <div class="web-navigation-title web-bold">个人中心</div>
    <ul class="web-navigation">
        <li class="web-wenzhangliebiao web-bold"> <span></span>文章列表 <span></span></li>
    <ul class="web-daohang">
        <?php if((checkFooter('/index/article/article'))): ?>
        <a href="/index/article/article"> <li class="web-tinjain"><i class="iconfont icon-fabiaowenzhang1" style="color: white"></i>发表文章</li></a>
        <?php else: ?>
        <a href="/index/article/article"> <li><i class="iconfont icon-fabiaowenzhang1" style="color: #FC9E9E"></i>发表文章</li></a>
        <?php endif; if((checkFooter('/index/article/graphic'))): ?>
        <a href="/index/article/graphic"><li class="web-tinjain"><i class="iconfont icon-wodewenzhang" style="color: white"></i>我的文章</li></a>
       <?php else: ?>
        <a href="/index/article/graphic"><li><i class="iconfont icon-wodewenzhang" style="color:#FE9F88"></i>我的文章</li></a>
        <?php endif; ?>

    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>分销商品 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/shop/index'))): ?>
            <a href="/index/shop/index"><li class="web-tinjain"><i class="iconfont icon-shangpinliebiao2" style="color: white"></i>商品列表</li></a>
            <?php else: ?>
            <a href="/index/shop/index"><li><i class="iconfont icon-shangpinliebiao2" style="color: #FFAC9C"></i>商品列表</li></a>
            <?php endif; if((checkFooter('/index/shop/myshoplist'))): ?>
            <a href="/index/shop/myshoplist"><li class="web-tinjain"><i class="iconfont icon-fenxiaoliebiao1" style="color: white"></i>分销列表</li></a>
            <?php else: ?>
            <a href="/index/shop/myshoplist"><li><i class="iconfont icon-fenxiaoliebiao1" style="color:#FF988A"></i>分销列表</li></a>
            <?php endif; ?>

    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>我的认证 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/user/certification'))): ?>
            <a href="/index/user/certification"><li  class="web-tinjain"><i class="iconfont icon-shimingrenzheng2" style="color: white"></i>实名认证</li></a>
            <?php else: ?>
            <a href="/index/user/certification"><li><i class="iconfont icon-shimingrenzheng2" style="color: #FFAC9C"></i>实名认证</li></a>
            <?php endif; ?>
    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>账号设置 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/user/main'))): ?>
            <a href="/index/user/main"><li  class="web-tinjain"><i class="iconfont icon-yonghuxinxi" style="color: white"></i>用户信息</li></a>
            <?php else: ?>
            <a href="/index/user/main"><li><i class="iconfont icon-yonghuxinxi" style="color: #FF917B"></i>用户信息</li></a>
            <?php endif; if((checkFooter('/index/user/modifyUserInfo'))): ?>
            <a href="/index/user/modifyUserInfo"><li  class="web-tinjain"><i class="iconfont icon-xiugaiziliao" style="color: white"></i>修改资料</li></a>
            <?php else: ?>
            <a href="/index/user/modifyUserInfo"><li><i class="iconfont icon-xiugaiziliao" style="color: #FE9F88"></i>修改资料</li></a>
            <?php endif; if((checkFooter('/index/user/security'))): ?>
            <a href="/index/user/security"><li  class="web-tinjain"><i class="iconfont icon-anquanzhongxin" style="color: white"></i>安全中心</li></a>
            <?php else: ?>
            <a href="/index/user/security"><li><i class="iconfont icon-anquanzhongxin" style="color: #FF917B"></i>安全中心</li></a>
            <?php endif; ?>

        </ul>
    </ul>

    </ul>
</content>

    </div>

    <div class="web-content-right">
            <ul class="wl-deji <?php if(($type != 0 && $recertification ==0)): ?>  wl-hidden<?php endif; ?>">
                <li class="<?php if(($type == 1 || $type == 0)): ?>  active<?php endif; ?>">个人认证</li>
                <li class="<?php if(($type == 2)): ?> active <?php endif; ?>">医生认证</li>
                <li class="<?php if(($type == 3)): ?> active <?php endif; ?>">医院认证</li>
                <li class="<?php if(($type == 4)): ?> active <?php endif; ?>">官方认证</li>
            </ul>
        <div style="clear: both"></div>
            <div class="content ">

                <!--个人认证-->
                <div class="<?php if((($type == 1 && $recertification !=0) || $type == 0)): ?> active <?php endif; ?> wl-d ">
                    <div class="web-top-name">
                        <ul>
                            <li>真实姓名<span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入真实姓名" id="fr1-username"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>身份证号<span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请务必与上传的身份证件号码保持一致" id="fr1-idcard"  maxlength="18" onkeyup = "value=value.replace(/[^\d{15,17}Xx]/g,'')"></li>
                        </ul>
                    </div>
                    <div class="web-shang">
                        <span>上传身份证照片<span class="web-se">*</span></span>
                    </div>
                    <div class="web-suolue-top">
                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr1-from" enctype="multipart/form-data">
                                    <input  type="file"  id="fr1-file-btn"  data-frid="1" name="imgFile" class="file  fr-file-btn-list" >
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加身份证正面</dt>
                            </div>
                            <img id="fr1-img"   width="125" height="125" class="wl-nui"/>
                        </div>

                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr2-from"  enctype="multipart/form-data">
                                    <input type="file"  id="fr2-file-btn"  data-frid="2"    name="imgFile" class="file fr-file-btn-list" >
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加身份证背面</dt>
                            </div>
                            <img id="fr2-img"   width="125" height="125" class="wl-nui"/>
                        </div>
                        <div class="web-tishi">支持绝大多数的图片格式，单张图片大小不超过5M。</div>
                        <div style="clear: both"></div>
                    </div>
                  <div class="wl-top-btn">
                      <div class="web-btn" onclick="objClass.submit1()">提交申请</div>
                  </div>
                </div>
                <!--医生认证-->
                <div class="<?php if(($type == 2 && $recertification !=0 )): ?> active <?php endif; ?> wl-d">
                    <div class="web-top-name">
                        <ul>
                            <li>真实姓名<span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入真实姓名" id="fr2-username"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>身份证号<span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请务必与上传的身份证件号码保持一致"id="fr2-idcard" onkeyup = "value=value.replace(/[^\d{15,17}Xx]/g,'')" maxlength="18"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>擅长项目<span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入擅长项目" id="fr2-speciality"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                    <ul>
                        <li>岗位职称<span class="web-se">*</span></li>
                        <li>
                            <select id="fr2-duties" >
                                <option value="">请选择岗位职称</option>
                                <option value="住院医师">住院医师</option>
                                <option value="主任医师">主任医师</option>
                                <option value="副主任医师">副主任医师</option>
                                <option value="医师">医师</option>
                                <option value="主治医师">主治医师</option>
                            </select>
                        </li>
                    </ul>
                     </div>
                    <div class="web-top-name">
                        <ul>
                            <li>医生简介<span class="web-se">*</span></li>
                            <li><textarea type="text" placeholder="请输入医生简介" id="fr2-profile"></textarea></li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <!--上传身份证照片-->
                    <div class="web-shang">
                        <span>上传身份证照片<span class="web-se">*</span></span>
                    </div>
                    <div class="web-suolue-top">
                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr3-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr3-file-btn" data-frid="3"  name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer;position: absolute"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加身份证正面</dt>
                            </div>
                            <img id="fr3-img"  width="125" height="125"class="wl-nui"/>
                        </div>
                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr4-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr4-file-btn" data-frid="4"  name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加身份证反面</dt>
                            </div>
                            <img id="fr4-img"  width="125" height="125"class="wl-nui"/>
                        </div>
                        <div class="web-tishi">支持绝大多数的图片格式，单张图片大小不超过5M。</div>
                        <div style="clear: both"></div>
                    </div>
                    <!--上传医生资质证明-->
                    <div class="web-shang">
                        <span>上传医生资质证明 <span class="web-se">*</span></span>
                    </div>
                    <div class="web-suolue-top">
                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr5-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr5-file-btn"  data-frid="5" name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加资格证</dt>
                            </div>
                            <img id="fr5-img" width="125" height="125"class="wl-nui"/>
                        </div>

                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr6-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr6-file-btn"  data-frid="6" name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加执业证</dt>
                            </div>
                            <img id="fr6-img"    width="125" height="125"class="wl-nui"/>
                        </div>
                        <div class="web-tishi">支持绝大多数的图片格式，单张图片大小不超过5M。</div>
                        <div style="clear: both"></div>
                    </div>

                    <div class="wl-top-btn">
                        <div class="web-btn" onclick="objClass.submit2()">提交申请</div>
                    </div>
                </div>
                <!--医院认证-->
                <div class="<?php if(($type == 3 && $recertification !=0)): ?> active <?php endif; ?> wl-d">
                    <div class="web-top-name">
                        <ul>
                            <li>医院名称 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请与组织机构代码证或营业执照名称一致" id="fr3-enterprise-name"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>医院性质 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入医院性质 (门诊部/医院)"  id="fr3-type"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>成立时间 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请选择成立时间" id="fr3-founding-time"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>医院规模 <span class="web-se">*</span></li>
                            <li>
                                <select id="fr3-scale">
                                    <option value="请选择医院规模">请选择医院规模</option>
                                    <option value="50人以下">50人以下</option>
                                    <option value="50-100人 ">50~100人 </option>
                                    <option value="100~200人 ">100~200人 </option>
                                    <option value="200~500人 ">200~500人 </option>
                                    <option value="500~1000人 ">500~1000人 </option>
                                    <option value="1000人以上 ">1000人以上 </option>
                                </select>
                            </li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>医院擅长 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入医院擅长项目 (注: 多个用 ','分割)" id="fr3-speciality"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>运营者姓名 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入运营者姓名" id="fr3-username"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>身份证号 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请务必与上传的身份证件号码保持一致" id="fr3-idcard"  onkeyup = "value=value.replace(/[^\d{15,17}Xx]/g,'')"  maxlength="18" ></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>手机号 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入运营者手机号码" style="width:60%" id="fr3-mobile"  maxlength="11"  onkeyup = "value=value.replace(/[^\d]/g,'')" >
                                <span class="wl-huqou" id="code-btn"  onclick="objClass.sendSms1()">获取验证码</span>
                            </li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>短信验证码 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入验证码" id="fr3-sms-code"  maxlength="6" onkeyup = "value=value.replace(/[^\d]/g,'')"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>所在地址 <span class="web-se">*</span></li>
                            <li>
                                <select id="fr3-province" class="wl-liandong fr-province"><option value="" >请选择省</option></select>
                                <select id="fr3-city" class="wl-liandong fr-city" ><option value="" >请选择市</option></select>
                                <select id="fr3-area-county" class="wl-liandong fr-area-county" ><option value="" >请选择县</option></select>
                                <input type="text" placeholder="请输入详细地址"  id="fr3-detail-address" >
                            </li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="web-top-name">
                        <ul>
                            <li>医生简介<span class="web-se">*</span></li>
                            <li><textarea type="text" placeholder="请填写医院简介(注:个人简介必须真实有效)" id="fr3-profile"></textarea></li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <!--上传身份证照片-->
                    <div class="web-shang">
                        <span>上传身份证照片<span class="web-se">*</span></span>
                    </div>
                    <div class="web-suolue-top">
                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr7-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr7-file-btn" data-frid="7"  name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加身份证正面</dt>
                            </div>
                            <img id="fr7-img" width="125" height="125"class="wl-nui"/>
                        </div>

                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr8-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr8-file-btn" data-frid="8"  name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加身份证反面</dt>
                            </div>
                            <img id="fr8-img"   width="125" height="125"class="wl-nui"/>
                        </div>
                        <div class="web-tishi">支持绝大多数的图片格式，单张图片大小不超过5M。</div>
                        <div style="clear: both"></div>
                    </div>
                    <!--上传医院营业证件-->
                    <div class="web-shang">
                        <span>上传医院营业证件 <span class="web-se">*</span></span>
                    </div>
                    <div class="web-suolue-top">
                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr9-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr9-file-btn" data-frid="9"  name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加营业执照</dt>
                            </div>
                            <img id="fr9-img"   width="125" height="125"class="wl-nui"/>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="wl-top-btn">
                        <div class="web-btn" onclick="objClass.submit3()">提交申请</div>
                    </div>
                </div>
                <!--官方认证-->
                <div class="<?php if(($type == 4 && $recertification !=0)): ?> active <?php endif; ?> wl-d">
                    <div class="web-top-name">
                        <ul>
                            <li>企业名称 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请与组织机构代码证或营业执照名称一致" id="fr4-enterprise-name"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>运营者姓名  <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入运营者姓名" id="fr4-username"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>身份证号  <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请务必与上传的身份证件号码保持一致" id="fr4-idcard" onkeyup = "value=value.replace(/[^\d{15,17}Xx]/g,'')" maxlength="18"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>手机号 <span class="web-se">*</span></li>
                            <li>
                                <input type="text" placeholder="请输入运营者手机号码" style="width:60%" id="fr4-mobile" maxlength="11" onkeyup = "value=value.replace(/[^\d]/g,'')">
                                <span class="wl-huqou" id="code-btn2" onclick="objClass.sendSms2()">获取验证码</span>
                            </li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>短信验证码 <span class="web-se">*</span></li>
                            <li><input type="text" placeholder="请输入验证码"  id="fr4-sms-code" maxlength="6" onkeyup = "value=value.replace(/[^\d]/g,'')"></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li>所在地址 <span class="web-se">*</span></li>
                            <li>
                                <select id="fr4-province" class="wl-liandong fr-province"><option value="" >请选择省</option></select>
                                <select id="fr4-city" class="wl-liandong fr-city" ><option value="" >请选择市</option></select>
                                <select id="fr4-area-county" class="wl-liandong fr-area-county" ><option value="" >请选择县</option></select>
                                <input type="text" placeholder="请输入详细地址"  id="fr4-detail-address">
                            </li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <!--上传身份证照片-->
                    <div class="web-shang">
                        <span>上传身份证照片<span class="web-se">*</span></span>
                    </div>
                    <div class="web-suolue-top">
                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr10-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr10-file-btn" data-frid="10"  name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加身份证正面</dt>
                            </div>
                            <img id="fr10-img"   width="125" height="125"class="wl-nui"/>
                        </div>

                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr11-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr11-file-btn"  data-frid="11" name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加身份证背面</dt>
                            </div>
                            <img id="fr11-img"  width="125" height="125"class="wl-nui"/>
                        </div>
                        <div class="web-tishi">支持绝大多数的图片格式，单张图片大小不超过5M。</div>
                        <div style="clear: both"></div>
                    </div>
                    <!--上传企业工商营业执照 -->
                    <div class="web-shang">
                        <span>上传企业工商营业执照  <span class="web-se">*</span></span>
                    </div>
                    <div class="web-suolue-top">
                        <div class="web-suolue">
                            <div class="web-suoluetu">
                                <form id="fr12-from" enctype='multipart/form-data'>
                                    <input type="file"  id="fr12-file-btn" data-frid="12"  name="imgFile" class="file fr-file-btn-list"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"  />
                                </form>
                                <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                                <dt>添加营业执照</dt>
                            </div>
                            <img id="fr12-img"  width="125" height="125" class="wl-nui"/>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="wl-top-btn">
                        <div class="web-btn" onclick="objClass.submit4()">提交申请</div>
                    </div>
                </div>

                <?php if((count($authResult) > 0 && $recertification === 0)): switch($authResult['status']): case "1": ?>
                             <div class="wl-liucheng">
                            <div class="wl-jindu">
                                <span class="wl-submit" >
                                    <span class="iconfont icon-shuziyi wl-submit-one" ></span>
                                    <span style="float: left;margin-top: -2px">提交认证信息</span>
                                </span> <i class="iconfont icon-hengxian wl-submit-one-hengxian" ></i>
                                <span style="float: left;margin-left: 30px;margin-right: 40px">
                                    <span class="iconfont icon-shuzier" style="color:#7DB0E8;font-size: 25px ;float: left;margin-top: -2px;"></span>
                                    <span style="float: left;margin-top: -2px">等待审核结果</span></span><span class="iconfont icon-hengxian" style="color:#7DB0E8 ;font-size: 57px;float: left"></span>
                                <span style="float: left;margin-left: 30px">
                                    <span class="iconfont icon-shuzisan-copy" style="font-size: 25px;color: #C8C8C8;float: left;margin-top: -2px;"></span>
                                    <span style="float: left;margin-top: -2px">认证结果发布</span></span>
                            </div>
                            <div class="wl-jieguo">
                                <dl style="font-size: 28px;color: #333333">正在审核中，请耐心等待2-5个工作日</dl>
                                <dd style="font-size: 16px;color: #999999;margin-top: 56px">如在2-5个工作日未得到认证结果，请联系客服</dd>
                                <dt style="font-size: 16px;color: #999999;margin-top: 20px">与我们取得联系。</dt>
                                <button onclick="window.location.reload()" >刷新</button>
                            </div>
                        </div>
                        <?php break; case "2": ?>
                            <div class="wl-liucheng"  >
                            <div class="wl-jindu">
                                <span style="float: left;margin-left: 210px;margin-right: 20px"> <span class="iconfont icon-shuziyi" style="color:#7DB0E8 ;font-size: 25px;float: left;margin-top: -2px"></span><span style="float: left;margin-top: -2px">等待审核结果</span></span> <i class="iconfont icon-hengxian" style="color:#7DB0E8 ;font-size: 57px;float: left;"></i>
                                <span style="float: left;margin-left: 30px;margin-right: 40px">  <span class="iconfont icon-shuzier" style="color:#7DB0E8;font-size: 25px ;float: left;margin-top: -2px"></span><span style="float: left;margin-top: -2px">等待审核结果</span></span><span class="iconfont icon-hengxian" style="color:#7DB0E8 ;font-size: 57px;float: left;"></span>
                                <span style="float: left;margin-left: 30px"> <span class="iconfont icon-shuzisan-copy" style="font-size: 25px;color: #7DB0E8;float: left;margin-top: -2px"></span><sapn><span style="float: left;margin-top: -2px">认证结果发布</span></sapn></span>
                            </div>
                            <div class="wl-jieguo1">
                                <dl style="font-size: 28px;text-align: center">很遗憾，您认证审核未通过</dl>
                                <dd style="font-size: 16px;margin-top: 66px">很遗憾您的认证申请未通过审核，请完善认证信息并再次提交审核，谢谢！</dd>
                                <dd style="font-size: 20px;margin-top: 44px">未通过原因:</dd>
                                <dt style="font-size: 16px;margin-top: 27px">1.确认提交照片是否清晰，与绑定手机用户是否一致。</dt>
                                <dt style="font-size: 16px;margin-top: 19px">2.确认提交姓名与身份证姓名是否一致。</dt>
                                <dt style="font-size: 16px;margin-top: 19px">3.手机号绑定用户与身份证姓名是否一致</dt>
                                <button ><a href="/index/user/certification?recertification=1" style="color: #ffffff !important;">重新申请认证</a></button>
                            </div>
                        </div>
                        <?php break; case "3": ?>
                            <div class="wl-liucheng" style="">
                            <div class="wl-jindu">
                                <span style="float: left;margin-left: 190px;margin-right: 20px"> <span class="iconfont icon-shuziyi" style="color:#7DB0E8 ;font-size: 25px;float: left;margin-top: -2px"></span><span style="float: left;margin-top: -2px">提交认证信息</span></sapn></span> <i class="iconfont icon-hengxian" style="color:#7DB0E8 ;font-size: 57px;float: left;"></i>
                                <span style="float: left;margin-left: 30px;margin-right: 40px">  <span class="iconfont icon-shuzier" style="color:#7DB0E8;font-size: 25px;float: left;margin-top: -2px "></span><span style="float: left;: margin-top-2px">等待审核结果</span></sapn></span><span class="iconfont icon-hengxian" style="color:#7DB0E8 ;font-size: 57px;float: left;"></span>
                                <span style="float: left;margin-left: 30px"> <span class="iconfont icon-shuzisan-copy" style="font-size: 25px;color: #7DB0E8;float: left;margin-top: -2px"></span><span style="float: left;margin-top: -2px">认证结果发布</span></sapn></span>
                            </div>
                            <div class="wl-jieguo2">
                                <dl class="iconfont icon-roundcheck" style="color: #7DB0E8;font-size: 90px"></dl>
                                <dd style="font-size: 28px;margin-top: 51px">恭喜你，您的认证审核已通过</dd>
                                <dt style="font-size: 16px;margin-top: 29px">您已成为薇琳医美认证会员</dt>
                                <!--<button>知道了</button>-->
                            </div>
                        </div>
                        <?php break; endswitch; endif; ?>
            </div>
    </div>

    <p id="fr-error-box">
        <span class="fr-error-box-text"></span>
        <span class="iconfont icon-roundclosefill" style="float: right;margin-right: 5px;cursor: pointer;" id="cus-fr-error-close" onclick="$(this).parent().fadeOut('slow')"></span>
    </p>
</div>


    
    <footer>
    <div class="web-footer">
        <div class="web-footer-content">
        <dl>
            <span><?php echo config('conf.copyright'); ?></span>
            <span>Wei Lin Medical beauty</span>
            <a href="#"><img src="https://statics.wmnrj.com/images/beian.png" alt="">公安网备 34040302000221号</a>
        </dl>
            <dt><span>客服电话:021-62829999</span><span>医院地址:上海市静安区江宁路818号（江宁路海防路路口）</span></dt>
        </div>
    </div>
</footer>
    

    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $('#click-to-merchant').on('click',function(){
            $.ajax({
                url: "/index/user/getAuthCode",
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    if(res.code == 200){
                        window.open(res.data.url,'_blank');
                    }
                }
            });
        });
    </script>
    
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/plugin/layui/layui.js"></script>
<script src="/static/plugin/jquery.smscode.js"></script>
<script>

    $(".wl-deji li").click(function () {
        if(objClass.type == 0){
            $(this).addClass("active").siblings().removeClass("active");
            var index = $(this).index();
            $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
        }
    });
</script>
<script>
    var objClass = {
        type:<?php echo htmlentities($type); ?>,
        loading:false,
        sendSmsCode:false,
        showError:function(msg){
            $('#fr-error-box').fadeIn("slow").delay(2000).fadeOut();
            $('#fr-error-box').find('.fr-error-box-text').text(msg);
        },
        submit1:function(){
            var username  = $.trim($('#fr1-username').val());
            var idcard    = $.trim($('#fr1-idcard').val());
            var card_img1 = $('#fr1-img').attr("src");
            var card_img2 = $('#fr2-img').attr("src");
            if(username == ''){
                this.showError('身份证姓名不能为空');return false;
            }else if(idcard == ''){
                this.showError('身份证号不能为空');return false;
            }else if(!redream.checkIdcard(idcard)){
                this.showError('身份证号格式不正确');return false;
            }else if(card_img1 == '' || card_img1 == undefined){
                this.showError('请上传身份证正面照');return false;
            }else if(card_img2 == '' || card_img2 == undefined){
                this.showError('请上传身份证背面照');return false;
            }else if(!this.loading){
                this.ajax({type:1,username:username,idcard:idcard,card_img1:card_img1,card_img2:card_img2});
            }
        },
        submit2:function(){
            var data  = {
                type:2,
                username:             $.trim($('#fr2-username').val()),
                idcard:               $.trim($('#fr2-idcard').val()),
                card_img1:            $('#fr3-img').attr("src"),
                card_img2:            $('#fr4-img').attr("src"),
                qualification:        $('#fr5-img').attr("src"),
                practice_certificate: $('#fr6-img').attr("src"),
                speciality:           $.trim($('#fr2-speciality').val()),
                duties:               $.trim($('#fr2-duties').val()),
                profile:              $.trim($('#fr2-profile').val()),
            };

            if(data.username == ''){
                this.showError('身份证姓名不能为空');return false;
            }else if(data.idcard == ''){
                this.showError('身份证号不能为空');return false;
            }else if(data.speciality == ''){
                this.showError('医生擅长项目不能为空');return false;
            }else if(data.duties == ''){
                this.showError('岗位职称不能为空');return false;
            }else if(data.profile == ''){
                this.showError('医生简介不能为空');return false;
            }else if(!redream.checkIdcard(data.idcard)){
                this.showError('身份证号格式不正确');return false;
            }else if(data.card_img1 == '' || data.card_img1 == undefined){
                this.showError('请上传身份证正面照');return false;
            }else if(data.card_img2 == '' || data.card_img2 == undefined){
                this.showError('请上传身份证背面照');return false;
            }else if(data.qualification == '' || data.qualification == undefined){
                this.showError('请上传医师资格证书图片');return false;
            }else if(data.practice_certificate == '' || data.practice_certificate == undefined){
                this.showError('请上传医师执业证书图片');return false;
            }else if(!this.loading){
                this.ajax(data);
            }
        },
        submit3:function(){
            var data = {
                type:3,
                username:                   $.trim($('#fr3-username').val()),
                idcard:                     $.trim($('#fr3-idcard').val()),
                card_img1:                  $('#fr7-img').attr("src"),
                card_img2:                  $('#fr8-img').attr("src"),
                enterprise_name:            $.trim($('#fr3-enterprise-name').val()),
                business_licence:           $('#fr9-img').attr("src"),
                sms_code:                   $.trim($('#fr3-sms-code').val()),
                mobile:                     $('#fr3-mobile').val(),

                hospital_type:              $.trim($('#fr3-type').val()),
                founding_time:              $.trim($('#fr3-founding-time').val()),
                speciality:                 $.trim($('#fr3-speciality').val()),
                profile:                    $.trim($('#fr3-profile').val()),
                scale:                      $.trim($('#fr3-scale').val()),

                province:                   $('#fr3-province').val(),
                city:                       $('#fr3-city').val(),
                area:                       $('#fr3-area-county').val(),
                address:                    $('#fr3-detail-address').val(),
            };
            if(data.enterprise_name == ''){
                this.showError('医院名称不能为空');
            }else if(data.hospital_type == ''){
                this.showError('医院性质不能为空');
            }else if(data.founding_time == ''){
                this.showError('成立时间不能为空');
            }else if(data.scale == ''){
                this.showError('医院规模不能为空');
            }else if(data.speciality == ''){
                this.showError('医院擅长不能为空');
            }else if(data.username == ''){
                this.showError('身份证姓名不能为空');
            }else if(data.idcard == ''){
                this.showError('身份证号不能为空');
            }else if(!redream.checkIdcard(data.idcard)){
                this.showError('身份证号格式不正确');
            }else if(!redream.checkMobile(data.mobile)){
                this.showError('手机号格式错误');
            }else if(data.sms_code == ''){
                this.showError('手机验证码不能为空');
            }else if($('#fr3-province').val() == '' || $('#fr3-city').val() == '' || $('#fr3-area-county').val() == ''){
                this.showError('请选择所在地址信息');
            }else if($('#fr3-detail-address').val() == ''){
                this.showError('详细地址不能为空');
            }else if(data.profile == ''){
                this.showError('医院简介不能为空');
            }else if(data.card_img1 == '' || data.card_img1 == undefined){
                this.showError('请上传身份证正面照');
            }else if(data.card_img2 == '' || data.card_img2 == undefined){
                this.showError('请上传身份证背面照');
            }else if(data.business_licence == '' || data.business_licence == undefined){
                this.showError('请上传医院营业执照');
            }else if(!this.loading){
                this.ajax(data);
            }
        },
        submit4:function(){
            var data = {
                type              : 4,
                username          : $.trim($('#fr4-username').val()),
                idcard            : $.trim($('#fr4-idcard').val()),
                card_img1         : $('#fr10-img').attr("src"),
                card_img2         : $('#fr11-img').attr("src"),
                enterprise_name   : $.trim($('#fr4-enterprise-name').val()),
                business_licence  : $('#fr12-img').attr("src"),
                sms_code          : $.trim($('#fr4-sms-code').val()),
                mobile            : $('#fr4-mobile').val(),

                province:                   $('#fr4-province').val(),
                city:                       $('#fr4-city').val(),
                area:                       $('#fr4-area-county').val(),
                address:                    $('#fr4-detail-address').val(),
            };

            if(data.enterprise_name == ''){
                this.showError('企业名称不能为空');return false;
            }else if(data.username == ''){
                this.showError('运营者姓名不能为空');return false;
            }else if(data.idcard == ''){
                this.showError('身份证号不能为空');return false;
            }else if(!redream.checkIdcard(data.idcard)){
                this.showError('身份证号格式不正确');return false;
            }else if(!redream.checkMobile(data.mobile)) {
                this.showError('手机号格式错误');return false;
            }else if(data.sms_code == ''){
                this.showError('手机验证码不能为空');return false;
            }else if($('#fr4-province').val() == '' || $('#fr4-city').val() == '' || $('#fr4-area-county').val() == ''){
                this.showError('请选择所在地址信息');
            }else if($('#fr4-detail-address').val() == ''){
                this.showError('详细地址不能为空');
            }else if(data.card_img1 == '' || data.card_img1 == undefined){
                this.showError('请上传身份证正面照');return false;
            }else if(data.card_img2 == '' || data.card_img2 == undefined){
                this.showError('请上传身份证背面照');return false;
            }else if(data.business_licence == '' || data.business_licence == undefined){
                this.showError('请上传医院营业执照');return false;
            }else if(!this.loading){
                this.ajax(data);
            }
        },
        ajax:function(data){
            $.ajax({
                url:"/index/user/addAuth",
                type:'post',
                data:data,
                dataType:'json',
                beforeSend:function(){
                    objClass.loading = true;
                },
                complete:function(){
                    objClass.loading = false;
                },
                success:function(res){
                    if(res.code == 200){
                        objClass.loading = true;
                        objClass.submitSuccess();
                    }else{
                        objClass.showError(res.msg);
                    }
                }
            });
        },
        submitSuccess:function(){
            this.showError('申请提交成功，请耐心等待审核...');
            setTimeout(function(){
                window.location.href = '/index/user/certification';
            },2000);
        },
        sendSms1:function(){
            var mobile = $('#fr3-mobile').val();
            if(!redream.checkMobile(mobile)){
                this.showError('手机号格式不正确');return false;
            }

            if(codeObj.checkTime()){
                return false;
            }
            if(!this.sendSmsCode){
                $.ajax({
                    url:"/index/index/sendSmsCode",
                    type:'post',
                    data:{mobile:mobile,type:7},
                    dataType:'json',
                    beforeSend:function(){
                        objClass.sendSmsCode = true;
                    },
                    complete:function(){
                        objClass.sendSmsCode = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            codeObj.trigger();
                        }else{
                            objClass.showError(res.msg);
                        }
                    }
                });
            }
        },
        sendSms2:function(){
            var mobile = $('#fr4-mobile').val();
            if(!redream.checkMobile(mobile)){
                this.showError('手机号格式不正确');return false;
            }
            if(codeObj2.checkTime()){
                return false;
            }
            if(!this.sendSmsCode){
                $.ajax({
                    url:"/index/index/sendSmsCode",
                    type:'post',
                    data:{mobile:mobile,type:7},
                    dataType:'json',
                    beforeSend:function(){
                        objClass.sendSmsCode = true;
                    },
                    complete:function(){
                        objClass.sendSmsCode = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            codeObj2.trigger();
                        }else{
                            objClass.showError(res.msg);
                        }
                    }
                });
            }
        },
        ajaxUploadImg(imname,formData){
            $.ajax({
                url: '/index/upload/uploadAuthFile',
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {
                    if(res.code == 200){
                        $(imname).attr('src',res.data.url).css("opacity",1).show().prev().hide();
                    }else{
                        objClass.showError(res.msg);
                    }
                }
            });
        },
    };

    var myAddressObj ={
        requestParams:{
            region_path :',',
            region_grade:'1',
        },
        loadAddressList:function(region_path,region_grade){
            myAddressObj.requestParams = {region_path :region_path,region_grade:region_grade};
            $.ajax({
                url:"/weixin/api/getAddress",
                type:'post',
                data:myAddressObj.requestParams,
                dataType:'json',
                success:function(res){
                    if(res.code == 200){
                        var data = res.data;
                        if(data.request_params.region_path == myAddressObj.requestParams.region_path && data.request_params.region_grade == myAddressObj.requestParams.region_grade){
                            var html = '';
                            $.each(data.infos,function(k,v){
                                html += myAddressObj.getSelectOptions(v);
                            });
                            if(data.request_params.region_grade == 1){
                                $('.fr-province').empty().append('<option value="" >请选择省</option>').append(html);
                            }else if(data.request_params.region_grade == 2){
                                $('.fr-city').empty().append('<option value="" >请选择市</option>').append(html);
                                $('.fr-area-county').empty().append('<option value="" >请选择县</option>');
                            }else if(data.request_params.region_grade == 3){
                                $('.fr-area-county').empty().append('<option value="" >请选择县</option>').append(html);
                            }
                        }
                    }
                }
            });
        },
        getSelectOptions:function(data){
            return '<option value="'+ data.id +'"  data-region_path="'+ data.region_path +'"  data-region_grade="'+ data.find_next_region_grade +'" >'+ data.local_name +'</option>';
        }
    };

    myAddressObj.loadAddressList(myAddressObj.requestParams.region_path,myAddressObj.requestParams.region_grade);

    $('.fr-province,.fr-city,.fr-area-county').on('change',function(){
        var obj = $(this).find("option:selected");
        myAddressObj.loadAddressList(obj.data('region_path'),obj.data('region_grade'));
    });

    $(".fr-file-btn-list").on("change", function () {
        var frid = $(this).data('frid');
        var formData = new FormData($('#fr'+frid+'-from')[0]);
        formData.append('type',2);
        objClass.ajaxUploadImg('#fr'+frid+'-img',formData);
    });
    // $(function(){
    //     var maodian = window.location.toString().split('#')[1];
    //     if(maodian == 'auth1'){
    //         $('.wl-deji li:nth-child(1)').trigger('click');
    //     }else if(maodian == 'auth2'){
    //         $('.wl-deji li:nth-child(2)').trigger('click');
    //     }else if(maodian == 'auth3'){
    //         $('.wl-deji li:nth-child(3)').trigger('click');
    //     } else if(maodian == 'auth4'){
    //         $('.wl-deji li:nth-child(4)').trigger('click');
    //     }else{
    //         $(".wl-deji li:first-child").trigger('click');
    //     }
    // });
</script>

</body>
</html>