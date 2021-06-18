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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/admin/js/country.js":
/*!**********************************************!*\
  !*** ./resources/assets/admin/js/country.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var table = $('#country_table_1').DataTable({
  "order": [[1, "desc"]],
  "columnDefs": [{
    "targets": 0,
    "orderable": false
  }]
});

function listBtn(response) {
  return '<button class="btn btn-warning btn-sm edit-item" data-id="' + response.data.id + '" data-toggle="modal" data-target="#EditItem"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-sm delete-item" data-id="' + response.data.id + '"><i class="fa fa-trash"></i></button>';
}

$('#form_add').submit(function (e) {
  e.preventDefault();

  if (!validate($('#AddItem'))) {
    return;
  }

  var form = new FormData(this);
  $.ajax({
    type: 'POST',
    url: route('admin.country.create'),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        toastr.success(response.success);
        $('#AddItem').modal('hide');
        $("#form_add").trigger("reset");
        table.row.add(['<input type="checkbox" value="' + response.data.id + '">', response.data.id, response.data.title, listBtn(response)]).node().id = 'country_' + response.data.id;
        table.draw(false);
      }
    },
    error: function error(jqXhr) {
      if (jqXhr.responseJSON.errors.title !== undefined) {
        toastr.error(jqXhr.responseJSON.errors.title[0]);
      }

      if (jqXhr.responseJSON.errors.lug !== undefined) {
        toastr.error(jqXhr.responseJSON.errors.lug[0]);
      }
    }
  });
}); // delete 1

$(document).on('click', '.delete-item', function (e) {
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
      url: route('admin.country.delete', [id]),
      success: function success(response) {
        toastr.success(response.success);
        table.row('#country_' + id).remove().draw();
      }
    });
  });
}); // edit - get data

$(document).on('click', '.edit-item', function () {
  var id = $(this).attr('data-id');
  $('#form_edit').find('input[name=id]').val(id);
  $.ajax({
    type: 'get',
    url: route('admin.country.detail', [id]),
    success: function success(response) {
      $('#EditItem').find('input[name=title]').val(response.title);
      validate($('#EditItem'));
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
    url: route('admin.country.update'),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        toastr.success(response.success);
        $('#EditItem').modal('hide');
        var newdata = ['<input type="checkbox" value="' + response.data.id + '">', response.data.id, response.data.title, listBtn(response)];
        table.row('#country_' + response.data.id).data(newdata).draw();
      }
    },
    error: function error(jqXhr) {
      if (jqXhr.responseJSON.errors.title !== undefined) {
        toastr.error(jqXhr.responseJSON.errors.title[0]);
      }

      if (jqXhr.responseJSON.errors.slug !== undefined) {
        toastr.error(jqXhr.responseJSON.errors.slug[0]);
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


$(document).on('change', '#country_table_1 input[type=checkbox]', function () {
  var count = 0;
  var checked = false;
  $('#country_table_1 tbody').find('input[type=checkbox]').each(function () {
    if ($(this).prop('checked')) {
      count += 1;
      checked = true;
    }
  });

  if ($(this).attr('name') == 'checkall') {
    if ($(this).prop('checked')) {
      checked = true;
      count = $('#country_table_1 tbody').find('input[type=checkbox]').length;
      $('#country_table_1 tbody').find('input[type=checkbox]').prop({
        checked: true
      });
    } else {
      count = 0;
      checked = false;
      $('#country_table_1 tbody').find('input[type=checkbox]').prop({
        checked: false
      });
    }
  } else {
    if (count == $('#country_table_1 tbody').find('input[type=checkbox]').length) {
      $('#country_table_1').find('input[name=checkall]').prop({
        checked: true
      });
    } else {
      $('#country_table_1').find('input[name=checkall]').prop({
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
  $('#country_table_1 tbody').find('input[type=checkbox]').each(function () {
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
      url: route('admin.country.multi-delete'),
      data: {
        listids: listids
      },
      success: function success(response) {
        toastr.success(response.success);

        for (var i = 0; i < listids.length; i++) {
          table.row('#country_' + listids[i]).remove().draw();
        }

        $('.multi-delete').css({
          'display': 'none'
        });
        $('.count-delete').text(0);
      }
    });
  });
});

/***/ }),

/***/ 4:
/*!****************************************************!*\
  !*** multi ./resources/assets/admin/js/country.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /opt/lampp/htdocs/reviewfilm/resources/assets/admin/js/country.js */"./resources/assets/admin/js/country.js");


/***/ })

/******/ });