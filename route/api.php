<?php

/**
 * 接口地址定义路由
 *
 *
 */
//案例
Route::rule('api/index/test1','api/index/test1','GET')->middleware('CheckToken');