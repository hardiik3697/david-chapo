$(function () {
    $('.form-check-input').click(function(){
        var value = $(this).val();
        $('.total_amount').html('$'+value+'.00');
        $('#subtotal').html('$'+value+'.00');
        $('#tax_amount').html('<del>$4.99</del>');
    });

    $('#checkoutForm').submit(function(e) {
        e.preventDefault();
        $('.invalid-feedback').html('');
        $('.invalid-feedback').css('display', 'none');
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        axios.post(url, data).then(function(response) {
            if(response.status == 200){
                window.location.replace(checkout_url);
            } else {
                toastr.error('Something went wrong.', 'Error');
            }
        }).catch(function(error) {
            errors = error.response.data.errors;
            $.each(errors, function (key, val) {
                $(`.error-${key}`).html(`${val}`);
                $(`.error-${key}`).css('display', 'inline-block');
            });
        });
    });
});