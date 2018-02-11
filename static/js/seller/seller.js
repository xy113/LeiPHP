function editPrice() {

}

$(function () {
    $("[rel=edit-price]").on('click', function () {
        var order_id = $(this).attr('data-id');
        window.openw = DSXUI.dialog({
            title:'修改价格',
            width:'920px',
            height:'400px',
            iframe:'/index.php?m=seller&c=order&a=edit_price&order_id='+order_id,
            hideBottom:true
        });
    });
});