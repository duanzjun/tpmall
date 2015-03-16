$(function(){
    $('i[ectype="flex"]').click(function(){
        var status=$(this).attr('status');
        var id=$(this).next('span').attr('fieldid');
        console.info(status);
        console.info(id);
    });
})