bindEventReceiptRows();
function bindEventReceiptRows(){
    $("#funds_tb .line-collapse-row").click(function(e){
        let icon = $(this).find("i");
        let receipt = $(this).attr('data-receipt');
        let tr = $("tr#tr_"+receipt);
        if (tr.is(':visible')) {
            tr.addClass('animated fadeOutUp')
            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass('animated fadeOutUp').hide();
            });
            icon.removeClass('fa-caret-down');
            icon.addClass('fa-caret-right');
        } else {
            tr.show().addClass('animated fadeInDown')
            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass('animated fadeInDown');
            });
            icon.removeClass('fa-caret-right');
            icon.addClass('fa-caret-down');
        }
        {{-- e.preventDefault(); --}}
    });
}