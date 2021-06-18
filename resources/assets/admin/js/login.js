$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
$(document).on('click', '#m_login_signin_submit', function(e) {
	e.preventDefault();
	var formData = new FormData();
	formData.append('email', $('#email').val());
	formData.append('password', $('#password').val());
	if ($('input[name=remember]').prop('checked')) {
		formData.append('remember', true);
	}
	$.ajax( {
		type: 'post',
		processData: false,
		contentType: false,
		url: $("#hiddenasset").val() + 'login',
		data: formData,
		success: function(response) {
			if (response.error) {
				$('.alert-danger').css({'display' : 'block'});
				$('#error_login').text(response.error);
			} else {
				window.location.href = response.url;
			}
		},
		error: function(jqXHR, textStatus, errorThrown){
			if (jqXHR.responseJSON.errors.email !== undefined) {
				$('#error_email').text(jqXHR.responseJSON.errors.email[0]);
				$('#error_email').parent().css({'display' : 'block'});
			}
			if (jqXHR.responseJSON.errors.password !== undefined) {
				$('#error_password').text(jqXHR.responseJSON.errors.password[0]);
				$('#error_password').parent().css({'display' : 'block'});
			}
		}
	})
})
