(function($) {
    $('.add-to-cart').on('click',function(e){
        let id =  $(this).data('id');
        let quantity= $('select[name="quantity"]').val();
        $.ajax({
            url:"/cart",
            method:'post',
            data: {
                'product_id': id,
                quantity: quantity,
                _token: csrf_token
            },success: response => {
                alert('product added successfully');
                window.location.href=checkoutUrl;;
            }
        })
    });
})(jQuery);