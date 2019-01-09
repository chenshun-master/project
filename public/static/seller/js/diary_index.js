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
    add:function(){
        layer.open({
            type: 1,
            shade: false,
            title: '添加美丽日记',
            area: ['1200px', '700px'],
            content: caseTemplate.innerHTML,
            cancel: function(){

            }
        });
    },
    choiceGoods:function(){
        layer.open({
            type: 2,
            shade: false,
            title: '选择相关商品',
            area: ['1200px', '700px'],
            content: '/seller/diary/searchGoodsBox',
            cancel: function(){

            }
        });
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




$(document).on('click','.diary-img-boxs-remove',function(){
    $(this).parent().remove();
});