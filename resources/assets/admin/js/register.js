$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
$(document).on('click', '#m_login_signup_submit', function(e) {
	e.preventDefault();
	var formData = new FormData();
	formData.append('name', $('#name').val());
	formData.append('email', $('#email').val());
	formData.append('password', $('#password').val());
	formData.append('rpassword', $('#rpassword').val());
	$.ajax( {
		type: 'post',
		processData: false,
		contentType: false,
		url: $("#hiddenasset").val() + 'register',
		data: formData,
		success: function(response) {
			window.location.href = response.url;
		},
		error: function(jqXHR, textStatus, errorThrown){
			if (jqXHR.responseJSON.errors.name !== undefined) {
				$('#error_name').text(jqXHR.responseJSON.errors.name[0]);
				$('#error_name').parent().css({'display' : 'block'});
			}
			if (jqXHR.responseJSON.errors.email !== undefined) {
				$('#error_email').text(jqXHR.responseJSON.errors.email[0]);
				$('#error_email').parent().css({'display' : 'block'});
			}
			if (jqXHR.responseJSON.errors.password !== undefined) {
				$('#error_password').text(jqXHR.responseJSON.errors.password[0]);
				$('#error_password').parent().css({'display' : 'block'});
			}
			if (jqXHR.responseJSON.errors.rpassword !== undefined) {
				$('#error_rpassword').text(jqXHR.responseJSON.errors.rpassword[0]);
				$('#error_rpassword').parent().css({'display' : 'block'});
			}
		}
	})
})

