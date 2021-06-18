$(document).on('click', '#preview-video', function() {
	var id = $(this).attr('data-id');
	var form = new FormData();
	form.append('id', id);
	$.ajax({
		type:'POST',
		url: route('client.film.manage-video.detail-video', [film_id]),
		processData: false,
		contentType: false,
		dataType : 'json',
		data: form,
		success:function(response) {
			$('.loading').css({'display' : 'none'});
			if (!response.error) {
				var template = $('#handlebars-videos-1').html();
				var templateScript = Handlebars.compile(template);
				var context = {
					'asset' : response.asset,
					'name' : response.link,
					'size' : response.size,
					'autoplay' : true
				};
				var html = templateScript(context);
				$('.preview-video').html(html);
			} else {
				toastr.error(response.message);
			}
		},
		error: function(jqXhr) {
			$('.loading').css({'display' : 'none'});
		}
	})
})
$(document).on('click', '.delete-video', function() {
	var id = $(this).attr('data-id');
	var form = new FormData();
	form.append('id', id);
	swal({
		title: "Bạn có muốn xoá không?",
		text: "Hãy xác nhận bên dưới!",
		type: "warning",
		showCancelButton: !0,
		confirmButtonText: "Đồng ý!",
		cancelButtonText: "Hủy!",
		reverseButtons: !0
	}).then(function (e) {
		e.value && $.ajax({
			type: 'post',
			processData: false,
			contentType: false,
			dataType : 'json',
			data: form,
			url: route('client.film.manage-video.delete-video', [film_id]),
			success: function(response) {
				toastr.success(response.success);
				$('.list-video').find('#item-video-' + id).remove();
			}
		});    
	});
})