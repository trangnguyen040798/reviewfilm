/*JS FOR SCROLLING THE ROW OF THUMBNAILS*/ 
$(document).ready(function () {
  	$('.add-name').click(function() {
  		$('.box-add-name').css({'display' : 'block'});
  		$(this).css({'display' : 'none'});
  	})
});

$('#saved-video-form').on('submit', function(e) {
	e.preventDefault();
	var form = new FormData(this);
	$.ajax({
        type:'POST',
        url: route('client.film.saved-video'),
        processData: false,
        contentType: false,
        dataType : 'json',
        data: form,
        success:function(response) {
            if (!response.error) {
            	$('.error_name_cate').css({'display' : 'none'});
            	$('.add-name').css({'display' : 'block'});
            	$('.box-add-name').css({'display' : 'none'});
                toastr.success(response.message);
                var html = '<div class="form-group"><input type="checkbox" name="checked" id="checkbox-' + (response.data.id - 1) + '" value="' + response.data.name_cate + '" checked>  <label for="checkbox-' + (response.data.id - 1) + '">' + response.data.name_cate + '</label></div>';
                $('.box-checkbox').append(html);
            }
        },
        error: function(jqXhr){
        	if (jqXhr.responseJSON.name_cate !== undefined) {
                $('.error_name_cate').css({'display' : 'block'});
          		$('.error_name_cate').text(jqXhr.responseJSON.name_cate[0]);
            }
            if (jqXhr.responseJSON.video_id !== undefined) {
                toastr.error(jqXhr.responseJSON.video_id[0]);
            }
        }
    })
})
$('input[type=checkbox]').on('change', function() {
	var form = new FormData();
	form.append('video_id', video_id);
	form.append('name_cate', $(this).val());
	$.ajax({
        type:'POST',
        url: route('client.film.saved-video'),
        processData: false,
        contentType: false,
        dataType : 'json',
        data: form,
        success:function(response) {
            if (!response.error) {
            	$('.error_name_cate').css({'display' : 'none'});
            	$('.add-name').css({'display' : 'block'});
            	$('.box-add-name').css({'display' : 'none'});
                toastr.success(response.message);
            }
        },
        error: function(jqXhr){
          	if (jqXhr.responseJSON.name_cate !== undefined) {
                toastr.error(jqXhr.responseJSON.name_cate[0]);
            }
            if (jqXhr.responseJSON.video_id !== undefined) {
                toastr.error(jqXhr.responseJSON.video_id[0]);
            }
        }
    })
})
