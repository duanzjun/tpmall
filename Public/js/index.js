/* 当前所在选项卡 */
var currTab = 'dashboard';
var firstOpen = [];
var maxHistoryLength = 5;
$(function(){
    /* 初始化标签页 */
    initHistory();
    initTopTab();
});
function initTopTab(){
    $.each(menu, function(k, v){
        var item = $('<li><a href="javascript:;" id="tab_' + k + '">' + v.text + '</a></li>');
        item.children('a').click(function(){
            var tabName = this.id.substr(4);
            if(tabName == currTab) return;
            switchTab(tabName);openItem();
        });
        $('#nav').append(item);
    });

    /* 切换到默认选项卡 */
    switchTab(currTab);
    openItem(firstOpen[1], firstOpen[0]);
    //刷新框架页面
    $('#iframe_refresh').click(function(){
        $('#rframe').get(0).contentWindow.location.reload();
    });
    //清除缓存
    // $('#clear_cache').click(function(){
    //     var url = 'index.php?act=clear_cache';
    //     $.getJSON(url, {}, function(data){
    //         alert(data.msg);
    //     });
    // });
}
function initHistory(){
    readHistory();
    $(window).unload(saveHistory);
}
function readHistory(){
    var h = $.getCookie('actionHistory');
    if(h != '' && h != 'undefined'){
        var arr = h.split(',').reverse();
        $.each(arr, function(){
            var tmp = this.split('-');
            addHistoryItem(tmp[0], tmp[1]);
        });
        if(arr.length){
            firstOpen = arr[arr.length - 1].split('-');
        }
    }
}
function saveHistory(){
    var h = '';
    $('#historymenu > a').each(function(){
        h += $(this).prop('id') + ',';
    });
    var v = h.substr(0, (h.length - 1));
    $.setCookie('actionHistory', v);
}
function addHistoryItem(tab, item){
    var id = '#' + tab + '-' + item;
    if($(id).length == 1){
        /* 若存在提到最前 */
        var cln = $(id).clone(true);
        $(id).remove();
        $('#historymenu a:first').before(cln);
    }
    else{
        /* 不存在，则加入 */
        if(typeof(menu[tab]['children'][item])=='undefined'){
            return;
        }
        if($('#historymenu > a').length == maxHistoryLength){
            $('#historymenu > a:last').remove();
        }
        var lnk = $('<a href="javascript:;" class="list-group-item" id="' + tab + '-' + item + '">' + menu[tab]['children'][item]['text'] + '</a>').css({"color":"#98a9c2"});
        // var close = $('<a href="javascript:;" class="close"><img src="templates/style/images/close.gif" / ></a>');
        lnk.click(function(){
            openItem(item, tab);
        });
        // close.click(function(){
        //     $(this).parent().remove();
        // });
        $(lnk).appendTo($('#historymenu'));
    }
}
function switchTab(tabName){
    currTab = tabName;
    pickTab();
    loadSubmenu();
}
function pickTab(){
    $('#tab_' + currTab).parent('li').addClass('active').siblings().removeClass('active');
}
function loadSubmenu(){
    var m = menu[currTab];
    /* 删除所有现有子菜单 */
    $('#submenu > a').remove();
    /* 将子菜单逐项添加到菜单中 */
    $.each(m.children, function(k, v){
        var p = v.parent ? v.parent : currTab;
        var item = $('<a class="list-group-item" href="javascript:;" url="' + v.url + '" parent="' + p + '" id="item_' + k + '">' + v.text + '</a>');
        item.click(function(){
            openItem(this.id.substr(5));
        });
        $('#submenu').append(item);
    });
}
function openItem(itemIndex, tab){
    if(typeof(itemIndex) == 'undefined')
    {
        var itemIndex = menu[currTab]['default'];
    }
    var id='#item_'+itemIndex;
    if(tab){
        var parent=tab;
    }else{
        var parent=$(id).attr('parent');
    }
    /* 若不在当前选项卡内 */
    if(parent != currTab){
        /* 切换到指定选项卡 */
        switchTab(parent);
    }
    /* 高亮当前项 */
    $('#submenu > a').each(function(){
        $(this).removeClass('active');
    });
    $(id).addClass('active');

    /* 更新iframe的内容 */
    $('#rframe').show();
    $('#rframe').prop('src', $(id).attr('url'));

    /* 将该操作加入到历史访问当中 */
    addHistoryItem(currTab, itemIndex);
}
jQuery.extend({
    getCookie:function(sName) {
        var aCookie = document.cookie.split("; ");
        for (var i=0; i < aCookie.length; i++){
            var aCrumb = aCookie[i].split("=");
            if (sName == aCrumb[0]) return decodeURIComponent(aCrumb[1]);
        }
        return '';
    },
    setCookie:function(sName, sValue, sExpires) {
        var sCookie = sName + "=" + encodeURIComponent(sValue);
        if (sExpires != null) sCookie += "; expires=" + sExpires;
        document.cookie = sCookie;
    },
    removeCookie:function(sName) {
        document.cookie = sName + "=; expires=Fri, 31 Dec 1999 23:59:59 GMT;";
    }
});