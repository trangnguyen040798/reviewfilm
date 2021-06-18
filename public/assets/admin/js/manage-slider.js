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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/admin/js/manage-slider.js":
/*!****************************************************!*\
  !*** ./resources/assets/admin/js/manage-slider.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var table1 = $('#manage-slider-1_table_1').DataTable({
  "order": [[1, "desc"]],
  "columns": [{
    "width": "5%"
  }, {
    "width": "5%"
  }, {
    "width": "15%"
  }, {
    "width": "5%"
  }, {
    "width": "15%"
  }, {
    "width": "40%"
  }, {
    "width": "15%"
  }]
});
var table2 = $('#manage-slider-2_table_1').DataTable({
  "order": [[1, "desc"]]
});
$(document).ready(function () {
  $('input[name=input-b1]').fileinput({});
});

function action_btn(response) {
  var html = '<span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Chi tiết phim">';

  if (response.data.film) {
    html += ' <button class="btn btn-primary btn-sm show-item" data-id="' + response.data.film.id + '" data-toggle="modal" data-target="#ShowItem"><i class="fa fa-eye"></i></button></span> <span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Sửa">';
  }

  html += ' <button class="btn btn-warning btn-sm edit-item" data-id="' + response.data.id + '" data-toggle="modal" data-target="#EditItem"><i class="fa fa-edit"></i></button></span> <span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa"><button class="btn btn-danger btn-sm delete-item" data-id="' + response.data.id + '"><i class="fa fa-trash"></i></button></span>';
  return html;
}

$('#form_add').submit(function (e) {
  e.preventDefault();

  if (!validate($('#AddItem'))) {
    return;
  }

  var form = new FormData(this);
  $.ajax({
    type: 'POST',
    url: route('admin.manage-slider.create'),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        toastr.success(response.success);
        $('#AddItem').modal('hide');

        if (response.data.film) {
          table2.row.add(['<input type="checkbox" value="' + response.data.id + '">', response.data.id, response.data.tag, response.data.film.name, response.data.film.user_name, action_btn(response)]).node().id = 'manage-slider_' + response.data.id;
          table2.draw(false);
        } else {
          table1.row.add(['<input type="checkbox" value="' + response.data.id + '">', response.data.id, '<img src="' + response.data.image + '" alt="">', response.data.tag, response.data.title, response.data.content, action_btn(response)]).node().id = 'manage-slider_' + response.data.id;
          table1.draw(false);
        }
      } else {
        toastr.error(response.error);
      }
    },
    error: function error(jqXhr) {
      if (jqXhr.responseJSON.errors.film_id !== undefined) {
        toastr.error(jqXhr.responseJSON.errors.film_id[0]);
      }

      if (jqXhr.responseJSON.errors.tag !== undefined) {
        toastr.error(jqXhr.responseJSON.errors.tag[0]);
      }
    }
  });
}); // delete 1

$(document).on('click', '.delete-item', function (e) {
  e.preventDefault();
  var id = $(this).attr('data-id');
  var parentTable = $(this).parents('table');
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
      url: route('admin.manage-slider.delete', [id]),
      success: function success(response) {
        toastr.success(response.success);

        if (parentTable.attr('id') == 'manage-slider-1_table_1') {
          table1.row('#manage-slider-1_' + id).remove().draw();
        } else if (parentTable.attr('id') == 'manage-slider-2_table_1') {
          table2.row('#manage-slider-2_' + id).remove().draw();
        }
      }
    });
  });
}); // edit - get data

$(document).on('click', '.edit-item', function () {
  var id = $(this).attr('data-id');
  $('#form_edit').find('input[name=id]').val(id);
  $.ajax({
    type: 'get',
    url: route('admin.manage-slider.detail', [id]),
    success: function success(response) {
      if (response.film) {
        var template = $('#handlebars-edit-search').html();
        var templateScript = Handlebars.compile(template);
        var context = {};
        var html = templateScript(context);
        $('#EditItem').find('.slideFType').fadeIn();
        $('#EditItem').find('.slideFType').html(html);
        $('#EditItem').find('input[name=name]').val(response.film.name);
        $('#EditItem').find('input[name=film_id]').val(response.film.id);
        $('#EditItem').find('select[name=tag]').val(response.tag);
      } else {
        var template = $('#handlebars-first-slider').html();
        var templateScript = Handlebars.compile(template);
        var context = {};
        var html = templateScript(context);
        $('#EditItem').find('.slideFType').fadeIn();
        $('#EditItem').find('.slideFType').html(html);
        $('#EditItem').find('select[name=tag]').val(response.tag);
        $('#EditItem').find('input[name=title]').val(response.title);
        $('#EditItem').find('textarea[name=content]').val(response.content);
        $('#EditItem').find("input[name=input-b1]").fileinput('destroy');
        $('#EditItem').find('input[name=input-b1]').fileinput({
          uploadUrl: "/file-upload-batch/2",
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
      }
    }
  });
}); // update

$(document).on('submit', '#form_edit', function (e) {
  e.preventDefault();
  console.log(validate($('#EditItem')));

  if (!validate($('#EditItem'))) {
    return;
  }

  var form = new FormData(this);
  $.ajax({
    type: 'POST',
    url: route('admin.manage-slider.update'),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        toastr.success(response.success);
        $('#EditItem').modal('hide');

        if (response.data.film) {
          var newdata = ['<input type="checkbox" value="' + response.data.id + '">', response.data.id, response.data.tag, response.data.film.name, response.data.film.user_name, action_btn(response)];
          table2.row('#manage-slider-2_' + response.data.id).data(newdata).draw();
        } else {
          var newdata = ['<input type="checkbox" value="' + response.data.id + '">', response.data.id, '<img src="' + response.data.image + '" alt="">', response.data.tag, response.data.title, response.data.content, action_btn(response)];
          table1.row('#manage-slider-1_' + response.data.id).data(newdata).draw();
        }
      }
    },
    error: function error(jqXhr) {
      if (jqXhr.responseJSON.errors.film_id !== undefined) {
        toastr.error(jqXhr.responseJSON.errors.film_id[0]);
      }

      if (jqXhr.responseJSON.errors.tag !== undefined) {
        toastr.error(jqXhr.responseJSON.errors.tag[0]);
      }
    }
  });
});

function validate(modal) {
  var allreq = true;
  modal.find('.m-required').each(function () {
    if ($(this).val() == '') {
      $(this).parent().parent().find('.error-required').text('Mời nhập thông tin');
      $(this).css({
        "border-color": "red"
      });
      allreq = false;
    } else {
      $(this).parent().parent().find('.error-required').text('');
      $(this).css({
        "border-color": "#ebedf2"
      });
    }
  });

  if (allreq == false) {
    return false;
  } else {
    return true;
  }
} //multi-delete


$(document).on('change', '#manage-slider-1_table_1 input[type=checkbox]', function () {
  var count = 0;
  var checked = false;
  $('#manage-slider-1_table_1 tbody').find('input[type=checkbox]').each(function () {
    if ($(this).prop('checked')) {
      count += 1;
      checked = true;
    }
  });

  if ($(this).attr('name') == 'checkall') {
    if ($(this).prop('checked')) {
      checked = true;
      count = $('#manage-slider-1_table_1 tbody').find('input[type=checkbox]').length;
      $('#manage-slider-1_table_1 tbody').find('input[type=checkbox]').prop({
        checked: true
      });
    } else {
      checked = false;
      $('#manage-slider-1_table_1 tbody').find('input[type=checkbox]').prop({
        checked: false
      });
    }
  } else {
    if (count == $('#manage-slider-1_table_1 tbody').find('input[type=checkbox]').length) {
      $('#manage-slider-1_table_1').find('input[name=checkall]').prop({
        checked: true
      });
    } else {
      $('#manage-slider-1_table_1').find('input[name=checkall]').prop({
        checked: false
      });
    }
  }

  if (checked && count > 0) {
    $('#manage-slider-1_table_1').parents('.dataTables_wrapper').prev().prev().prev('.multi-delete').css({
      'display': 'block'
    });
    $('#manage-slider-1_table_1').parents('.dataTables_wrapper').prev().prev().prev('.multi-delete').find('.count-delete').text(count);
  } else {
    $('#manage-slider-1_table_1').parents('.dataTables_wrapper').prev().prev().prev('.multi-delete').css({
      'display': 'none'
    });
    $('#manage-slider-1_table_1').parents('.dataTables_wrapper').prev().prev().prev('.multi-delete').find('.count-delete').text(0);
  }
});
$(document).on('change', '#manage-slider-2_table_1 input[type=checkbox]', function () {
  var count = 0;
  var checked = false;
  $('#manage-slider-2_table_1 tbody').find('input[type=checkbox]').each(function () {
    if ($(this).prop('checked')) {
      count += 1;
      checked = true;
    }
  });

  if ($(this).attr('name') == 'checkall') {
    if ($(this).prop('checked')) {
      checked = true;
      count = $('#manage-slider-2_table_1 tbody').find('input[type=checkbox]').length;
      $('#manage-slider-2_table_1 tbody').find('input[type=checkbox]').prop({
        checked: true
      });
    } else {
      checked = false;
      $('#manage-slider-2_table_1 tbody').find('input[type=checkbox]').prop({
        checked: false
      });
    }
  } else {
    if (count == $('#manage-slider-2_table_1 tbody').find('input[type=checkbox]').length) {
      $('#manage-slider-2_table_1').find('input[name=checkall]').prop({
        checked: true
      });
    } else {
      $('#manage-slider-2_table_1').find('input[name=checkall]').prop({
        checked: false
      });
    }
  }

  if (checked && count > 0) {
    $('#manage-slider-2_table_1').parents('.dataTables_wrapper').prev('.multi-delete').css({
      'display': 'block',
      'margin-bottom': '20px'
    });
    $('#manage-slider-2_table_1').parents('.dataTables_wrapper').prev('.multi-delete').find('.count-delete').text(count);
  } else {
    $('#manage-slider-2_table_1').parents('.dataTables_wrapper').prev('.multi-delete').css({
      'display': 'none'
    });
    $('#manage-slider-2_table_1').parents('.dataTables_wrapper').prev('.multi-delete').find('.count-delete').text(0);
  }
});
$(document).on('click', '.multi-delete', function (e) {
  e.preventDefault();
  var listids = [],
      currentTable = '';

  if ($(this).next('.manage-slider-2_table_1_wrapper').length) {
    currentTable = $('#manage-slider-2_table_1');
    currentTable.find('tbody').find('input[type=checkbox]').each(function () {
      if ($(this).prop('checked')) {
        listids.push(parseInt($(this).val()));
      }
    });
  } else {
    currentTable = $('#manage-slider-1_table_1');
    currentTable.find('tbody').find('input[type=checkbox]').each(function () {
      if ($(this).prop('checked')) {
        listids.push(parseInt($(this).val()));
      }
    });
  }

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
      url: route('admin.manage-slider.multi-delete'),
      data: {
        listids: listids
      },
      success: function success(response) {
        toastr.success(response.success);

        if (currentTable.attr('id') == 'manage-slider-1_table_1') {
          for (var i = 0; i < listids.length; i++) {
            table1.row('#manage-slider-1_' + listids[i]).remove().draw();
          }
        } else {
          for (var i = 0; i < listids.length; i++) {
            table2.row('#manage-slider-2_' + listids[i]).remove().draw();
          }
        }

        $('.multi-delete').css({
          'display': 'none'
        });
        $('.count-delete').text(0);
      }
    });
  });
});
$(document).on('keyup', '.search', function () {
  var name = $(this).val();
  console.log(name);
  $.ajax({
    type: 'get',
    url: route('admin.manage-slider.search'),
    data: {
      'name': name
    },
    success: function success(response) {
      if (response.length == 0) {
        $('.result-search').html('<p class="text-danger">Không tìm thấy phim</p>');
      } else {
        var template = $('#handlebars-result-search').html();
        var templateScript = Handlebars.compile(template);
        var context = {
          'data': response
        };
        var html = templateScript(context);
        $('.result-search').fadeIn();
        $('.result-search').html(html);
      }
    }
  });
});
$('.edit-search').on('input', function () {
  var name = $(this).val();
  $.ajax({
    type: 'get',
    url: route('admin.manage-slider.search'),
    data: {
      'name': name
    },
    success: function success(response) {
      if (response.length == 0) {
        $('.edit-result-search').html('<p class="text-danger">Không tìm thấy phim</p>');
      } else {
        var template = $('#handlebars-result-search').html();
        var templateScript = Handlebars.compile(template);
        var context = {
          'data': response
        };
        var html = templateScript(context);
        $('.edit-result-search').fadeIn();
        $('.edit-result-search').html(html);
      }
    }
  });
});
$(document).on('click', '.result-search li', function () {
  $('.search').val($(this).find('.film_name').text());
  $('#AddItem').find('input[name=film_id]').val($(this).attr('film_id'));
  $('.result-search').fadeOut();
});
$(document).on('click', '.edit-result-search li', function () {
  $('.edit-search').val($(this).find('.film_name').text());
  $('#EditItem').find('input[name=film_id]').val($(this).attr('film_id'));
  $('.edit-result-search').fadeOut();
});
$(document).on('click', '.show-item', function () {
  var id = $(this).attr('data-id');
  $.ajax({
    type: 'get',
    url: route('admin.film.detail', id),
    success: function success(response) {
      if (!response.categories.length) {
        var html = '...';
      } else {
        var template = $('#handlebars-tags-1').html();
        var templateScript = Handlebars.compile(template);
        var context = {
          'data': response.categories
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
          'data': response.actors
        };
        var html1 = templateScript1(context1);
      }

      $('#ShowItem .actor').html(html1);
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
  });
});
$(document).on('change', 'select[name=tag]', function () {
  if ($(this).val() == 1) {
    var template = $('#handlebars-first-slider').html();
    var templateScript = Handlebars.compile(template);
    var context = {};
    var html = templateScript(context);
    $('.slideFType').fadeIn();
    $('.slideFType').html(html);
    $('input[name=input-b1]').fileinput({});
  } else if ($(this).val() == 2) {
    var template = $('#handlebars-search').html();
    var templateScript = Handlebars.compile(template);
    var context = {};
    var html = templateScript(context);
    $('.slideFType').fadeIn();
    $('.slideFType').html(html);
  }
});

/***/ }),

/***/ 10:
/*!**********************************************************!*\
  !*** multi ./resources/assets/admin/js/manage-slider.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /opt/lampp/htdocs/reviewfilm/resources/assets/admin/js/manage-slider.js */"./resources/assets/admin/js/manage-slider.js");


/***/ })

/******/ });