/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/admin/js/news.js":
/*!*******************************************!*\
  !*** ./resources/assets/admin/js/news.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var table = $('#news_table_1').DataTable({
  "order": [[1, "desc"]],
  "columnDefs": [{
    "targets": 0,
    "orderable": false
  }],
  "columns": [{
    "width": "5%"
  }, {
    "width": "5%"
  }, {
    "width": "20%"
  }, {
    "width": "40%"
  }, {
    "width": "10%"
  }, {
    "width": "20%"
  }]
});

function listBtn(response) {
  return '<button class="btn btn-primary btn-sm show-item" data-id="' + response.data.id + '" data-toggle="modal" data-target="#ShowItem"><i class="fa fa-eye"></i></button> <button class="btn btn-warning btn-sm edit-item" data-id="' + response.data.id + '" data-toggle="modal" data-target="#EditItem"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm delete-item" data-id="' + response.data.id + '"><i class="fa fa-trash"></i></button>';
}

$('input[name=input-b1]').fileinput({});
CKEDITOR.config.language = 'vi';

function updateAllMessageForms() {
  for (instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
  }
}

CKEDITOR.replace('content');
CKEDITOR.replace('update_content');
$('#form_add').submit(function (e) {
  e.preventDefault();

  if (!validate($('#AddItem'))) {
    return;
  }

  updateAllMessageForms();
  var form = new FormData(this);
  form.append('slug', convertToSlug(form.get('title')));
  $.ajax({
    type: 'POST',
    url: route('admin.news.create'),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        toastr.success(response.success);
        $("#form_add").trigger("reset");
        $("input[name=input-b1]").fileinput('destroy').fileinput({});
        $('#AddItem').modal('hide');
        table.row.add(['<input type="checkbox" value="' + response.data.id + '">', response.data.id, '<img src="' + response.data.image + '" />', response.data.title, response.data.views, listBtn(response)]).node().id = 'news_' + response.data.id;
        table.draw(false);
      }
    },
    error: function error(jqXhr) {
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
  });
}); // delete 1

$(document).on('click', '.delete-item', function (e) {
  e.preventDefault();
  var id = $(this).attr('data-id');
  swal({
    title: "B???n c?? mu???n xo?? kh??ng?",
    text: "H??y x??c nh???n b??n d?????i!",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "?????ng ??!",
    cancelButtonText: "H???y!",
    reverseButtons: !0
  }).then(function (e) {
    e.value && $.ajax({
      type: 'post',
      url: route('admin.news.delete', [id]),
      success: function success(response) {
        toastr.success(response.success);
        table.row('#news_' + id).remove().draw();
      }
    });
  });
}); // edit - get data

$(document).on('click', '.edit-item', function () {
  var id = $(this).attr('data-id');
  $('#form_edit').find('input[name=id]').val(id);
  $.ajax({
    type: 'get',
    url: route('admin.news.detail', [id]),
    success: function success(response) {
      $('#EditItem').find('input[name=title]').val(response.title);
      $('#EditItem').find('select[name=category]').val(response.category_id);
      CKEDITOR.instances.update_content.setData(response.content);
      $("input[name=update_image]").fileinput('destroy');
      $("input[name=update_image]").fileinput({
        autoReplace: true,
        overwriteInitial: true,
        showUploadedThumbs: false,
        maxFileCount: 1,
        initialPreview: ["<img class='kv-preview-data file-preview-image' src='" + response.image + "'>"],
        initialCaption: response.image,
        initialPreviewShowDelete: false,
        showRemove: false,
        showClose: false,
        layoutTemplates: {
          actionDelete: ''
        },
        // disable thumbnail deletion
        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
      });
      validate($('#EditItem'));
    },
    error: function error(jqXhr) {
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
  });
}); // update

$(document).on('submit', '#form_edit', function (e) {
  e.preventDefault();

  if (!validate($('#EditItem'))) {
    return;
  }

  updateAllMessageForms();
  var form = new FormData(this);
  form.append('slug', convertToSlug(form.get('title')));
  $.ajax({
    type: 'POST',
    url: route('admin.news.update'),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        toastr.success(response.success);
        $('#EditItem').modal('hide');
        var newdata = ['<input type="checkbox" value="' + response.data.id + '">', response.data.id, '<img src="' + response.data.image + '" />', response.data.title, response.data.views, listBtn(response)];
        table.row('#news_' + response.data.id).data(newdata).draw();
      }
    },
    error: function error(jqXhr) {
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
  });
}); // show

$(document).on('click', '.show-item', function () {
  var id = $(this).attr('data-id');
  $.ajax({
    type: 'get',
    url: route('admin.news.detail', id),
    success: function success(response) {
      console.log(response);
      $('#ShowItem').find('.name').text(response.title ? response.title : '...');
      $('#ShowItem').find('.category').text(response.category ? response.category.title : '...');
      $('#ShowItem').find('.avatar').attr("src", response.image ? response.image : '...');
      $('#ShowItem').find('.content').html(response.content ? response.content : '...');
      $('#ShowItem').find('.views').text(response.views ? response.views : '0');
    }
  });
});

function validate(modal) {
  var allreq = true;
  modal.find('.m-required').each(function () {
    if ($(this).val() == '') {
      if ($(this).attr('type') == 'file') {
        $(this).closest('.input-b1').next('.error-required').text('M???i b???n ch???n file');
        $('.file-preview ').css({
          'border-color': 'red'
        });
      }

      $(this).parent().parent().find('.error-required').text('M???i nh???p th??ng tin');
      $(this).css({
        "border-color": "red"
      });
      allreq = false;
    } else {
      $(this).parent().parent().find('.error-required').text('');
      $(this).css({
        "border-color": "#ebedf2"
      });

      if ($(this).attr('type') == 'file') {
        $('.file-input').next().text('');
        $('.file-preview ').css({
          'border-color': '#ebedf2'
        });
      }
    }
  });

  if (allreq == false) {
    return false;
  } else {
    return true;
  }
} //multi-delete


$(document).on('change', '#news_table_1 input[type=checkbox]', function () {
  var count = 0;
  var checked = false;
  $('#news_table_1 tbody').find('input[type=checkbox]').each(function () {
    if ($(this).prop('checked')) {
      count += 1;
      checked = true;
    }
  });

  if ($(this).attr('name') == 'checkall') {
    if ($(this).prop('checked')) {
      checked = true;
      count = $('#news_table_1 tbody').find('input[type=checkbox]').length;
      $('#news_table_1 tbody').find('input[type=checkbox]').prop({
        checked: true
      });
    } else {
      count = 0;
      checked = false;
      $('#news_table_1 tbody').find('input[type=checkbox]').prop({
        checked: false
      });
    }
  } else {
    if (count == $('#news_table_1 tbody').find('input[type=checkbox]').length) {
      $('#news_table_1').find('input[name=checkall]').prop({
        checked: true
      });
    } else {
      $('#news_table_1').find('input[name=checkall]').prop({
        checked: false
      });
    }
  }

  if (checked && count > 0) {
    $('.multi-delete').css({
      'display': 'block'
    });
    $('.count-delete').text(count);
  } else {
    $('.multi-delete').css({
      'display': 'none'
    });
    $('.count-delete').text(0);
  }
});
$(document).on('click', '.multi-delete', function (e) {
  e.preventDefault();
  var listids = [];
  $('#news_table_1 tbody').find('input[type=checkbox]').each(function () {
    if ($(this).prop('checked')) {
      listids.push(parseInt($(this).val()));
    }
  });
  swal({
    title: "B???n c?? mu???n xo?? kh??ng?",
    text: "H??y x??c nh???n b??n d?????i!",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "?????ng ??!",
    cancelButtonText: "H???y!",
    reverseButtons: !0
  }).then(function (e) {
    e.value && $.ajax({
      type: 'post',
      url: route('admin.news.multi-delete'),
      data: {
        listids: listids
      },
      success: function success(response) {
        toastr.success(response.success);

        for (var i = 0; i < listids.length; i++) {
          table.row('#news_' + listids[i]).remove().draw();
        }

        $('.multi-delete').css({
          'display': 'none'
        });
        $('.count-delete').text(0);
      }
    });
  });
});

function convertToSlug(Text) {
  var slug = Text.toLowerCase(); //?????i k?? t??? c?? d???u th??nh kh??ng d???u

  slug = slug.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'a');
  slug = slug.replace(/??|??|???|???|???|??|???|???|???|???|???/gi, 'e');
  slug = slug.replace(/i|??|??|???|??|???/gi, 'i');
  slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'o');
  slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???/gi, 'u');
  slug = slug.replace(/??|???|???|???|???/gi, 'y');
  slug = slug.replace(/??/gi, 'd'); //X??a c??c k?? t??? ?????t bi???t

  slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, ''); //?????i kho???ng tr???ng th??nh k?? t??? g???ch ngang

  slug = slug.replace(/ /gi, "-"); //?????i nhi???u k?? t??? g???ch ngang li??n ti???p th??nh 1 k?? t??? g???ch ngang
  //Ph??ng tr?????ng h???p ng?????i nh???p v??o qu?? nhi???u k?? t??? tr???ng

  slug = slug.replace(/\-\-\-\-\-/gi, '-');
  slug = slug.replace(/\-\-\-\-/gi, '-');
  slug = slug.replace(/\-\-\-/gi, '-');
  slug = slug.replace(/\-\-/gi, '-'); //X??a c??c k?? t??? g???ch ngang ??? ?????u v?? cu???i

  slug = '@' + slug + '@';
  slug = slug.replace(/\@\-|\-\@|\@/gi, ''); //In slug ra textbox c?? id ???slug???

  return slug;
}

/***/ }),

/***/ 7:
/*!*************************************************!*\
  !*** multi ./resources/assets/admin/js/news.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /opt/lampp/htdocs/reviewfilm/resources/assets/admin/js/news.js */"./resources/assets/admin/js/news.js");


/***/ })

/******/ });