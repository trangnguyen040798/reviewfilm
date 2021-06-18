$('#updateAccount').submit(function(e) {
    e.preventDefault();
    if (!validate()) {
        return;
    }
    var form = new FormData(this);
    $.ajax({
        type:'POST',
        url: route('client.account.update'),
        processData: false,
        contentType: false,
        dataType : 'json',
        data: form,
        success:function(response) {
            if (!response.error) {
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
        error: function(jqXhr){
            if (jqXhr.responseJSON.errors.email !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.email[0]);
            }
            if (jqXhr.responseJSON.errors.name !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.name[0]);
            }
        }
    })
});

function validate() {
    var flag_email, flag_name = true;
    if (!IsEmail($('.input_email').val())) {
        $('.input_email').next().find('.error_email').text('Định dạng email sai');
        $('.input_email]').css({"border-color" : "red"});
        flag_email = false;
    } else {
        $('.input_email').next().find('.error_email').text('');
        $('.input_email').css({"border-color" : "#ebedf2"});
    }
    if ($('.input_name').val() == '') {
        $('.input_name').next().find('.error_name').text('Tên tài khoản không được để trống');
        $('.input_name').css({"border-color" : "red"});
        flag_name = false;
    } else {
        $('.input_name').next().find('.error_name').text('');
        $('.input_name').css({"border-color" : "#ebedf2"});
    }
   
    if (flag_email == false || flag_name == false) {
        return  false;
    } else {
        return true;
    }
}