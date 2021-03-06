"use strict";
var App = {
  mainElm: "#content_area",
  calendar: {},
  hariLibur: null,
  currentUrl: null,
  isBackUrl: false,
  prevUrl: [],

  setHariLibur: function () {
    $.ajax({
      url: "master/jadwal/getHariLibur",
      data: {},
      type: "post",
      dataType: "json",
      success: function (data) {
        if (data.status) {
          if (!empty(data.content)) {
            App.hariLibur = data.content;
          }
        } else {
          App.hariLibur = [];
          App.alertDialog("Informasi", "Jadwal hari libur tidak ditemukan");
        }
      },
      async: false,
      cache: false,
    });
  },

  isHariLibur: function (hariH, hariLibur) {
    /* jika hari minggu atau ada dalam hari libur return true*/
    var _t = this.getDateStr(hariH);
    var _h = new Date(_t);
    var _r = hariH.getDay() == 0 || this.inArray(_t, hariLibur);
    //console.log(_r);
    return _r;
  },

  getDateStr: function (dt, separator) {
    if (separator == undefined) {
      separator = "-";
    }
    var _month = dt.getMonth() + 1;
    if (_month < 10) {
      _month = "0" + _month;
    }
    var _arr = [dt.getFullYear(), _month, dt.getDate()];
    return _arr.join(separator);
  },
  inArray: function (item, arr) {
    if (!arr) {
      return false;
    } else {
      for (var p = 0; p < arr.length; p++) {
        if (item == arr[p]) {
          return true;
        }
      }
      return false;
    }
  },

  confirmComplexDialog: function (_title, _message, callback) {
    var modal = bootbox.dialog({
      message: $(_message).html(),
      title: _title,
      buttons: {
        confirm: {
          label: "Ya",
          className: "btn-primary",
          callback: function (result) {
            callback(result);
          },
        },
        cancel: {
          label: "Tidak",
          className: "btn-danger",
        },
      },
      show: false,
      onEscape: function () {
        modal.modal("hide");
      },
    });
    modal.modal("show");
  }, // end -  confirmRejectDialog

  saveDialog: function (_title, _message, callback) {
    var modal = bootbox.dialog({
      message: _message,
      title: _title,
      buttons: {
        confirm: {
          label: "Simpan",
          className: "btn-primary",
          callback: function (result) {
            callback(result);
          },
        },
      },
      show: false,
      onEscape: function () {
        modal.modal("hide");
      },
    });
    modal.modal("show");
  }, // end -  confirmRejectDialog

  confirmRejectDialog: function (elm, message, callback) {
    bootbox.prompt({
      title: message,
      inputType: "textarea",
      required: true,
      buttons: {
        confirm: {
          label: "Ya",
          className: "btn-primary",
        },
        cancel: {
          label: "Tidak",
          className: "btn-danger",
        },
      },
      callback: function (result) {
        var st = true;
        if (result != null) {
          if (empty(result)) {
            bootbox.alert("Mohon isi kolom keterangan alasan penolakan.");
            st = false;
          } else {
            callback(elm, result);
          }
        }
        return st;
      },
    });
  }, // end -  confirmRejectDialog

  confirmDialog: function (message, callback) {
    bootbox.confirm({
      title: "Konfirmasi",
      message: message,
      buttons: {
        confirm: {
          label: "Ya",
          className: "btn-primary",
        },
        cancel: {
          label: "Tidak",
          className: "btn-danger",
        },
      },
      callback: function (result) {
        callback(result);
      },
    });
  }, // end - confirmDialog

  alertDialog: function (title, message, callback) {
    bootbox.alert({
      title: title,
      message: message,
      buttons: {
        ok: {
          label: "OK",
          className: "btn-primary",
        },
      },
      callback: function (result) {
        if (callback !== undefined) {
          callback(result);
        }
      },
    });
  },

  showLoadingContentView: function (_is) {
    if (_is) {
      $("#main_content").hide();
      $("#loadingContentView").show();
    } else {
      $("#main_content").show();
      $("#loadingContentView").hide();
    }
  }, // end - showLoadingContentView

  loadContentView: function (_url, _data, _type, refreshFn = function () {}) {
    var _ini = this;
    if (empty(_data)) {
      _ini.prevUrl = [];
    } else {
      if (!_ini.isBackUrl) _ini.prevUrl.push(_ini.currentUrl);
    }
    _ini.currentUrl = {
      url: _url,
      data: _data,
    };
    $.ajax({
      url: _url,
      type: _type,
      data: _data,
      beforeSend: function () {
        _ini.showLoadingContentView(true);
      },
      success: function (data) {
        $("#main_content").html(data);
      },
      error: function (xhr, status, error) {
        var pesan = xhr.responseText;
        bootbox.alert("Terjadi error di server \n" + pesan, function () {
          _ini.showLoadingContentView(false);
        });
      },
    }).done(function () {
      _ini.isBackUrl = false;
      refreshFn();
      _ini.showLoadingContentView(false);
      _ini.initFormatInput();
      _ini.initPagination();
      if ($("#calendar").length) {
        _ini.initCalendar($("#calendar"));
      }
      if (".select2_ajax".length) {
        _ini.initSelect2Ajax();
      }
      if ($(".modal-backdrop").length) {
        if ($(".modal-backdrop").is(":visible")) $(".modal-backdrop").fadeOut();
      }
      if ($("input[type = file]").length) {
        _ini.initInputFile();
      }
      window.scrollTo(0, 0);
    });
  }, // end - loadContentView

  getContentView: function (_url, _data, refreshFn = function () {}) {
    this.loadContentView(_url, _data, "GET", refreshFn);
  },

  postContentView: function (_url, _data, refreshFn = function () {}) {
    this.loadContentView(_url, _data, "POST", refreshFn);
  },

  loadMainContent: function (_url, _data, _type, _callback) {
    var _mainElm = $(this.mainElm);
    $.ajax({
      url: _url,
      data: _data,
      dataType: "html",
      type: _type,
      beforeSend: function () {
        _mainElm.html("Loading ......");
      },
      success: function (data) {
        _mainElm.html(data);
      },
    }).done(function () {
      if (_callback !== undefined) {
        _callback();
      }
    });
  },

  getMainContentView: function (_url, _data, refreshFn = function () {}) {
    this.loadMainContent(_url, _data, "GET", refreshFn);
  },

  postMainContentView: function (_url, _data, refreshFn = function () {}) {
    this.loadMainContent(_url, _data, "POST", refreshFn);
  },

  refresh: function () {
    window.location.reload();
  },

  collapseRow: function () {
    // NOTE: setup untuk expand collapse row table
    $("tr.header td span.btn-collapse").click(function () {
      var row = $(this).closest("tr.header");
      $(row).toggleClass("expand-row").nextUntil("tr.header").slideToggle(100);
      var _el = $(row).closest("tr").find("span.btn-collapse");
      if (_el.hasClass("glyphicon-chevron-right")) {
        _el.removeClass("glyphicon-chevron-right");
        _el.addClass("glyphicon-chevron-down");
      } else {
        _el.removeClass("glyphicon-chevron-down");
        _el.addClass("glyphicon-chevron-right");
      }
    });
  }, // end - collapseRow

  checkRequired: function (targets, callback) {
    var data = {
      count: 0,
      names: [],
      elements: [],
    };

    $(targets).parent().removeClass("has-error");
    $.map($(targets), function (elm) {
      var value = $(elm).val();
      var error = false;
      var eName = $(elm).attr("name");
      if ($(elm).attr("type") == "radio") {
        if (empty($("input[name=" + eName + "]:checked").val())) {
          error = true;
        }
      } else if (
        $(elm).attr("data-tipe") == "integer" ||
        $(elm).attr("data-tipe") == "decimal"
      ) {
        var zero = $(elm).attr("zero") || "deny";
        if (zero != "allow") {
          var numb = numeral.unformat(value);
          if (numb <= 0) {
            error = true;
          }
        }
      } else {
        error = empty(value);
      }

      if (error) {
        data.count += 1;
        data.names.push(eName);
        data.elements.push($(elm));

        $(elm).parent().addClass("has-error");
      }
    });
    callback(data);
  }, // end - checkRequired

  /* execute Function By Name */
  execFunction: function (functionName, context /*, args */ ) {
    console.log(functionName);
    var args, namespaces, func;

    if (typeof functionName === "undefined") {
      throw "function name not specified";
    }

    if (typeof eval(functionName) !== "function") {
      throw functionName + " is not a function";
    }

    if (typeof context !== "undefined") {
      if (typeof context === "object" && context instanceof Array === false) {
        if (typeof context[functionName] !== "function") {
          throw context + "." + functionName + " is not a function";
        }
        args = Array.prototype.slice.call(arguments, 2);
      } else {
        args = Array.prototype.slice.call(arguments, 1);
        context = window;
      }
    } else {
      context = window;
    }

    namespaces = functionName.split(".");
    func = namespaces.pop();

    for (var i = 0; i < namespaces.length; i++) {
      context = context[namespaces[i]];
    }

    return context[func].apply(context, args);
  }, // end - executeFunctionByName
  initTooltipster: function (content) {
    $(".tooltipster").hover(function (e) {
      // alert('tes');
      console.log(e.target);
      App.showTooltip(e.target, content);
    });
  },
  showTooltip: function (element, content) {
    $(element).tooltipster({
      content: content,
      contentAsHTML: true,
      multiple: true,
      side: "bottom",
      theme: "tooltipster-punk",
      animation: "fade",
      delay: 100,
    });
  },
  _tglServer: null,
  _setTglServer: function (tgl) {
    this._tglServer = new Date(tgl);
  },
  _regional: {
    monthNames: [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "November",
      "Desember",
    ],
    monthNamesShort: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "Mei",
      "Jun",
      "Jul",
      "Ags",
      "Sep",
      "Okt",
      "Nov",
      "Des",
    ],
    dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
    dayNamesShort: ["Min", "Sen", "Sel", "Rab", "kam", "Jum", "Sab"],
    dayNamesMin: ["Mg", "Sn", "Sl", "Rb", "Km", "jm", "Sb"],
  },

  _setCurrentFarm: function (idFarm) {
    this._currentFarm = idFarm;
  },
  /* dt adalah object date */
  _getDateStr: function (dt, separator) {
    if (separator == undefined) {
      separator = "-";
    }
    var _arr = [dt.getFullYear(), dt.getMonth() + 1, dt.getDate()];
    return _arr.join(separator);
  },
  /* convert 2015-5-1 menjadi 2015-05-01 supaya valid tanggalnya di javascript */
  _convertTgl: function (tgl) {
    var _t = tgl.split("-");
    var _new = [];
    for (var x in _t) {
      if (_t[x].length < 2) {
        _new.push("0" + _t[x]);
      } else {
        _new.push(_t[x]);
      }
    }
    return _new.join("-");
  },
  /* convert dari Mei menjadi 05 */
  _indexBulan: function (bulan) {
    var _reg = $.datepicker.regional["id"] || this._regional;
    var _bulan = _reg.monthNamesShort;
    return _bulan.indexOf(bulan) + 1;
  },
  _namaBulan: function (indexBulan) {
    var _reg = $.datepicker.regional["id"] || this._regional;
    return _reg.monthNamesShort[indexBulan - 1];
  },
  /* tgldb = 2015-05-26 dirubah jadi 26-Mei-2015 */
  _tanggalLocal: function (tgldb, separator_asal, separator_tujuan) {
    if (separator_asal == undefined) {
      separator_asal = "-";
    }
    if (separator_tujuan == undefined) {
      separator_tujuan = "-";
    }
    var _t = tgldb.split(separator_asal);
    if (_t[2].length < 2) {
      _t[2] = "0" + _t[2];
    }
    var _new = [_t[2], this._namaBulan(_t[1]), _t[0]];
    return _new.join(separator_tujuan);
  },
  /* 26-Mei-2015 dirubah menjadi tgldb 2015-05-26 */
  _tanggalDb: function (tgllocal, separator_asal, separator_tujuan) {
    if (separator_asal == undefined) {
      separator_asal = "-";
    }
    if (separator_tujuan == undefined) {
      separator_tujuan = "-";
    }
    var _t = tgllocal.split(separator_asal);
    var _indexBulan = this._indexBulan(_t[1]);
    if (_indexBulan < 10) {
      _indexBulan = "0" + _indexBulan.toString();
    }

    var _new = [_t[2], _indexBulan, _t[0]];
    return _new.join(separator_tujuan);
  },

  load_main_content: function (event, elm, url, target) {
    var _url = url.split("#")[1] || null;
    if (!empty(_url)) {
      //$(target).empty().load(_url);
      $.ajax({
        type: "POST",
        data: {
          menu_id: $(elm).data("mn_id"),
        },
        url: _url,
        async: false,
        success: function (data) {
          $(target).html(data);
        },
      });
    }

    event.preventDefault();
  },

  changePassword: function () {
    var oldPassword = $("#divChangePassword input[name=oldPassword]").val();
    var newPassword = $("#divChangePassword input[name=newPassword]").val();
    var confirmPassword = $(
      "#divChangePassword input[name=confirmPassword]"
    ).val();
    var sama = 1;
    if (newPassword != confirmPassword) {
      sama = 0;
    }
    if (sama) {
      $.ajax({
        url: "user/changePassword",
        data: {
          oldPassword: oldPassword,
          newPassword: newPassword,
        },
        type: "POST",
        dataType: "json",
        beforeSend: function () {},
        success: function (data) {
          if (data.status) {
            toastr.success(data.message);
            bootbox.hideAll();
          } else {
            toastr.error(data.message);
          }
        },
        error: function () {},
      });
    } else {
      toastr.error("Password belum sama");
    }
    return false;
  },
  addRecord: function (elm) {
    var _url = $(elm).data("url");
    var _key = $(elm).data("key");
    this.postContentView(_url, {
      key: _key,
    });
  },
  editRecord: function (elm) {
    var _key = $(elm).closest("tr").data("key");
    var _url = $(elm).data("url");
    this.postContentView(_url, {
      key: _key,
    });
  },

  detailRecord: function (elm) {
    var _key = $(elm).closest("tr").data("key");
    if (_key == undefined) {
      _key = $(elm).data("key");
    }
    var _url = $(elm).data("url");
    var _nexturl = $(elm).data("nexturl");
    this.postContentView(_url, {
      key: _key,
      nexturl: _nexturl,
    });
  },

  gotoUrl: function (elm) {
    var _key = $(elm).data("key");
    var _url = $(elm).data("url");
    if (_key != undefined) {
      _url += "/" + _key;
    }
    var _nexturl = $(elm).data("nexturl");
    this.postContentView(_url, {
      key: _key,
      nexturl: _nexturl,
    });
  },

  backUrl: function () {
    if (this.prevUrl.length > 0) {
      var _tmp = this.prevUrl.pop();
      var _url = _tmp.url;
      var _data = _tmp.data;
      this.isBackUrl = true;
      this.postContentView(_url, _data);
    }
  },

  redirectUrl: function (elm) {
    var _url = $(elm).data("url");
    var _key = $(elm).closest("tr").data("key");
    if (_key == undefined) {
      _key = $(elm).data("key");
    }
    var _target = "_blank";
    if ($(elm).data("target") !== undefined) {
      _target = $(elm).data("target");
    }
    $.redirect(
      _url, {
        key: _key,
      },
      "post",
      _target
    );
  },

  deleteRecord: function (elm) {
    var _key = $(elm).closest("tr").data("key");
    var _url = $(elm).data("url");
    var _nexturl = $(elm).data("nexturl");
    var _urlMessage = $(elm).data("urlmessage");
    var _ini = this;

    $.post(
      _urlMessage, {
        key: _key,
      },
      function (_message) {
        _ini.confirmDialog(_message, function (result) {
          if (result) {
            $.post(
              _url, {
                key: _key,
              },
              function (data) {
                _ini.alertDialog("Informasi", data.message, function () {
                  _ini.postContentView(_nexturl);
                });
              },
              "json"
            );
          }
        });
      },
      "html"
    );
  },

  updateRecord: function (elm, callback) {
    var _key = $(elm).closest("tr").data("key");
    var _url = $(elm).data("url");
    var _urlMessage = $(elm).data("urlmessage");
    var _ini = this;

    $.post(
      _urlMessage, {
        key: _key,
      },
      function (_message) {
        _ini.confirmDialog(_message, function (result) {
          if (result) {
            $.post(
              _url, {
                key: _key,
              },
              function (data) {
                _ini.alertDialog("Informasi", data.message, function () {
                  if (data.status) {
                    if (callback != undefined) {
                      if (callback instanceof Function) {
                        callback(elm);
                      }
                    }
                  }
                });
              },
              "json"
            );
          }
        });
      },
      "html"
    );
  },

  saveRecord: function (elm) {
    var _url = $(elm).attr("action");
    var _nexturl = $(elm).data("nexturl");
    var _ini = this;
    var _message = "Apakah anda yakin akan menyimpan data ini ?";
    _ini.confirmDialog(_message, function (result) {
      if (result) {
        var _key = {};
        $(elm)
          .find("input:hidden")
          .not(".references")
          .each(function () {
            _key[$(this).attr("name")] = $(this).val();
          });
        var _data = _ini.getFormData(elm);
        var _formData = new FormData();
        /*var _sendData = {
          data: _data,
          key: _key,
        };*/
        _formData.append("data", JSON.stringify(_data));
        _formData.append("key", JSON.stringify(_key));
        if ($("input[type=file]").length) {
          //_sendData["attachment"] = [];
          var _attachment;
          $("input[type=file]").each(function () {
            _attachment = $(this).get(0).files[0];
            /*if (attachment !== undefined) {
              var _base64 = $(this)
                .closest(".btn-file")
                .next(".file_template")
                .find("img")
                .attr("src");
              _sendData["attachment"].push(_base64);
            }*/
          });
          _formData.append("attachment", _attachment);
        }

        $.ajax({
          url: _url,
          beforeSend: function () {
            _ini.showLoadingContentView(true);
          },
          data: _formData,
          cache: false,
          contentType: false,
          processData: false,
          type: "POST",
          success: function (data) {
            _ini.alertDialog("Informasi", data.message, function () {
              if (data.status) {
                _ini.postContentView(_nexturl);
              } else {
                _ini.showLoadingContentView(false);
              }
            });
          },
          dataType: "json",
        });
      }
    });
    return false;
  },

  getFormData: function (elm) {
    var _numeric = [],
      _dates = [];

    $(elm)
      .find("[data-tipe=integer],[data-tipe=angka],[data-tipe=decimal]")
      .each(function () {
        _numeric.push($(this).attr("name"));
      });

    $(elm)
      .find("input.hasDatepicker")
      .each(function () {
        if ($(this).attr("name") != undefined) {
          if (!empty($(this).val())) {
            _dates.push($(this).attr("name"));
          }
        }
      });

    //$(elm).find('input:hidden').remove();

    var _tmp = $(elm).serializeArray();
    var _data = {},
      _nilai,
      _tmpVal;
    for (var i in _tmp) {
      //number_only
      _nilai = _tmp[i]["value"];
      if (in_array(_tmp[i]["name"], _numeric)) {
        _nilai = numeral.unformat(_nilai);
      }

      if (in_array(_tmp[i]["name"], _dates)) {
        _nilai = getValueDateSQL(
          $(elm).find("[name=" + _tmp[i]["name"] + "]")
        );
      }

      if (_data[_tmp[i]["name"]] == undefined) {
        _data[_tmp[i]["name"]] = _nilai;
      } else {
        if (Array.isArray(_data[_tmp[i]["name"]])) {
          _data[_tmp[i]["name"]].push(_nilai);
        } else {
          _tmpVal = _data[_tmp[i]["name"]];
          _data[_tmp[i]["name"]] = [_tmpVal];
          _data[_tmp[i]["name"]].push(_nilai);
        }
      }
    }
    return _data;
  },

  searchRecord: function (elm) {
    var _url = $(elm).attr("action");
    var _ini = this;

    _ini.postContentView(_url, {
      data: _ini.getFormData(elm),
    });
    return false;
  },

  getRequest: function (elm) {
    var _url = $(elm).data("url");
    var _key = $(elm).data("key");
    var _nexturl = $(elm).data("nexturl");
    if (_key == undefined) {
      _key = {};
    }
    var _ini = this;
    $.ajax({
      url: _url,
      beforeSend: function () {
        _ini.showLoadingContentView(true);
      },
      data: _key,
      type: "GET",
      success: function (data) {
        _ini.alertDialog("Informasi", data.message, function () {
          if (_nexturl != undefined) {
            _ini.postContentView(_nexturl);
          }
        });
      },
      dataType: "json",
    }).done(function () {
      _ini.showLoadingContentView(false);
    });
  },

  postRequest: function (_url, _data, _nexturl) {
    $.ajax({
      url: _url,
      type: "POST",
      beforeSend: function () {
        App.showLoadingContentView(true);
      },
      data: {
        data: _data,
      },
      success: function (data) {
        App.alertDialog("Informasi", data.message, function () {
          if (_nexturl != undefined) {
            App.postContentView(_nexturl);
          }
        });
      },
      dataType: "json",
    }).done(function (data) {
      App.showLoadingContentView(false);
    });
  },

  checkAll: function (elm) {
    var _table = $(elm).closest("table");
    var _tbody = _table.find("tbody");
    var _checked = $(elm).is(":checked") ? 1 : 0;
    //if (_checked) {
    _tbody.find(":checkbox").prop("checked", _checked);
    //}
  },

  setDependency: function (elm) {
    var _dependency = $(elm).data("dependency");
    var _tbody = $(elm).closest("tbody");
    var _checked = $(elm).is(":checked") ? 1 : 0;
    if (_checked) {
      for (var i in _dependency) {
        _tbody
          .find(":checkbox[data-" + i + "=" + _dependency[i] + "]")
          .prop("checked", 1);
      }
    }
  },

  initInputFile: function () {
    $("input[type=file]").change(function () {
      var $fileUpload = $(this);
      if (parseInt($fileUpload.get(0).files.length) > 1) {
        alert("Jumlah photo yang bisa diupload hanya 1 foto");
        return false;
      }
      var _template = $(this).closest(".form-group").find(".file_template");
      var _validImageTypes = ["image/gif", "image/jpeg", "image/png"];
      var _typeFile, _fileName;
      if (_template.length == 0) {
        $('<ul class="file_template row col-md-12"></ul>').insertAfter(
          $(this).closest(".btn-file")
        );
        $('<div class="btn filename"></div>').insertAfter(
          $(this).closest(".btn-file")
        );
        _template = $(this).closest(".form-group").find(".file_template");
      }
      _template.empty();
      for (var i = 0, len = this.files.length; i < len; i++) {
        (function (j, self) {
          _typeFile = self.files[j]["type"];
          _fileName = self.files[j]["name"];
          _template.siblings(".filename").html(_fileName);
          if (_validImageTypes.includes(_typeFile)) {
            var reader = new FileReader();
            reader.onload = function (e) {
              _template.append(
                '\
                                        <li>\
                                            <div class="site-photo site-photo-64 site-photo-left">\
                                                <img class="thumbnail image-post" src="' +
                e.target.result +
                '">\
                                            </div>\
                                        </li>'
              );
            };
            reader.readAsDataURL(self.files[j]);
          }
        })(i, this);
      }
    });

    $("input[type=file]").each(function () {
      if (!empty($(this).attr("value"))) {
        $('<ul class="file_template row col-md-12"></ul>').insertAfter(
          $(this).closest(".btn-file")
        );
        $(
          '<div class="btn filename">' + $(this).attr("value") + "</div>"
        ).insertAfter($(this).closest(".btn-file"));
        var _template = $(this).closest(".form-group").find(".file_template");
        _template.append(
          '\
                                        <li>\
                                            <div class="site-photo site-photo-64 site-photo-left">\
                                                <img class="thumbnail image-post" src="' +
          $(this).attr("value") +
          '">\
                                            </div>\
                                        </li>'
        );
      }
    });
  },
  initFormatInput: function () {
    $("form").validate({
      submitHandler: function () {
        var _form = this.currentForm;
        var _action = _form.getAttribute("data-actiontype");
        switch (_action) {
          case "search":
            App.searchRecord(_form);
            break;
          case "save":
            App.saveRecord(_form);
            break;
          default:
            bootbox.alert("Aksi belum didefinisikan ");
        }
      },
    });
    $(
      "[data-tipe=date],input[name=startDate],input[name=endDate],input[name=start_date],input[name=end_date]"
    ).each(function () {
      var _datepickerParam = {
        dateFormat: "dd M yy",
        locale: "id",
        onSelect: function (date) {
          var _n = $(this).attr("name");
          if (App.inArray(_n, ["startDate", "start_date"])) {
            $("input[name=endDate]").datepicker("option", "minDate", date);
            $("input[name=end_date]").datepicker("option", "minDate", date);
          } else {
            $("input[name=startDate]").datepicker("option", "maxDate", date);
            $("input[name=start_date]").datepicker("option", "maxDate", date);
          }
        },
      };
      if ($(this).data("mindate") != undefined) {
        _datepickerParam["minDate"] = $(this).data("mindate");
      }
      $(this).datepicker(_datepickerParam);
    });

    /* format numeral */
    $("[data-tipe=integer],[data-tipe=angka],[data-tipe=decimal]").each(
      function () {
        $(this).priceFormat(Config[$(this).data("tipe")]);
      }
    );

    /* format alpha-numeric */
    $("[data-tipe=alpha-numeric]").keyup(function () {
      if (this.value.match(/[^a-zA-Z0-9]/g)) {
        this.value = this.value.replace(/[^a-zA-Z0-9]/g, "");
      }
    });

    /** untuk select2 */
    $(".select2_single").select2({
      placeholder: "&#xf002 silakan dipilih",
      escapeMarkup: function (m) {
        return m;
      },
      allowClear: true,
    });
    $(".select2_group").select2({});
    $(".select2_multiple").select2({
      // maximumSelectionLength: 4,
      placeholder: "silakan dipilih",
      allowClear: true,
    });

    $(".form-control.hide").closest(".form-group").hide();
  },

  initSelect2Ajax: function () {
    $(".select2_ajax").each(function () {
      var url = $(this).data("url");
      $(this).select2({
        ajax: {
          url: url,
          type: "post",
          dataType: "json",
          delay: 500,
          data: function (params) {
            return {
              q: $.trim(params.term), // search term
              page: params.page,
            };
          },
          processResults: function (data) {
            data.page = data.page || 1;
            return {
              results: data.items,
              pagination: {
                more: data.pagination,
              },
            };
          },
          cache: true,
          delay: 500,
        },
        placeholder: "Ketikkan minimal 3 huruf",
        minimumInputLength: 3,
        width: "100%",
      });
    });
  },

  initPagination: function () {
    var _ini = this;
    $("#divPagination ul.pagination a").click(function (e) {
      var _href = $(this).attr("href");
      //_href.pop();
      var _url = _href;
      //var _page = $(this).data('ci-pagination-page');
      var _data = {};
      _ini.postContentView(_url, {
        data: _data,
      });
      e.preventDefault();
      return false;
    });
  },

  initCalendar: function (elm) {
    this.calendar = $(elm).fullCalendar({
      height: 650,
      showNonCurrentDates: false,
      eventSources: [{
        url: "report/kehadiran/event",
        type: "POST",
        data: {
          /*custom_param1: 'something',
                  custom_param2: 'somethingelse'*/
        },
        error: function () {
          alert("there was an error while fetching events!");
        },
        color: "none", // a non-ajax option
        textColor: "black", // a non-ajax option
      }, ],
      header: {
        right: "prev,next today",
        center: "title",
        left: "none",
      },
      locale: "id",
      html: true,
      /*
            dayRender: function(date, cell) {
                
                var check = $.fullCalendar.formatDate(date, 'Y-MM-DD');
                for (var i = 0; i <= event.length - 1; i++) {
                    var thisevent = event[i].start;
                    if (check == thisevent) {
                        cell.css("background-color", event[i].color);
                    }
                }
        },*/
      eventRender: function (event, element) {
        if (!empty(event.className)) {
          //$day = $date.getDate();
          var title = element.find(".fc-title");
          title.html(title.text());
          $(
            "td.fc-day[data-date='" + event.start.format("YYYY-MM-DD") + "']"
          ).addClass(event.className.join(" "));
        }
      },
    });
  },
  filterPage: function (elm) {
    $("#searchModal").modal("show");
  },

  setElementValue: function (elm, url, targetElm) {
    var _val = $(elm).val();
    console.log(targetElm);
    if (!isNaN(_val)) {
      _val = parseInt(_val);
      if (_val <= 0) {
        _val = null;
      }
    }

    if (!empty(_val)) {
      $.post(
        url, {
          data: _val,
          single: 1
        },
        function (data) {
          if (data.status) {
            for (var field in targetElm) {
              if ($(targetElm[field]).prop("tagName") != "IMG") {
                $(targetElm[field]).val(data.content[field]);
              } else {
                $(targetElm[field]).attr("src", data.content[field]);
              }
            }
          } else {
            bootbox.alert(data.message);
          }
        },
        "json"
      );
    } else {
      $(targetElm).val("");
    }
  },
};