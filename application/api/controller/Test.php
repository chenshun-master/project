<?php
namespace app\api\controller;


use app\api\model\SpCategoryModel;
use think\Db;

class Test
{
    public function test(){
        $data = [
            '玻尿酸'=>[
                '玻尿酸塑形'=>[
                    '玻尿酸丰卧蚕'=>[],
                    '玻尿酸隆鼻'=>[],
                    '玻尿酸丰唇'=>[],
                    '玻尿酸丰耳垂'=>[],
                    '玻尿酸垫下巴'=>[],
                    '玻尿酸丰苹果肌'=>[],
                    '玻尿酸丰泪沟'=>[],
                    '玻尿酸丰太阳穴'=>[],
                    '玻尿酸丰眉弓'=>[],
                    '玻尿酸丰面颊'=>[],
                    '玻尿酸丰唇珠'=>[],
                    '玻尿酸丰额头'=>[],
                    '玻尿酸丰鼻基底'=>[],
                    '玻尿酸丰眼窝'=>[],
                    '玻尿酸全脸填充'=>[],
                ],
                '玻尿酸抗衰'=>[
                    '玻尿酸去黑眼圈'=>[],
                    '玻尿酸去法令纹'=>[],
                    '玻尿酸去颈纹'=>[],
                    '玻尿酸去静态纹'=>[],
                    '玻尿酸去面部细纹'=>[],
                ],
                '玻尿酸修复'=>[
                    '溶解酶'=>[]
                ],
            ],
            '肉毒素'=>[
                '肉毒素除皱'=>[
                    '肉毒素去法令纹'=>[],
                    '肉毒素去鱼尾纹'=>[],
                    '肉毒素去抬头纹'=>[],
                    '肉毒素去川字纹'=>[],
                    '肉毒素去木偶纹'=>[],
                    '肉毒素去鼻背纹'=>[],
                    '肉毒素去口周纹'=>[],
                    '肉毒素去动态纹'=>[],
                    '肉毒素去面部细纹'=>[],
                ],
                '肉毒素塑形'=>[
                    '肉毒素缩鼻头'=>[],
                    '肉毒素瘦小腿'=>[],
                    '肉毒素瘦肩肌'=>[],
                    '肉毒素瘦脸'=>[],
                ],
                '肉毒素治疗'=>[
                    '肉毒素治疗多汗'=>[],
                    '肉毒素去露龈笑'=>[],
                    '肉毒素去狐臭'=>[],
                    '肉毒素颏肌放松'=>[],
                ],
            ],
            '脂肪填充'=>[],
            '眼部整形'=>[],
            '鼻部整形'=>[],
            '半永久妆'=>[],
            '激光脱毛'=>[],
            '唇部整形'=>[],
            '皮肤美容'=>[],
            '美体塑形'=>[],
            '面部轮廓'=>[],
            '胸部整形'=>[],
            '毛发种植'=>[],
            '牙齿美容'=>[],
            '耳部整形'=>[],
            '私密整形'=>[],
        ];
//        Db::startTrans();
//        try {
//            $this->add($data,0);
//            Db::commit();
//        } catch (\Exception $e) {
//            Db::rollback();
//
//            halt($e);
//        }
    }

    public function add($data,$pid,$path=''){
        foreach ($data as $k=>$v){
            $moadel = new SpCategoryModel();
            $moadel->name = $k;
            $moadel->parent_id = $pid;
            $moadel->created_time = date('Y-m-d H:i:s');
            $moadel->updated_time = date('Y-m-d H:i:s');
            if(is_array($v) && count($v) > 0){
                $moadel->is_leaf = 0;
            }else{
                $moadel->is_leaf = 1;
            }
            $moadel->save();
            $path = rtrim($path,',');
            $moadel->path = $path. ",{$moadel->id},";
            $moadel->save();

            if(is_array($v) && count($v) > 0){
                $this->add($v,$moadel->id,$moadel->path);
            }
        }

        return true;
    }


    public function t(){
        $domain = new \app\api\domain\SpGoodsDomain();
        $params = [
            'category'    =>'',
            'sort'        =>1,
            'city'        =>'',
            'keywords'    =>'layui',
        ];

        $data = $domain->getSearchGoods($params);
        halt($data);
    }


    public function ss(){
        set_time_limit(0);

        $list = Db::name('sp_category')->where('is_leaf',1)->limit(0,37)->column('path');


        echo date('Y-m-d H:i:s');
        $res = Db::name('sp_goods')->where('id','>',100017301)->limit(0,1000)->column('id');

        echo '<br/>';

        foreach ($res as $k=>$val){
                $key = rand(0,36);

                $arr = explode(',',trim($list[$key],','));

                $data = [];
                foreach ($arr as $k2=>$v2){
                    $data[] = ['goods_id'=>$val,'category_id'=>$v2];
                }

                Db::name('sp_category_extend')->insertAll($data);
        }

        echo date('Y-m-d H:i:s');
    }
}