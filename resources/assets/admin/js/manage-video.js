let table = $('#manage-video_table_1').DataTable({
    "order": [[ 1, "desc" ]],
});

//multi-delete
$(document).on('change', '#manage-video_table_1 input[type=checkbox]', function() {
    var count = 0;
    var checked = false;
    $('#manage-video_table_1 tbody').find('input[type=checkbox]').each(function() {
        if ($(this).prop('checked')) {
            count += 1; 
            checked = true;
        }
    })
    if (checked && count >0) {
        $('.multi-delete').css({'display' : 'block'});
        $('.count-delete').text(count);
    } else {
        $('.multi-delete').css({'display' : 'none'});
        $('.count-delete').text(0);
    }
    if ($(this).attr('name') == 'checkall') {
        if ($(this).prop('checked')) {
            $('#manage-video_table_1 tbody').find('input[type=checkbox]').prop({checked:true});
        } else {
            $('#manage-video_table_1 tbody').find('input[type=checkbox]').prop({checked:false});
        }
    }
    if (count == $('#manage-video_table_1 tbody').find('input[type=checkbox]').length) {
        $('#manage-video_table_1').find('input[name=checkall]').prop({checked:true});
    } else {
        $('#manage-video_table_1').find('input[name=checkall]').prop({checked:false});
    }   

})


$(document).on('click', '.multi-delete', function(e) {
    e.preventDefault();
    var listids = [];
    $('#manage-video_table_1 tbody').find('input[type=checkbox]').each(function() {
        if ($(this).prop('checked')) {
            listids.push(parseInt($(this).val()));
        }
    });
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
            url: route('admin.film.manage-video.multi-delete', [film_id]),
            data : {
                listids : listids,
            },
            success: function(response) {
                toastr.success(response.success);
                for (var i = 0; i < listids.length; i++) {
                    table.row('#manage-video_' + listids[i]).remove().draw();
                }
                $('.multi-delete').css({'display' : 'none'});
                $('.count-delete').text(0);
            }
        });    
    });
})

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
            url: route('admin.film.manage-video.delete', [film_id, id]),
            success: function(response) {
                toastr.success(response.success);
                table.row('#manage-video_' + id).remove().draw();
            }
        });    
    });
});