$(document).ready(function() {
	$('.select-countries').select2({
		placeholder: "Chọn quốc gia",
    	allowClear: true
	});
	$('.select-categories').select2({
		placeholder: "Chọn thể loại",
    	allowClear: true
	})
});
$('#filter-btn').on('submit', function(e) {
	e.preventDefault();
	var form = new FormData(this);
	$.ajax({
        type:'POST',
        url: route('client.category.filter'),
        processData: false,
        contentType: false,
        dataType : 'json',
        data: form,
        success:function(response) {
            if (!response.error) {
                // toastr.success(response.success);
                var template = $('#handlebars-list-film').html();
                var templateScript = Handlebars.compile(template);
                var context = {
                    'films' : response.films
                };
                var html = templateScript(context);
                $('.list-film').html(html);
            }
        },
        error: function(jqXhr){
          	
        }
    })
})