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
/******/ 	return __webpack_require__(__webpack_require__.s = 12);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/client/js/create-video.js":
/*!****************************************************!*\
  !*** ./resources/assets/client/js/create-video.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(".file").fileinput({
  maxFilePreviewSize: 30000,
  uploadUrl: route('client.film.manage-video.combine-video', [film_id]),
  uploadAsync: false,
  showCaption: false,
  fileActionSettings: {
    showRemove: true,
    showUpload: false,
    showZoom: true,
    showDrag: false
  },
  showUpload: false,
  showBrowse: false,
  allowedFileExtensions: ["mp4"],
  overwriteInitial: true,
  initialPreviewAsData: true,
  // identify if you are sending preview data only and not the raw markup
  initialPreviewFileType: 'video',
  // image is the default and can be overridden in config below
  purifyHtml: true // this by default purifies HTML data for preview

}).on('filesorted', function (e, params) {
  console.log('File sorted params', params);
}).on('fileuploaded', function (e, params) {
  console.log('File uploaded params', params);
});

function sort_asc_li(a, b) {
  return $(b).data('id') < $(a).data('id') ? 1 : -1;
}

function sort_decs_li(a, b) {
  return $(b).data('id') > $(a).data('id') ? 1 : -1;
}

$(document).on('change', '.index', function () {
  str = $(this).attr('index').split('-');
  var index = $(this).val();
  str_index = str[0] + '-' + index + '-' + str[2];
  $(this).attr('index', str_index);
  $(this).closest('.dd-item').attr('data-id', index);
});
$(document).on('change', '.dd-list', function () {
  if ($('.sorted-button').find('.fa-sort-asc')) {
    $(".dd-list li").sort(sort_asc_li).appendTo('.dd-list');
  } else {
    $(".dd-list li").sort(sort_desc_li).appendTo('.dd-list');
  }
});
$('.uploadVideo').on('submit', function (e) {
  e.preventDefault();
  $('.loading').css({
    'display': 'block'
  });
  var form = new FormData(this);
  var index = [];
  $('.index').each(function () {
    index.push($(this).attr('index'));
  });
  form.append('index', index);
  form.append('episode', $('input[name=episode]').val());
  $.ajax({
    type: 'POST',
    url: route('client.film.manage-video.combine-video', [film_id]),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      $('.loading').css({
        'display': 'none'
      });

      if (!response.error) {
        var template = $('#handlebars-videos-1').html();
        var templateScript = Handlebars.compile(template);
        var combineVideo = response.fileName;
        var asset = response.asset;
        var size = response.size;
        var context = {
          'asset': asset,
          'name': combineVideo,
          'size': size
        };
        var html = templateScript(context);
        $('.combine-video').html(html);
        $('input[name=episode]').attr('readonly', '');
        $('input[name=episode]').val(response.episode);
      } else {
        toastr.error(response.message);
      }
    },
    error: function error(jqXhr) {
      $('.loading').css({
        'display': 'none'
      });

      if (jqXhr.responseJSON.file !== undefined) {
        toastr.error(jqXhr.responseJSON.file[0]);
      }

      if (jqXhr.responseJSON.episode !== undefined) {
        toastr.error(jqXhr.responseJSON.episode[0]);
      }

      if (jqXhr.responseJSON.film_id !== undefined) {
        toastr.error(jqXhr.responseJSON.film_id[0]);
      }
    }
  });
});
$('.updateVideo').on('submit', function (e) {
  e.preventDefault();
  $('.loading').css({
    'display': 'block'
  });
  var form = new FormData(this);
  var index = [];
  $('.index').each(function () {
    index.push($(this).attr('index'));
  });
  var list_id = [];
  $('input[name=id]').each(function () {
    list_id.push($(this).val());
  });
  form.append('index', index);
  form.append('list_id', list_id);
  form.append('episode', $('input[name=episode]').val());
  $.ajax({
    type: 'POST',
    url: route('client.film.manage-video.combine-video', [film_id]),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      $('.loading').css({
        'display': 'none'
      });

      if (!response.error) {
        var template = $('#handlebars-videos-1').html();
        var templateScript = Handlebars.compile(template);
        var combineVideo = response.fileName;
        var asset = response.asset;
        var size = response.size;
        var context = {
          'asset': asset,
          'name': combineVideo,
          'size': size
        };
        var html = templateScript(context);
        $('.combine-video').html(html);
      } else {
        toastr.error(response.message);
      }
    },
    error: function error(jqXhr) {
      $('.loading').css({
        'display': 'none'
      });

      if (jqXhr.responseJSON.file !== undefined) {
        toastr.error(jqXhr.responseJSON.file[0]);
      }

      if (jqXhr.responseJSON.episode !== undefined) {
        toastr.error(jqXhr.responseJSON.episode[0]);
      }

      if (jqXhr.responseJSON.film_id !== undefined) {
        toastr.error(jqXhr.responseJSON.film_id[0]);
      }
    }
  });
});
$(document).on('click', '.kv-file-remove', function () {
  var fileName = $(this).closest('.file-preview-frame').find('.file-caption-info').text();
  fileName = fileName.replace(/ /g, '').replace(/[^a-zA-Z ]/g, '');
  $('li[fileName=' + fileName + ']').remove();
});
$(document).on('click', '.button-delete', function () {
  fileName = $(this).prev().attr('fileName');

  if (fileName) {
    fileName = fileName.replace('(', '_').replace(')', '_').replace('[', '_').replace(']', '_');
    $('.file-preview-frame').each(function () {
      if ($(this).attr('title') == fileName) {
        $(this).remove();
      }
    });
  }

  $(this).closest('.dd-item').remove();

  if ($('.button-delete').length == 0) {
    var _$$fileinput$fileinpu;

    $('.file').fileinput('destroy').fileinput((_$$fileinput$fileinpu = {
      maxFilePreviewSize: 30000,
      uploadUrl: route('client.film.manage-video.combine-video', [film_id]),
      uploadAsync: false,
      showCaption: false,
      fileActionSettings: {
        showRemove: true,
        showUpload: false,
        showZoom: true,
        showDrag: false
      },
      showUpload: false,
      showBrowse: false,
      allowedFileExtensions: ["mp4"],
      overwriteInitial: true
    }, _defineProperty(_$$fileinput$fileinpu, "showBrowse", false), _defineProperty(_$$fileinput$fileinpu, "browseOnZoneClick", true), _defineProperty(_$$fileinput$fileinpu, "initialPreviewAsData", true), _defineProperty(_$$fileinput$fileinpu, "initialPreviewFileType", 'video'), _defineProperty(_$$fileinput$fileinpu, "purifyHtml", true), _$$fileinput$fileinpu)).on('filesorted', function (e, params) {
      console.log('File sorted params', params);
    }).on('fileuploaded', function (e, params) {
      console.log('File uploaded params', params);
    });
  }
});
$("input[name=image_video]").fileinput({
  maxFilePreviewSize: 30000,
  uploadAsync: false,
  showCaption: false,
  fileActionSettings: {
    showRemove: true,
    showUpload: false,
    showZoom: true,
    showDrag: false
  },
  showBrowse: false,
  overwriteInitial: false,
  initialPreviewAsData: true,
  // identify if you are sending preview data only and not the raw markup
  initialPreviewFileType: 'image',
  // image is the default and can be overridden in config below
  purifyHtml: true // this by default purifies HTML data for preview

});
$('#createAudio').submit(function (e) {
  e.preventDefault();
  $('.loading').css({
    'display': 'block'
  });
  $('.combine-audio').html('');
  var form = new FormData(this);
  form.append("speed", $('.speed').val());
  form.append("episode", $('input[name=episode]').val());
  $.ajax({
    type: 'POST',
    url: route('client.film.manage-video.create-audio', [film_id]),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      $('.loading').css({
        'display': 'none'
      });

      if (!response.error) {
        toastr.success(response.success);
        var template = $('#handlebars-audios-1').html();
        var templateScript = Handlebars.compile(template);
        var asset = response.asset;
        var fileName = response.fileName;
        var size = response.size;
        var duration = response.duration;
        var context = {
          'asset': asset,
          'fileName': fileName,
          'size': size,
          'duration': duration.substr(3, 7),
          'key': 1
        };
        var html = templateScript(context);
        $('.combine-audio').html(html);
        $('input[name=episode]').attr('readonly', '');
        $('input[name=episode]').val(response.episode);
        window.combine_audio = $('.combine-audio ').find("audio")[0];
        window.combine_audio.addEventListener("timeupdate", updateProgress, false);
      } else {
        $('.loading').css({
          'display': 'none'
        });
        toastr.error(response.message);
      }
    },
    error: function error(jqXhr) {
      $('.loading').css({
        'display': 'none'
      });

      if (jqXhr.responseJSON.audio !== undefined) {
        toastr.error(jqXhr.responseJSON.audio[0]);
      }

      if (jqXhr.responseJSON.type !== undefined) {
        toastr.error(jqXhr.responseJSON.type[0]);
      }

      if (jqXhr.responseJSON.episode !== undefined) {
        toastr.error(jqXhr.responseJSON.episode[0]);
      }
    }
  });
});
$(document).on('keyup', 'textarea', function () {
  $("#count-characters").text($(this).val().length);
});
$('#createFinalVideo').submit(function (e) {
  e.preventDefault();
  $('.final-video').html('');
  $('.loading').css({
    'display': 'block'
  });
  var form = new FormData(this);
  form.append('episode', $('input[name=episode]').val());
  $.ajax({
    type: 'POST',
    url: route('client.film.manage-video.store-video', [film_id]),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      $('.loading').css({
        'display': 'none'
      });

      if (!response.error) {
        toastr.success(response.success);
        var template = $('#handlebars-videos-1').html();
        var templateScript = Handlebars.compile(template);
        var context = {
          'asset': response.asset,
          'name': response.fileName,
          'size': response.size
        };
        var html = templateScript(context);
        $('.final-video').html(html);
      } else {
        $('.loading').css({
          'display': 'none'
        });
        toastr.error(response.message);
      }
    },
    error: function error(jqXhr) {
      $('.loading').css({
        'display': 'none'
      });

      if (jqXhr.responseJSON.episode !== undefined) {
        toastr.error(jqXhr.responseJSON.episode[0]);
      }

      if (jqXhr.responseJSON.image_video !== undefined) {
        toastr.error(jqXhr.responseJSON.image_video[0]);
      }

      if (jqXhr.responseJSON.film_id !== undefined) {
        toastr.error(jqXhr.responseJSON.film_id[0]);
      }
    }
  });
});
$('#addSoundBG').submit(function (e) {
  e.preventDefault();
  $('.sound-bg').html('');
  $('.loading').css({
    'display': 'block'
  });
  var form = new FormData(this);
  form.append("volume", $('.volume').val());
  form.append('episode', $('input[name=episode]').val());
  $.ajax({
    type: 'POST',
    url: route('client.film.manage-video.add-soundbg', [film_id]),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        $('.loading').css({
          'display': 'none'
        });
        toastr.success(response.success);
        var template = $('#handlebars-audios-1').html();
        var templateScript = Handlebars.compile(template);
        var asset = response.asset;
        var fileName = response.fileName;
        var size = response.size;
        var duration = response.duration;
        var context = {
          'asset': asset,
          'fileName': fileName,
          'size': size,
          'duration': duration.substr(3, 7),
          'key': 2
        };
        var html = templateScript(context);
        $('.sound-bg').html(html);
        $('input[name=episode]').attr('readonly', '');
        $('input[name=episode]').val(response.episode);
        window.bg_audio = $('.sound-bg ').find("audio")[0];
        window.bg_audio.addEventListener("timeupdate", updateProgress, false);
      } else {
        $('.loading').css({
          'display': 'none'
        });
        toastr.error(response.message);
      }
    },
    error: function error(jqXhr) {
      console.log(jqXhr.responseJSON);
      $('.loading').css({
        'display': 'none'
      });

      if (jqXhr.responseJSON.sound_bg !== undefined) {
        toastr.error(jqXhr.responseJSON.sound_bg[0]);
      }

      if (jqXhr.responseJSON.film_id !== undefined) {
        toastr.error(jqXhr.responseJSON.film_id[0]);
      }

      if (jqXhr.responseJSON.episode !== undefined) {
        toastr.error(jqXhr.responseJSON.episode[0]);
      }
    }
  });
});
$("input[name=sound_bg").fileinput({
  maxFilePreviewSize: 500000,
  uploadAsync: false,
  showCaption: false,
  fileActionSettings: {
    showRemove: true,
    showUpload: false,
    showZoom: true,
    showDrag: false
  },
  showUpload: false,
  showBrowse: false
}).on('filesorted', function (e, params) {
  console.log('File sorted params', params);
}).on('fileuploaded', function (e, params) {
  console.log('File uploaded params', params);
});
$('.title_tab > li').on('click', function () {
  if ($(this).attr('class') == 'tab2') {
    $('.tour-tabs').find('.active').removeClass('active');
    $('.tab2').addClass('active');
  }

  if ($(this).attr('class') == 'tab3') {
    $('.tour-tabs').find('.active').removeClass('active');
    $('.tab3').addClass('active');
  }

  if ($(this).attr('class') == 'tab4') {
    $('.tour-tabs').find('.active').removeClass('active');
    $('.tab4').addClass('active');
  }

  if ($(this).attr('class') == 'tab1') {
    $('.tour-tabs').find('.active').removeClass('active');
    $('.tab1').addClass('active');
  }
});
var rangeInputs = document.querySelectorAll('input[type="range"]');
var numberInput = document.querySelector('input[type="number"]');

function handleInputChange(e) {
  var target = e.target;

  if (e.target.type !== 'range') {
    target = document.getElementById('range');
  }

  var min = target.min;
  var max = target.max;
  var val = target.value;
  target.style.backgroundSize = (val - min) * 100 / (max - min) + '% 100%';
}

rangeInputs.forEach(function (input) {
  input.addEventListener('input', handleInputChange);
});
$('.select-ai button').click(function () {
  var form = new FormData();
  $('.filter').html('');
  form.append('type', $(this).text());
  $(this).parent().find('.active-btn').removeClass('active-btn');
  $(this).addClass('active-btn');
  $('#type-ai').val($(this).text());
  $.ajax({
    type: 'POST',
    url: route('client.film.manage-video.filter-ai', [film_id]),
    processData: false,
    contentType: false,
    dataType: 'json',
    data: form,
    success: function success(response) {
      if (!response.error) {
        var template = $('#handlebars-filter-ai').html();
        var templateScript = Handlebars.compile(template);
        var context = {
          'speeches': response.speeches,
          'speeds': response.speeds
        };
        var html = templateScript(context);
        $('.filter').html(html);
      }
    }
  });
});
$('.file').on('change', function (e) {
  $('#input-id').on('fileduplicateerror', function (event, file, fileId, caption, size, id, index) {
    return;
  });
  var files = e.target.files;
  var index = -1;
  $('.dd-list li').each(function () {
    var value = parseInt($(this).data('id'));
    index = value > index ? value : index;
  });
  var template = $('#handlebars-preview-video').html();
  var templateScript = Handlebars.compile(template);

  for (var i = 0; i < files.length; i++) {
    var fileReader = new FileReader();
    index += 1;
    var f = files[i];
    f.sizeInMB = (f.size / (1024 * 1024)).toFixed(2);
    f.index = index;

    fileReader.onload = function (f) {
      return function (e) {
        var fileContent = e.target.result;
        var name = f.name;
        var trimName = name.replace(/ /g, '').replace(/[^a-zA-Z ]/g, '');
        var context = {
          'trimName': trimName,
          'file': f,
          'name': name,
          'fileContent': fileContent
        };
        var html = templateScript(context);
        $('.dd-list').append(html);
      };
    }(f);

    fileReader.readAsDataURL(f);

    fileReader.onloadend = function () {
      $(".dd-list li").sort(sort_asc_li).appendTo('.dd-list');
    };
  }
});
$(document).on('click', '.sorted-button', function () {
  if ($(this).find('i').hasClass('fa-sort-asc')) {
    console.log('asc');
    $(this).find('i').removeClass('fa-sort-asc');
    $(this).find('i').addClass('fa-sort-desc');
    $(".dd-list li").sort(sort_decs_li).appendTo('.dd-list');
    ;
  } else if ($(this).find('i').hasClass('fa-sort-desc')) {
    console.log('desc');
    $(this).find('i').removeClass('fa-sort-desc');
    $(this).find('i').addClass('fa-sort-asc');
    $(".dd-list li").sort(sort_asc_li).appendTo('.dd-list');
    ;
  }
});
/*jslint browser: true, devel: true, white: true, eqeq: true, plusplus: true, sloppy: true, vars: true*/

/*global $ */

/*************** General ***************/

var updateOutput = function updateOutput(e) {
  var list = e.length ? e : $(e.target),
      output = list.data('output');

  if (window.JSON) {
    if (output) {
      output.val(list.nestable('serialize'));
    }
  } else {
    alert('JSON browser support required for this page.');
  }
};

var nestableList = $("#nestable > .dd-list");
$(function () {
  // output initial serialised data
  updateOutput($('#nestable').data('output', $('#json-output')));
});
/*!
 * Nestable jQuery Plugin - Copyright (c) 2012 David Bushell - http://dbushell.com/
 * Dual-licensed under the BSD or MIT licenses
 */

;

(function ($, window, document, undefined) {
  var hasTouch = ('ontouchstart' in document);
  /**
   * Detect CSS pointer-events property
   * events are normally disabled on the dragging element to avoid conflicts
   * https://github.com/ausi/Feature-detection-technique-for-pointer-events/blob/master/modernizr-pointerevents.js
   */

  var hasPointerEvents = function () {
    var el = document.createElement('div'),
        docEl = document.documentElement;

    if (!('pointerEvents' in el.style)) {
      return false;
    }

    el.style.pointerEvents = 'auto';
    el.style.pointerEvents = 'x';
    docEl.appendChild(el);
    var supports = window.getComputedStyle && window.getComputedStyle(el, '').pointerEvents === 'auto';
    docEl.removeChild(el);
    return !!supports;
  }();

  var defaults = {
    listNodeName: 'ol',
    itemNodeName: 'li',
    rootClass: 'dd',
    listClass: 'dd-list',
    itemClass: 'dd-item',
    dragClass: 'dd-dragel',
    handleClass: 'dd-handle',
    collapsedClass: 'dd-collapsed',
    placeClass: 'dd-placeholder',
    noDragClass: 'dd-nodrag',
    emptyClass: 'dd-empty',
    expandBtnHTML: '<button data-action="expand" type="button">Expand</button>',
    collapseBtnHTML: '<button data-action="collapse" type="button">Collapse</button>',
    group: 0,
    maxDepth: 5,
    threshold: 20
  };

  function Plugin(element, options) {
    this.w = $(document);
    this.el = $(element);
    this.options = $.extend({}, defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function init() {
      var list = this;
      list.reset();
      list.el.data('nestable-group', this.options.group);
      list.placeEl = $('<div class="' + list.options.placeClass + '"/>');
      $.each(this.el.find(list.options.itemNodeName), function (k, el) {
        list.setParent($(el));
      });
      list.el.on('click', 'button', function (e) {
        if (list.dragEl) {
          return;
        }

        var target = $(e.currentTarget),
            action = target.data('action'),
            item = target.parent(list.options.itemNodeName);

        if (action === 'collapse') {
          list.collapseItem(item);
        }

        if (action === 'expand') {
          list.expandItem(item);
        }
      });

      var onStartEvent = function onStartEvent(e) {
        var handle = $(e.target);

        if (!handle.hasClass(list.options.handleClass)) {
          if (handle.closest('.' + list.options.noDragClass).length) {
            return;
          }

          handle = handle.closest('.' + list.options.handleClass);
        }

        if (!handle.length || list.dragEl) {
          return;
        }

        list.isTouch = /^touch/.test(e.type);

        if (list.isTouch && e.touches.length !== 1) {
          return;
        }

        e.preventDefault();
        list.dragStart(e.touches ? e.touches[0] : e);
      };

      var onMoveEvent = function onMoveEvent(e) {
        if (list.dragEl) {
          e.preventDefault();
          list.dragMove(e.touches ? e.touches[0] : e);
        }
      };

      var onEndEvent = function onEndEvent(e) {
        if (list.dragEl) {
          e.preventDefault();
          list.dragStop(e.touches ? e.touches[0] : e);
        }
      };

      if (hasTouch) {
        list.el[0].addEventListener('touchstart', onStartEvent, false);
        window.addEventListener('touchmove', onMoveEvent, false);
        window.addEventListener('touchend', onEndEvent, false);
        window.addEventListener('touchcancel', onEndEvent, false);
      }

      list.el.on('mousedown', onStartEvent);
      list.w.on('mousemove', onMoveEvent);
      list.w.on('mouseup', onEndEvent);
    },
    serialize: function serialize() {
      var data,
          depth = 0,
          list = this;

      step = function (_step) {
        function step(_x, _x2) {
          return _step.apply(this, arguments);
        }

        step.toString = function () {
          return _step.toString();
        };

        return step;
      }(function (level, depth) {
        var array = [],
            items = level.children(list.options.itemNodeName);
        items.each(function () {
          var li = $(this),
              item = $.extend({}, li.data()),
              sub = li.children(list.options.listNodeName);

          if (sub.length) {
            item.children = step(sub, depth + 1);
          }

          array.push(item);
        });
        return array;
      });

      data = step(list.el.find(list.options.listNodeName).first(), depth);
      return data;
    },
    serialise: function serialise() {
      return this.serialize();
    },
    reset: function reset() {
      this.mouse = {
        offsetX: 0,
        offsetY: 0,
        startX: 0,
        startY: 0,
        lastX: 0,
        lastY: 0,
        nowX: 0,
        nowY: 0,
        distX: 0,
        distY: 0,
        dirAx: 0,
        dirX: 0,
        dirY: 0,
        lastDirX: 0,
        lastDirY: 0,
        distAxX: 0,
        distAxY: 0
      };
      this.isTouch = false;
      this.moving = false;
      this.dragEl = null;
      this.dragRootEl = null;
      this.dragDepth = 0;
      this.hasNewRoot = false;
      this.pointEl = null;
    },
    expandItem: function expandItem(li) {
      li.removeClass(this.options.collapsedClass);
      li.children('[data-action="expand"]').hide();
      li.children('[data-action="collapse"]').show();
      li.children(this.options.listNodeName).show();
    },
    collapseItem: function collapseItem(li) {
      var lists = li.children(this.options.listNodeName);

      if (lists.length) {
        li.addClass(this.options.collapsedClass);
        li.children('[data-action="collapse"]').hide();
        li.children('[data-action="expand"]').show();
        li.children(this.options.listNodeName).hide();
      }
    },
    expandAll: function expandAll() {
      var list = this;
      list.el.find(list.options.itemNodeName).each(function () {
        list.expandItem($(this));
      });
    },
    collapseAll: function collapseAll() {
      var list = this;
      list.el.find(list.options.itemNodeName).each(function () {
        list.collapseItem($(this));
      });
    },
    setParent: function setParent(li) {
      if (li.children(this.options.listNodeName).length) {
        li.prepend($(this.options.expandBtnHTML));
        li.prepend($(this.options.collapseBtnHTML));
      }

      li.children('[data-action="expand"]').hide();
    },
    unsetParent: function unsetParent(li) {
      li.removeClass(this.options.collapsedClass);
      li.children('[data-action]').remove();
      li.children(this.options.listNodeName).remove();
    },
    dragStart: function dragStart(e) {
      var mouse = this.mouse,
          target = $(e.target),
          dragItem = target.closest(this.options.itemNodeName);
      this.placeEl.css('height', dragItem.height());
      mouse.offsetX = e.offsetX !== undefined ? e.offsetX : e.pageX - target.offset().left;
      mouse.offsetY = e.offsetY !== undefined ? e.offsetY : e.pageY - target.offset().top;
      mouse.startX = mouse.lastX = e.pageX;
      mouse.startY = mouse.lastY = e.pageY;
      this.dragRootEl = this.el;
      this.dragEl = $(document.createElement(this.options.listNodeName)).addClass(this.options.listClass + ' ' + this.options.dragClass);
      this.dragEl.css('width', dragItem.width());
      dragItem.after(this.placeEl);
      dragItem[0].parentNode.removeChild(dragItem[0]);
      dragItem.appendTo(this.dragEl);
      $(document.body).append(this.dragEl);
      this.dragEl.css({
        'left': e.pageX - mouse.offsetX,
        'top': e.pageY - mouse.offsetY
      }); // total depth of dragging item

      var i,
          depth,
          items = this.dragEl.find(this.options.itemNodeName);

      for (i = 0; i < items.length; i++) {
        depth = $(items[i]).parents(this.options.listNodeName).length;

        if (depth > this.dragDepth) {
          this.dragDepth = depth;
        }
      }
    },
    dragStop: function dragStop(e) {
      var el = this.dragEl.children(this.options.itemNodeName).first();
      el[0].parentNode.removeChild(el[0]);
      this.placeEl.replaceWith(el);
      this.dragEl.remove();
      this.el.trigger('change');

      if (this.hasNewRoot) {
        this.dragRootEl.trigger('change');
      }

      this.reset();
    },
    dragMove: function dragMove(e) {
      var list,
          parent,
          prev,
          next,
          depth,
          opt = this.options,
          mouse = this.mouse;
      this.dragEl.css({
        'left': e.pageX - mouse.offsetX,
        'top': e.pageY - mouse.offsetY
      }); // mouse position last events

      mouse.lastX = mouse.nowX;
      mouse.lastY = mouse.nowY; // mouse position this events

      mouse.nowX = e.pageX;
      mouse.nowY = e.pageY; // distance mouse moved between events

      mouse.distX = mouse.nowX - mouse.lastX;
      mouse.distY = mouse.nowY - mouse.lastY; // direction mouse was moving

      mouse.lastDirX = mouse.dirX;
      mouse.lastDirY = mouse.dirY; // direction mouse is now moving (on both axis)

      mouse.dirX = mouse.distX === 0 ? 0 : mouse.distX > 0 ? 1 : -1;
      mouse.dirY = mouse.distY === 0 ? 0 : mouse.distY > 0 ? 1 : -1; // axis mouse is now moving on

      var newAx = Math.abs(mouse.distX) > Math.abs(mouse.distY) ? 1 : 0; // do nothing on first move

      if (!mouse.moving) {
        mouse.dirAx = newAx;
        mouse.moving = true;
        return;
      } // calc distance moved on this axis (and direction)


      if (mouse.dirAx !== newAx) {
        mouse.distAxX = 0;
        mouse.distAxY = 0;
      } else {
        mouse.distAxX += Math.abs(mouse.distX);

        if (mouse.dirX !== 0 && mouse.dirX !== mouse.lastDirX) {
          mouse.distAxX = 0;
        }

        mouse.distAxY += Math.abs(mouse.distY);

        if (mouse.dirY !== 0 && mouse.dirY !== mouse.lastDirY) {
          mouse.distAxY = 0;
        }
      }

      mouse.dirAx = newAx;
      /**
       * move horizontal
       */

      if (mouse.dirAx && mouse.distAxX >= opt.threshold) {
        // reset move distance on x-axis for new phase
        mouse.distAxX = 0;
        prev = this.placeEl.prev(opt.itemNodeName); // increase horizontal level if previous sibling exists and is not collapsed

        if (mouse.distX > 0 && prev.length && !prev.hasClass(opt.collapsedClass)) {
          // cannot increase level when item above is collapsed
          list = prev.find(opt.listNodeName).last(); // check if depth limit has reached

          depth = this.placeEl.parents(opt.listNodeName).length;

          if (depth + this.dragDepth <= opt.maxDepth) {
            // create new sub-level if one doesn't exist
            if (!list.length) {
              list = $('<' + opt.listNodeName + '/>').addClass(opt.listClass);
              list.append(this.placeEl);
              prev.append(list);
              this.setParent(prev);
            } else {
              // else append to next level up
              list = prev.children(opt.listNodeName).last();
              list.append(this.placeEl);
            }
          }
        } // decrease horizontal level


        if (mouse.distX < 0) {
          // we can't decrease a level if an item preceeds the current one
          next = this.placeEl.next(opt.itemNodeName);

          if (!next.length) {
            parent = this.placeEl.parent();
            this.placeEl.closest(opt.itemNodeName).after(this.placeEl);

            if (!parent.children().length) {
              this.unsetParent(parent.parent());
            }
          }
        }
      }

      var isEmpty = false; // find list item under cursor

      if (!hasPointerEvents) {
        this.dragEl[0].style.visibility = 'hidden';
      }

      this.pointEl = $(document.elementFromPoint(e.pageX - document.body.scrollLeft, e.pageY - (window.pageYOffset || document.documentElement.scrollTop)));

      if (!hasPointerEvents) {
        this.dragEl[0].style.visibility = 'visible';
      }

      if (this.pointEl.hasClass(opt.handleClass)) {
        this.pointEl = this.pointEl.parent(opt.itemNodeName);
      }

      if (this.pointEl.hasClass(opt.emptyClass)) {
        isEmpty = true;
      } else if (!this.pointEl.length || !this.pointEl.hasClass(opt.itemClass)) {
        return;
      } // find parent list of item under cursor


      var pointElRoot = this.pointEl.closest('.' + opt.rootClass),
          isNewRoot = this.dragRootEl.data('nestable-id') !== pointElRoot.data('nestable-id');
      /**
       * move vertical
       */

      if (!mouse.dirAx || isNewRoot || isEmpty) {
        // check if groups match if dragging over new root
        if (isNewRoot && opt.group !== pointElRoot.data('nestable-group')) {
          return;
        } // check depth limit


        depth = this.dragDepth - 1 + this.pointEl.parents(opt.listNodeName).length;

        if (depth > opt.maxDepth) {
          return;
        }

        var before = e.pageY < this.pointEl.offset().top + this.pointEl.height() / 2;
        parent = this.placeEl.parent(); // if empty create new list to replace empty placeholder

        if (isEmpty) {
          list = $(document.createElement(opt.listNodeName)).addClass(opt.listClass);
          list.append(this.placeEl);
          this.pointEl.replaceWith(list);
        } else if (before) {
          this.pointEl.before(this.placeEl);
        } else {
          this.pointEl.after(this.placeEl);
        }

        if (!parent.children().length) {
          this.unsetParent(parent.parent());
        }

        if (!this.dragRootEl.find(opt.itemNodeName).length) {
          this.dragRootEl.append('<div class="' + opt.emptyClass + '"/>');
        } // parent root list has changed


        if (isNewRoot) {
          this.dragRootEl = pointElRoot;
          this.hasNewRoot = this.el[0] !== this.dragRootEl[0];
        }
      }
    }
  };

  $.fn.nestable = function (params) {
    var lists = this,
        retval = this;
    lists.each(function () {
      var plugin = $(this).data("nestable");

      if (!plugin) {
        $(this).data("nestable", new Plugin(this, params));
        $(this).data("nestable-id", new Date().getTime());
      } else {
        if (typeof params === 'string' && typeof plugin[params] === 'function') {
          retval = plugin[params]();
        }
      }
    });
    return retval || lists;
  };
})(window.jQuery || window.Zepto, window, document); // audio


$(document).on('click', '#btn-play-pause-1', function () {
  //Play/pause the track
  if (window.combine_audio.paused == false) {
    window.combine_audio.pause();
    $(this).children('i').removeClass('fa-pause');
    $(this).children('i').addClass('fa-play');
  } else {
    window.combine_audio.play();
    $(this).children('i').removeClass('fa-play');
    $(this).children('i').addClass('fa-pause');
  }
});
$(document).on('click', '#btn-stop-1', function () {
  //Stop the track
  window.combine_audio.pause();
  window.combine_audio.currentTime = 0;
  $('#btn-play-pause').children('i').removeClass('fa-pause');
  $('#btn-play-pause').children('i').addClass('fa-play');
});
$(document).on('click', '#btn-mute-1', function () {
  //Mutes/unmutes the sound
  if (window.combine_audio.volume != 0) {
    window.combine_audio.volume = 0;
    $(this).children('i').removeClass('fa-volume-off');
    $(this).children('i').addClass('fa-volume-up');
  } else {
    window.combine_audio.volume = 1;
    $(this).children('i').removeClass('fa-volume-up');
    $(this).children('i').addClass('fa-volume-off');
  }
});

function updateProgress() {
  //Updates the progress bar
  if (window.combine_audio) {
    var progress = document.getElementById("progress-1");
    var value = 0;
    var currentTime = document.getElementById('currentTime-1');

    if (window.combine_audio.currentTime > 0) {
      var minutes = parseInt(window.combine_audio.currentTime / 60);
      var seconds = parseInt(window.combine_audio.currentTime % 60);

      if (minutes < 10) {
        minutes = "0" + minutes;
      }

      if (seconds < 10) {
        seconds = "0" + seconds;
      }

      currentTime.innerHTML = minutes + ':' + seconds;
      value = Math.floor(100 / window.combine_audio.duration * window.combine_audio.currentTime);
    }

    progress.style.width = value + "%";
  }

  if (window.bg_audio) {
    var progress = document.getElementById("progress-2");
    var value = 0;
    var currentTime = document.getElementById('currentTime-2');

    if (window.bg_audio.currentTime > 0) {
      var minutes = parseInt(window.bg_audio.currentTime / 60);
      var seconds = parseInt(window.bg_audio.currentTime % 60);

      if (minutes < 10) {
        minutes = "0" + minutes;
      }

      if (seconds < 10) {
        seconds = "0" + seconds;
      }

      currentTime.innerHTML = minutes + ':' + seconds;
      value = Math.floor(100 / window.bg_audio.duration * window.bg_audio.currentTime);
    }

    progress.style.width = value + "%";
  }
}

$(document).on('click', '#btn-play-pause-2', function () {
  //Play/pause the track
  if (window.bg_audio.paused == false) {
    window.bg_audio.pause();
    $(this).children('i').removeClass('fa-pause');
    $(this).children('i').addClass('fa-play');
  } else {
    window.bg_audio.play();
    $(this).children('i').removeClass('fa-play');
    $(this).children('i').addClass('fa-pause');
  }
});
$(document).on('click', '#btn-stop-2', function () {
  //Stop the track
  window.bg_audio.pause();
  window.bg_audio.currentTime = 0;
  $('#btn-play-pause').children('i').removeClass('fa-pause');
  $('#btn-play-pause').children('i').addClass('fa-play');
});
$(document).on('click', '#btn-mute-2', function () {
  //Mutes/unmutes the sound
  if (window.bg_audio.volume != 0) {
    window.bg_audio.volume = 0;
    $(this).children('i').removeClass('fa-volume-off');
    $(this).children('i').addClass('fa-volume-up');
  } else {
    window.bg_audio.volume = 1;
    $(this).children('i').removeClass('fa-volume-up');
    $(this).children('i').addClass('fa-volume-off');
  }
});

if (window.combine_audio) {
  window.combine_audio.addEventListener("timeupdate", updateProgress, false);
}

if (window.bg_audio) {
  window.bg_audio.addEventListener("timeupdate", updateProgress, false);
}

/***/ }),

/***/ 12:
/*!**********************************************************!*\
  !*** multi ./resources/assets/client/js/create-video.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /opt/lampp/htdocs/reviewfilm/resources/assets/client/js/create-video.js */"./resources/assets/client/js/create-video.js");


/***/ })

/******/ });