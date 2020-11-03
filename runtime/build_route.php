<?php 
//根据 Annotation 自动生成的路由规则
Route::resource('index','index/Index');
Route::get('/login','index/Index/login');
Route::post('index/index/postLogin','index/Index/postLogin');
Route::post('/index/index/postRegister','index/Index/postRegister');
Route::post('/index/index/postResetPassword','index/Index/postResetPassword');
Route::post('/index/index/sendSmsCode','index/Index/sendSmsCode');