var selfurl=window.location.href;
$(function(){
    $('.confirmurl').on('click',function(){
        var that=$(this);
        if(confirm(that.attr('data-msg'))){
            $.get(that.attr('data-uri'),function(data){
                if(data===true){
                    that.parent().parent().fadeOut('slow',function(){
                        $(this).remove();
                    });
                }else{
                    alert('删除失败');
                }
            })
        }
    });
    $('*[dia-type=\'dialog\']').on('click',function(){
        var that=$(this);
        var d=top.dialog({
            id:(that.attr('dia-id') ? that.attr('dia-id') : 'dialogid'),
            okValue:'提交',
            ok:function(){
                if(top.$('form').length>0){
                    top.$('form').submit();
                }
                return false;
            },
            onclose:function(){
                // console.info(this);
            },
            cancelValue:'取消',
            cancel:function(){}
        }).showModal();
        d.title(that.attr('dia-title'));
        d.width(parseInt(that.attr('dia-width')));
        d.height(parseInt(that.attr('dia-height')));
        $.get(that.attr('dia-uri')+'&t='+(Math.random()),function(result){
            d.content(result);
        });
        return false;
    });
    if($("#batchAction").length==1){
        $(".batchButton").on('click',function(){
            if($('.checkitem:checked').length==0){
                return false;
            }
            var items='';
            $('.checkitem:checked').each(function(){
                items+=this.value+',';
            });
            items=items.substr(0,(items.length-1));
            var name=$(this).attr('name') ? $(this).attr('name')+'=' : 'id=';
            window.location=$(this).attr('uri')+'&'+name+items;
        });
    }

    //tree
    $('[ectype="flex"]').on('click',function(){
        var status=$(this).attr('status');
        var id=$(this).next('span').attr('fieldid');
        var level=$(this).attr('level')==undefined ? 1 : parseInt($(this).attr('level'))+1;
        if(status=='open'){
            if($('.row'+id).length>0){
                $('.row'+id).show();
            }else{
                var pr = $(this).parent('td').parent('tr');
                $.get(selfurl+'&a=ajax_cate',{id:id,level:level},function(data){
                    if(data){
                        var str='';
                        var res=eval('('+data+')');
                        for(var i=0;i<res.length;i++){
                            str+='<tr class="row'+id+'"><td><input class="checkitem" type="checkbox" value="'+res[i]['cate_id']+'" /></td>';
                            str+='<td>'+res[i]['switchs_html']+'<span title="可编辑" class="editable glyphicon" required="1" fieldid="'+res[i]['cate_id']+'" fieldname="cate_name" ectype="inline_edit" style="display:inline;">'+res[i]['cate_name']+'</span></td>';
                            str+='<td><span title="可编辑" class="editable glyphicon" required="1" fieldid="'+res[i]['cate_id']+'" fieldname="sort_order" ectype="inline_edit" style="display:inline;">'+res[i]['sort_order']+'</span></td>';
                            str+='<td class="text-center">'+res[i]['if_show_html']+'</td>';
                            str+='<td class="text-right">';
                            str+=res[i]['edit']+' | '+res[i]['del']+' | '+res[i]['add_child'];
                            str+='</td></tr>';
                        }
                        pr.after(str);
                    }
                    $('span[ectype="inline_edit"]').unbind('click');
                    $.getScript(PUBLIC_URL+"/js/inline_edit.js");
                });
            }
            $(this).prop('class','glyphicon glyphicon-minus').attr('status','close');
        }
        if(status=='close'){
            $('.row'+id).hide();
            $(this).prop('class','glyphicon glyphicon-plus').attr('status','open');
        }
    });
});
function secajax(obj)
{
    var status=$(obj).attr('status');
    var id=$(obj).next('span').attr('fieldid');
    var level=parseInt($(obj).attr('level'))+1;
    if(status=='open'){
        if($('.row'+id).length>0){
            $('.row'+id).show();
        }else{
            var pr = $(obj).parent('td').parent('tr');
            var hclass=pr.attr('class')+' row'+id;
            $.get(selfurl+'&a=ajax_cate',{id:id,level:level},function(data){
                if(data){
                    var str='';
                    var res=eval('('+data+')');
                    for(var i=0;i<res.length;i++){
                        str+='<tr class="'+hclass+'"><td><input class="checkitem" type="checkbox" value="'+res[i]['cate_id']+'" /></td>';
                        str+='<td>'+res[i]['switchs_html']+'<span title="可编辑" class="editable glyphicon" required="1" fieldid="'+res[i]['cate_id']+'" fieldname="cate_name" ectype="inline_edit" style="display:inline;">'+res[i]['cate_name']+'</span></td>';
                        str+='<td><span title="可编辑" class="editable glyphicon" required="1" fieldid="'+res[i]['cate_id']+'" fieldname="sort_order" ectype="inline_edit" style="display:inline;">'+res[i]['sort_order']+'</span></td>';
                        str+='<td class="text-center">'+res[i]['if_show_html']+'</td>';
                        str+='<td class="text-right">';
                        str+=res[i]['edit']+' | '+res[i]['del']+' | '+res[i]['add_child'];
                        str+='</td></tr>';
                    }
                    pr.after(str);
                }
                $('span[ectype="inline_edit"]').unbind('click');
                $.getScript(PUBLIC_URL+"/js/inline_edit.js");
            });
        }
        $(obj).prop('class','glyphicon glyphicon-minus').attr('status','close');
    }
    if(status=='close'){
        $('.row'+id).hide();
        $(obj).prop('class','glyphicon glyphicon-plus').attr('status','open');
    }
}

function demo_toggle(obj)
{
    var that = $(obj);
    var val=that.attr('d-val');
    var uri=that.attr('d-uri');
    var icon=that.children('i');
    if(uri==''){
        alert('请求地址不正确');
        return false;
    }
    $.getJSON($(obj).attr('d-uri'),{'val':val,'_t':(Math.random())},function(data){
        if(data.status==true){
            if(icon.is('.glyphicon-eye-open')){
                icon.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
            }else if(icon.is('.glyphicon-eye-close')){
                icon.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
            }else if(icon.is('.glyphicon-ok')){
                icon.removeClass('glyphicon-ok').addClass('glyphicon-remove');
            }else if(icon.is('.glyphicon-remove')){
                icon.removeClass('glyphicon-remove').addClass('glyphicon-ok');
            }
            that.attr('d-val',1-val);
        }else
            alert('操作失败！');
    });
}