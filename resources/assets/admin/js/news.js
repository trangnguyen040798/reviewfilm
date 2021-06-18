let table = $('#news_table_1').DataTable({
    "order": [[ 1, "desc" ]],
    "columnDefs": [
    { "targets": 0, "orderable": false}
    ],
    "columns": [
    { "width": "5%" },
    { "width": "5%" },
    { "width": "20%" },
    { "width": "40%" },
    { "width": "10%" },
    { "width": "20%" },
    ]
});

function listBtn(response) {
    return '<button class="btn btn-primary btn-sm show-item" data-id="' + response.data.id + '" data-toggle="modal" data-target="#ShowItem"><i class="fa fa-eye"></i></button> <button class="btn btn-warning btn-sm edit-item" data-id="' + response.data.id + '" data-toggle="modal" data-target="#EditItem"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm delete-item" data-id="' + response.data.id + '"><i class="fa fa-trash"></i></button>';
}

$('input[name=input-b1]').fileinput({});
CKEDITOR.config.language = 'vi';
function updateAllMessageForms()
{
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

CKEDITOR.replace('content');
CKEDITOR.replace('update_content');

$('#form_add').submit(function(e) {
    e.preventDefault();
    if (!validate($('#AddItem'))) {
        return;
    }
    updateAllMessageForms();
    var form = new FormData(this);
    form.append('slug', convertToSlug(form.get('title')));
    $.ajax({
        type:'POST',
        url: route('admin.news.create'),
        processData: false,
        contentType: false,
        dataType : 'json',
        data: form,
        success:function(response) {
            if (!response.error) {
                toastr.success(response.success);
                $("#form_add").trigger("reset");
                $("input[name=input-b1]").fileinput('destroy').fileinput({});
                $('#AddItem').modal('hide');
                table.row.add([
                    '<input type="checkbox" value="' + response.data.id + '">',
                    response.data.id,
                    '<img src="' + response.data.image + '" />',
                    response.data.title,
                    response.data.views,
                    listBtn(response)
                    ]).node().id = 'news_' + response.data.id;
                table.draw( false );
            }
        },
        error: function(jqXhr){
            if (jqXhr.responseJSON.errors.title !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.title[0]);
            }
            if (jqXhr.responseJSON.errors.slug !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.slug[0]);
            }
            if (jqXhr.responseJSON.errors.category_id !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.category_id[0]);
            }
            if (jqXhr.responseJSON.errors.image !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.image[0]);
            }
            if (jqXhr.responseJSON.errors.content !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.content[0]);
            }
        }
    })
});

// delete 1
$(document).on('click', '.delete-item',function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
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
            url: route('admin.news.delete', [id]),
            success: function(response) {
                toastr.success(response.success);
                table.row('#news_' + id).remove().draw();
            }
        });    
    });
});

// edit - get data
$(document).on('click', '.edit-item', function() {
    var id = $(this).attr('data-id');
    $('#form_edit').find('input[name=id]').val(id);
    $.ajax({
        type : 'get',
        url : route('admin.news.detail', [id]),
        success : function(response) {
            $('#EditItem').find('input[name=title]').val(response.title);
            $('#EditItem').find('select[name=category]').val(response.category_id);
            CKEDITOR.instances.update_content.setData(response.content);
            $("input[name=update_image]").fileinput('destroy');
            $("input[name=update_image]").fileinput({
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
        ,
        error: function(jqXhr){
            if (jqXhr.responseJSON.errors.title !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.title[0]);
            }
            if (jqXhr.responseJSON.errors.slug !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.slug[0]);
            }
            if (jqXhr.responseJSON.errors.category_id !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.category_id[0]);
            }
            if (jqXhr.responseJSON.errors.update_image !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.update_image[0]);
            }
            if (jqXhr.responseJSON.errors.update_content !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.update_content[0]);
            }
        }
    })
})

// update
$(document).on('submit', '#form_edit', function(e) {
    e.preventDefault();
    if (!validate($('#EditItem'))) {
        return;
    }
    updateAllMessageForms();
    var form = new FormData(this);
    form.append('slug', convertToSlug(form.get('title')));
    $.ajax({
        type:'POST',
        url: route('admin.news.update'),
        processData: false,
        contentType: false,
        dataType : 'json',
        data: form,
        success:function(response) {
            if (!response.error) {
                toastr.success(response.success);
                $('#EditItem').modal('hide');
                var newdata = [
                '<input type="checkbox" value="' + response.data.id + '">',
                response.data.id,
                '<img src="' + response.data.image + '" />',
                response.data.title,
                response.data.views,
                listBtn(response)
                ];
                table.row('#news_'+ response.data.id).data(newdata).draw();
            }
        },
        error: function(jqXhr){
            if (jqXhr.responseJSON.errors.title !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.title[0]);
            }
            if (jqXhr.responseJSON.errors.slug !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.slug[0]);
            }
            if (jqXhr.responseJSON.errors.type !== undefined) {
                toastr.error(jqXhr.responseJSON.errors.type[0]);
            }
        }
    })
});

// show
$(document).on('click', '.show-item', function() {
    var id = $(this).attr('data-id');
    $.ajax({
        type : 'get',
        url : route('admin.news.detail', id),
        success : function(response) {
            console.log(response);
            $('#ShowItem').find('.name').text(response.title ? response.title : '...');
            $('#ShowItem').find('.category').text(response.category ? response.category.title : '...');
            $('#ShowItem').find('.avatar').attr("src", response.image ? response.image : '...');
            $('#ShowItem').find('.content').html(response.content ? response.content : '...');
            $('#ShowItem').find('.views').text(response.views ? response.views : '0');
        }
    })
})

function validate(modal) {
    var allreq = true;
    modal.find('.m-required').each(function() {
        if ($(this).val() == '') {
            if ($(this).attr('type') == 'file') {
                $(this).closest('.input-b1').next('.error-required').text('Mời bạn chọn file');
                $('.file-preview ').css({'border-color' : 'red'});
            }
            $(this).parent().parent().find('.error-required').text('Mời nhập thông tin');
            $(this).css({"border-color" : "red"});
            allreq = false;
        } else {
            $(this).parent().parent().find('.error-required').text('');
            $(this).css({"border-color" : "#ebedf2"});
            if ($(this).attr('type') == 'file') {
                $('.file-input').next().text('');
                $('.file-preview ').css({'border-color' : '#ebedf2'});
            }
        }
    })
    if (allreq == false) {
        return  false;
    } else {
        return true;
    }
}

//multi-delete
$(document).on('change', '#news_table_1 input[type=checkbox]', function() {
    var count = 0;
    var checked = false;
    $('#news_table_1 tbody').find('input[type=checkbox]').each(function() {
        if ($(this).prop('checked')) {
            count += 1; 
            checked = true;
        }
    })
    if ($(this).attr('name') == 'checkall') {
        if ($(this).prop('checked')) {
            checked = true;
            count = $('#news_table_1 tbody').find('input[type=checkbox]').length;
            $('#news_table_1 tbody').find('input[type=checkbox]').prop({checked:true});
        } else {
            count = 0;
            checked = false;
            $('#news_table_1 tbody').find('input[type=checkbox]').prop({checked:false});
        }
    } else {
        if (count == $('#news_table_1 tbody').find('input[type=checkbox]').length) {
            $('#news_table_1').find('input[name=checkall]').prop({checked:true});
        } else {
            $('#news_table_1').find('input[name=checkall]').prop({checked:false});
        }   
    }
    if (checked && count > 0) {
        $('.multi-delete').css({'display' : 'block'});
        $('.count-delete').text(count);
    } else {
        $('.multi-delete').css({'display' : 'none'});
        $('.count-delete').text(0);
    }
})


$(document).on('click', '.multi-delete', function(e) {
    e.preventDefault();
    var listids = [];
    $('#news_table_1 tbody').find('input[type=checkbox]').each(function() {
        if ($(this).prop('checked')) {
            listids.push(parseInt($(this).val()));
        }
    });

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
            url: route('admin.news.multi-delete'),
            data : {
                listids : listids,
            },
            success: function(response) {
                toastr.success(response.success);
                for (var i = 0; i < listids.length; i++) {
                    table.row('#news_' + listids[i]).remove().draw();
                }
                $('.multi-delete').css({'display' : 'none'});
                $('.count-delete').text(0);
            }
        });    
    });
})

function convertToSlug(Text)
{
    var slug = Text.toLowerCase();

    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    //In slug ra textbox có id “slug”
    return slug;
}