let table = $('#film_table_1').DataTable({
    "order": [[ 1, "desc" ]],
});

CKEDITOR.replace('description1');
CKEDITOR.replace('description2');
CKEDITOR.config.language = 'vi';

$('input[name=release_date]').datepicker({
    format: "dd/mm/yyyy"
});

$(document).ready(function() {
    $('.select2-categories').select2();
    $('.select2-actors').select2();
    $('select[name=type]').change(function() {
        if($(this).val() == odd_film_type) {
            $('.more-info').css({'display' : 'block'});
        } else {
            $('.more-info').css({'display' : 'none'})
        }
    })
});

function actionBtn(routeMangeVideo, response) {
    var html = '<a href="' + routeMangeVideo + '"><button class="btn btn-info btn-sm manage-item" data-id="' + response.data.id + '" data-toggle="modal"><i class="fa fa-info"></i></button></a> <button class="btn btn-primary btn-sm show-item" data-id="' + response.data.id + '" data-toggle="modal" data-target="#ShowItem"><i class="fa fa-eye"></i></button> <button class="btn btn-warning btn-sm edit-item" data-id="' + response.data.id + '" data-toggle="modal" data-target="#EditItem"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm delete-item" data-id="' + response.data.id + '"> <i class="fa fa-trash"></i></button>';
    if (response.data.status == 0) {
        html += '<button class="btn btn-secondary btn-sm status-item" status="' + response.data.status + '" data-id="' + response.data.id + '"><i class="fa fa-toggle-on"></i></button>';
    } else {
        html += '<button class="btn btn-success btn-sm status-item" status="' + response.data.status + '" data-id="' + response.data.id + '"><i class="fa fa-toggle-on"></i></button>';
    }
    return html;
}

$('#form_add').submit(function(e) {
    e.preventDefault();
    if (!validate($('#AddItem'))) {
        return;
    }
    var form = new FormData(this);
    $.ajax({
        type:'POST',
        url: route('admin.film.create'),
        processData: false,
        contentType: false,
        dataType : 'json',
        data: form,
        success:function(response) {
            if (!response.error) {
                toastr.success(response.success);
                $('#AddItem').modal('hide');
                let routeMangeVideo = route('admin.film.manage-video.index', response.data.id);
                table.row.add([
                    '<input type="checkbox" value="' + response.data.id + '">',
                    response.data.id,
                    '<img src="'+ response.data.image +'" alt="">',
                    response.data.name,
                    response.data.year,
                    response.data.type,
                    response.data.complete == 0 ? 'Chưa hoàn' : 'Hoàn',
                    response.data.user.name,
                    actionBtn(routeMangeVideo, response)
                    ]).node().id = 'film_' + response.data.id;
                table.draw( false );
            }
        },
        error: function(jqXhr){
            if (jqXhr.responseJSON.errors.name !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.name[0]);
            }
            if (jqXhr.responseJSON.errors.othername !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.othername[0]);
            }
            if (jqXhr.responseJSON.errors.type !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.type[0]);
            }
            if (jqXhr.responseJSON.errors.year !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.year[0]);
            }
            if (jqXhr.responseJSON.errors.country_id !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.country_id[0]);
            }
            if (jqXhr.responseJSON.errors.total_episodes !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.total_episodes[0]);
            }
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
            url: route('admin.film.delete', [id]),
            success: function(response) {
                toastr.success(response.success);
                table.row('#film_' + id).remove().draw();
            }
        });    
    });
});

// edit - get data
$(document).on('click', '.edit-item', function() {
    var id = $(this).attr('data-id');
    $('#form_edit').find('input[name=id]').val(id);
    $.ajax({
        country_id : 'get',
        url : route('admin.film.detail', [id]),
        success : function(response) {
            $('#EditItem').find('input[name=name]').val(response.name);
            $('#EditItem').find('select[name=country_id]').val(response.country_id);
            $('#EditItem').find('input[name=othername]').val(response.othername);
            $('#EditItem').find('select[name=type]').val(response.type);
            $('#EditItem').find('input[name=year]').val(response.year);
            $('#EditItem').find('select[name=director_id]').val(response.director_id);
            $('#EditItem').find('input[name=total_episodes]').val(response.total_episodes);
            $('#EditItem').find('input[name=release_date]').val(response.release_date);
            $('#EditItem').find('textarea[name=description]').val(response.description);
            CKEDITOR.instances.description2.setData(response.description);
            let selected_category = [];
            for($i = 0; $i < response.categories.length; $i++) {
                selected_category.push(response.categories[$i].id);
            }
            $('#EditItem').find('.select2-categories').val(selected_category).trigger('change');
            let selected_actor = [];
            for($i = 0; $i < response.actors.length; $i++) {
                selected_actor.push(response.actors[$i].id);
            }
            $('#EditItem').find('.select2-actors').val(selected_actor).trigger('change');
            if(response.type == odd_film_type) {
                $('.more-info').css({'display' : 'block'});
            }
            $("#input-repl-1a").fileinput({
                uploadUrl: "/file-upload-batch/2",
                autoReplace: true,
                overwriteInitial: true,
                showUploadedThumbs: false,
                maxFileCount: 1,
                initialPreview: [
                "<img class='kv-preview-data file-preview-image' src='" + response.image + "'>"
                ],
                initialCaption: response.image,
                initialPreviewShowDelete: false,
                showRemove: false,
                showClose: false,
                layoutTemplates: {actionDelete: ''}, // disable thumbnail deletion
                allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
            });
            validate($('#EditItem'));
        }
    })
})

// update
$(document).on('submit', '#form_edit', function(e) {
    e.preventDefault();
    if (!validate($('#EditItem'))) {
        return;
    }
    var form = new FormData(this);
    $.ajax({
        type:'POST',
        url: route('admin.film.update'),
        processData: false,
        contentType: false,
        dataType : 'json',
        data: form,
        success:function(response) {
            if (!response.error) {
                toastr.success(response.success);
                $('#EditItem').modal('hide');
                let routeMangeVideo = route('admin.film.manage-video.index', response.data.id);
                var newdata = [
                    '<input type="checkbox" value="' + response.data.id + '">',
                    response.data.id,
                    '<img src="'+ response.data.image +'" alt="">',
                    response.data.name,
                    response.data.year,
                    response.data.type,
                    response.data.complete == 0 ? 'Chưa hoàn' : 'Hoàn',
                    response.data.user.name,
                    actionBtn(routeMangeVideo, response),
                ];
                table.row('#film_'+ response.data.id).data(newdata).draw();
            }
        },
        error: function(jqXhr){
            if (jqXhr.responseJSON.errors.name !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.name[0]);
            }
            if (jqXhr.responseJSON.errors.othername !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.othername[0]);
            }
            if (jqXhr.responseJSON.errors.type !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.type[0]);
            }
            if (jqXhr.responseJSON.errors.year !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.year[0]);
            }
            if (jqXhr.responseJSON.errors.country_id !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.country_id[0]);
            }
            if (jqXhr.responseJSON.errors.total_episodes !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.total_episodes[0]);
            }
            if (jqXhr.responseJSON.errors.categories !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.categories[0]);
            }
        }
    })
});

//detail
$(document).on('click', '.show-item', function() {
    var id = $(this).attr('data-id');
    $.ajax({
        type : 'get',
        url : route('admin.film.detail', id),
        success : function(response) {
            if (!response.categories.length) {
                var html = '...';
            } else {
                var template = $('#handlebars-tags-1').html();
                var templateScript = Handlebars.compile(template);
                var context = {
                    'data' : response.categories
                };
                var html = templateScript(context);
            }
            $('#ShowItem .category').html(html);
            if (!response.actors.length) {
                var html1 = '...';
            } else {
                var template1 = $('#handlebars-tags-2').html();
                var templateScript1 = Handlebars.compile(template1);
                var context1 = {
                    'data' : response.actors
                };
                var html1 = templateScript1(context1);
            }
            $('#ShowItem .actor').html(html1 );
            $('#ShowItem').find('.name').text(response.name ? response.name : '...');
            $('#ShowItem').find('.othername').text(response.othername ? response.othername : '...');
            $('#ShowItem').find('.avatar').attr("src", response.image ? response.image : '...');
            $('#ShowItem').find('.director').text(response.director ? response.director.name : '...');
            $('#ShowItem').find('.type').text(response.type_name ? response.type_name : '...');
            $('#ShowItem').find('.country').text(response.country ? response.country.title : '...');
            $('#ShowItem').find('.year').text(response.year ? response.year : '...');
            $('#ShowItem').find('.release_date').text(response.release_date ? response.release_date : '...');
            $('#ShowItem').find('.total_episodes').text(response.total_episodes ? response.total_episodes : '...');
            $('#ShowItem').find('.description').text(response.description ? response.description : '...');
        }
    })
})

function validate(modal) {
    var allreq = true;
    modal.find('.m-required').each(function() {
        if ($(this).val() == '') {
            $(this).parent().parent().find('.error-required').text('Mời nhập thông tin');
            $(this).css({"border-color" : "red"});
            allreq = false;
        } else {
            $(this).parent().parent().find('.error-required').text('');
            $(this).css({"border-color" : "#ebedf2"});
        }
    })
    if (allreq == false) {
        return  false;
    } else {
        return true;
    }
}

//multi-delete
$(document).on('change', '#film_table_1 input[type=checkbox]', function() {
    var count = 0;
    var checked = false;
    $('#film_table_1 tbody').find('input[type=checkbox]').each(function() {
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
            $('#film_table_1 tbody').find('input[type=checkbox]').prop({checked:true});
        } else {
            $('#film_table_1 tbody').find('input[type=checkbox]').prop({checked:false});
        }
    }
    if (count == $('#film_table_1 tbody').find('input[type=checkbox]').length) {
        $('#film_table_1').find('input[name=checkall]').prop({checked:true});
    } else {
        $('#film_table_1').find('input[name=checkall]').prop({checked:false});
    }   

})


$(document).on('click', '.multi-delete', function(e) {
    e.preventDefault();
    var listids = [];
    $('#film_table_1 tbody').find('input[type=checkbox]').each(function() {
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
            url: route('admin.film.multi-delete'),
            data : {
                listids : listids,
            },
            success: function(response) {
                toastr.success(response.success);
                for (var i = 0; i < listids.length; i++) {
                    table.row('#film_' + listids[i]).remove().draw();
                }
                $('.multi-delete').css({'display' : 'none'});
                $('.count-delete').text(0);
            }
        });    
    });
})

$(document).on('click', '.status-item', function() {
    if ($(this).attr('status') == "0") {
        var status = 1;
    } else {
        var status = 0;
    }
    var id = $(this).attr('data-id');
    swal('Đổi trạng thái hiển thị ?').then(function(e) {
        e.value && $.ajax({
            type: 'post',
            url : route('admin.film.status'),
            data : {
                'status' : status,
                'id' : id
            },
            success: function(response) {
                toastr.success(response.success);
                if (response.data.status == 0) {
                    var btnstatus = 'btn-secondary';
                } else {
                    var btnstatus = 'btn-success';
                }
                let routeMangeVideo = route('admin.film.manage-video.index', response.data.id);
                var newdata = [
                    '<input type="checkbox" value="' + response.data.id + '">',
                    response.data.id,
                    '<img src="'+ response.data.image +'" alt="">',
                    response.data.name,
                    response.data.year,
                    response.data.type,
                    response.data.complete == 0 ? 'Chưa hoàn' : 'Hoàn',
                    response.data.user.name,
                    actionBtn(routeMangeVideo, response),
                ];
                table.row('#film_'+ response.data.id).data(newdata).draw();
            }
        })
    })
})