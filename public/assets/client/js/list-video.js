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
/******/ 	return __webpack_require__(__webpack_require__.s = 16);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/client/js/list-video.js":
/*!**************************************************!*\
  !*** ./resources/assets/client/js/list-video.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*JS FOR SCROLLING THE ROW OF THUMBNAILS*/
$(document).ready(function () {
  $('.add-name').click(function () {
    $('.box-add-name').css({
      'display': 'block'
    });
    $(this).css({
      'display': 'none'
    });
  });
});
$('#saved-video-form').on('submit', function (e) {
  e.preventDefault();
  var form = new FormData(this);
  $.ajax({
    type: 'POST',
    url: route('client.film.saved-video'),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        $('.error_name_cate').css({
          'display': 'none'
        });
        $('.add-name').css({
          'display': 'block'
        });
        $('.box-add-name').css({
          'display': 'none'
        });
        toastr.success(response.message);
        var html = '<div class="form-group"><input type="checkbox" name="checked" id="checkbox-' + (response.data.id - 1) + '" value="' + response.data.name_cate + '" checked>  <label for="checkbox-' + (response.data.id - 1) + '">' + response.data.name_cate + '</label></div>';
        $('.box-checkbox').append(html);
      }
    },
    error: function error(jqXhr) {
      if (jqXhr.responseJSON.name_cate !== undefined) {
        $('.error_name_cate').css({
          'display': 'block'
        });
        $('.error_name_cate').text(jqXhr.responseJSON.name_cate[0]);
      }

      if (jqXhr.responseJSON.video_id !== undefined) {
        toastr.error(jqXhr.responseJSON.video_id[0]);
      }
    }
  });
});
$('input[type=checkbox]').on('change', function () {
  var form = new FormData();
  form.append('video_id', video_id);
  form.append('name_cate', $(this).val());
  $.ajax({
    type: 'POST',
    url: route('client.film.saved-video'),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        $('.error_name_cate').css({
          'display': 'none'
        });
        $('.add-name').css({
          'display': 'block'
        });
        $('.box-add-name').css({
          'display': 'none'
        });
        toastr.success(response.message);
      }
    },
    error: function error(jqXhr) {
      if (jqXhr.responseJSON.name_cate !== undefined) {
        toastr.error(jqXhr.responseJSON.name_cate[0]);
      }

      if (jqXhr.responseJSON.video_id !== undefined) {
        toastr.error(jqXhr.responseJSON.video_id[0]);
      }
    }
  });
});

/***/ }),

/***/ 16:
/*!********************************************************!*\
  !*** multi ./resources/assets/client/js/list-video.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /opt/lampp/htdocs/reviewfilm/resources/assets/client/js/list-video.js */"./resources/assets/client/js/list-video.js");


/***/ })

/******/ });