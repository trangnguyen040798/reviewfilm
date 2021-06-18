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
/******/ 	return __webpack_require__(__webpack_require__.s = 14);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/client/js/account.js":
/*!***********************************************!*\
  !*** ./resources/assets/client/js/account.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

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
  showUpload: true,
  showBrowse: false,
  overwriteInitial: false,
  initialPreviewAsData: true,
  // identify if you are sending preview data only and not the raw markup
  initialPreviewFileType: 'image',
  // image is the default and can be overridden in config below
  purifyHtml: true
});
$('input[name=image]').on('filebatchuploadsuccess', function (event, data, previewId, index) {
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
  showUpload: true,
  showBrowse: false,
  overwriteInitial: false,
  initialPreviewAsData: true,
  // identify if you are sending preview data only and not the raw markup
  initialPreviewFileType: 'image',
  // image is the default and can be overridden in config below
  purifyHtml: true
});
$('input[name=thumbnail]').on('filebatchuploadsuccess', function (event, data, previewId, index) {
  var response = data.response;
  $('#UploadThumbnail').hide();
  $('body').removeClass('modal-open');
  $('.modal-backdrop').remove();
  $('.card-header').css({
    "background": "url(" + response.thumbnail + ")"
  });
});
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$('#sendEmail').on('click', function () {
  $.ajax({
    type: 'get',
    url: route('client.account.sendMail'),
    success: function success(response) {
      if (!response.error) {
        toastr.success(response.message);
      }
    },
    error: function error(jqXhr) {}
  });
}); // delete 1

$(document).on('click', '.delete-item', function (e) {
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
      success: function success(response) {
        toastr.success(response.success);
        table.row('#film_' + id).remove().draw();
      }
    });
  });
});

/***/ }),

/***/ 14:
/*!*****************************************************!*\
  !*** multi ./resources/assets/client/js/account.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /opt/lampp/htdocs/reviewfilm/resources/assets/client/js/account.js */"./resources/assets/client/js/account.js");


/***/ })

/******/ });