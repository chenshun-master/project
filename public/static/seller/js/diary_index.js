layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,toolbar: '#toolbarDemo'
    ,url: '/seller/diary/getDiaryList' //数据接口
    ,page: true
    ,loading:true
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code == 200?0:res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "count": res.data.total, //解析数据长度
            "data": res.data.rows //解析数据列表
        };
    }
    ,text: {
        none: '暂无相关数据'
    }
    ,limit: 20
    ,cols: [[ //表头
        {type:'numbers'},
        {field: 'title', title: '美丽日记标题',minWidth:200},
        {field: 'visit', title: '浏览量',width:100,align:'center'},
        {field: 'created_time', title: '添加时间',width:200},
        {field: 'updated_time', title: '更新时间',width:200},
        {field: 'id', title: '操作',width:100,templet:function(row){
            return '<a class="layui-btn layui-btn-primary layui-btn-xs to-diary-detail" data-id="'+ row.id +'" >查看详情</a>';
        }}
    ]],
    limits:[30,50,100]
});

$(document).on('click','.to-diary-detail',function(){
    window.location.href = '/seller/diary/diaryDetail/id/'+$(this).data('id');
});

var objClass = {
    reload:function(){
        layui.table.reload('tab-reload', {
            page: {curr: 1},
        });
    },

    addDiaryBoxIndex:null,
    add:function(){
        layer.open({
            title:'添加案例',
            type: 2,
            area: ['1250px', '500px'],
            fixed: false, //不固定
            maxmin: false,
            content: 'http://172.16.100.85/seller/diary/createDiary'
        });
    },

    choiceGoodsList:[],
    choiceGoods:function(){
        layer.open({
            type: 2,
            shade: false,
            title: '选择相关商品',
            area: ['1200px', '700px'],
            content: '/seller/diary/searchGoodsBox',
            cancel:function(){
                objClass.choiceGoodsList = [];
            },
            end:function(){
                if(objClass.choiceGoodsList.length > 0){
                    console.log(objClass.choiceGoodsList);
                    var html = '';

                    $.each(objClass.choiceGoodsList,function(k,v){
                        html  += '<li data-goodis="'+ v.id +'">' +
                                    '<img src="'+ v.img +'" width="30">' +
                                    '<span>'+ v.name+'</span>' +
                                    '<span  class="diary-goods-remove"><i class="layui-icon layui-icon-delete"></i>删除</span>' +
                                 '</li>';
                    });

                    $('.diary-goods > ul').append(html);
                }
            }
        });
    },


    getGoodsId:function(){
        var arr = [];
        $.each($('.diary-goods >ul li'),function(k,v){
            arr.push($('.diary-goods >ul li')[k].dataset.goodis);
        });

        return arr;
    },
    getImgs:function(){
        var arr = [];
        $.each($('.diary-img-boxs > img'),function(k,v){
            arr.push($('.diary-img-boxs > img')[k].src);
        });
        return arr;
    },
    addDiary:function(){
        var data = {title:$.trim($('#fr-diary-title').val()),ids:this.getGoodsId(),imgs:this.getImgs()};
        if(data.ids.length == 0){
            layer.msg('相关产品不能为空');
            return false;
        }else if(data.imgs.length == 0){
            layer.msg('术前照不能为空');
            return false;
        }else{
            var loadIndex = layer.msg('提交中...', {icon: 16,shade: 0.01,time:0});
            $.ajax({
                url: '/seller/diary/addDiary',
                type: 'POST',
                data:data,
                dataType: "json",
                complete:function(){
                    layer.close(loadIndex);
                },
                success: function (res) {
                    if(res.code == 200){
                        layer.msg('添加成功...', {icon: 1});
                        layer.close(objClass.addDiaryBoxIndex);
                        objClass.reload();
                    }else{
                        layer.msg(res.msg);
                    }
                }
            });
        }
    }
};

var uploadIndex = null;
$(document).on('change','#fr-diary-img-upload', function () {
    var formData = new FormData($('#from')[0]);
    $.ajax({
        url: '/seller/diary/uploadImgFile',
        type: 'POST',
        cache: false,
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend:function(){
            uploadIndex = layer.msg('文件上传中...', {icon: 16,shade: 0.01,time:0});
        },
        complete:function(){
            layer.close(uploadIndex);
        },
        success: function (res) {
            if(res.code == 200){
                $('#img-container').append('<div class="diary-img-boxs"><img src="'+ res.data.url +'" width="100"  /><div class="diary-img-boxs-remove"><i class="fa fa-fw fa-trash"></i></div></div>');
            }else{
                layer.msg(res.msg);
            }
        }
    });
});

$(document).on('click','.diary-img-boxs-remove,.diary-goods-remove',function(){
    $(this).parent().remove();
});