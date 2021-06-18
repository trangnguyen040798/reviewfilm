$('input[name=image]').fileinput({
	uploadUrl: route('client.account.upload-image'),
    uploadAsync: false,
    showCaption: false,
    fileActionSettings: {
        showRemove: true,
        showUpload: false,
        showZoom: true,
        showDrag: false
    },
    showUpload:true,
    showBrowse: false,
    overwriteInitial: false,
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: 'image', // image is the default and can be overridden in config below
    purifyHtml: true
});
$('input[name=image]').on('filebatchuploadsuccess', function(event, data, previewId, index) {
    var response = data.response;
    $('#UploadImage').hide();
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    $('.hello').find('img').attr('src', response.image);
});
$('input[name=thumbnail]').fileinput({
	uploadUrl: route('client.account.upload-thumbnail'),
    uploadAsync: false,
    showCaption: false,
    fileActionSettings: {
        showRemove: true,
        showUpload: false,
        showZoom: true,
        showDrag: false
    },
    showUpload:true,
    showBrowse: false,
    overwriteInitial: false,
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: 'image', // image is the default and can be overridden in config below
    purifyHtml: true
});
$('input[name=thumbnail]').on('filebatchuploadsuccess', function(event, data, previewId, index) {
    var response = data.response;
    $('#UploadThumbnail').hide();
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    $('.card-header').css({"background" : "url(" + response.thumbnail + ")"});
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#sendEmail').on('click', function() {
    $.ajax({
        type:'get',
        url: route('client.account.sendMail'),
        success:function(response) {
            if (!response.error) {
                toastr.success(response.message);
            }
        },
        error: function(jqXhr){
            
        }
    })
});
// delete 1
$(document).on('click', '.delete-item',function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    swal({
        name: "Bạn có muốn xoá không?",
        text: "Hãy xác nhận bên dưới!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Đồng ý!",
        cancelButtonText: "Hủy!",
        reverseButtons: !0
    }).then(function (e) {
        e.value && $.ajax({
            type: 'post',
            url: route('client.film.delete', [id]),
            success: function(response) {
                toastr.success(response.success);
                table.row('#film_' + id).remove().draw();
            }
        });    
    });
});
