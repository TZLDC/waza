function datepickerInit(type) {
    var now = new Date();
    var year = now.getFullYear();
    var startYeah = year - 5;
    var endYear = year + 5;
    $.datepicker.setDefaults({
        showOn: 'both',
        buttonImage: '/image/calendar.gif',
        buttonImageOnly: true,
        showOtherMonths: true,
        dateFormat: type == 2 ? 'yy-mm' : 'yy-mm-dd',
        speed: 'fast',
        yearRange: startYeah + ':' + endYear
    });
}

function loadingStart() {
    $('#loading').show();
}

function loadingStop() {
    $('#loading').hide();
}

function ajaxLoading() {
    $.ajaxPrefilter(function (options) {
        options.global = true;
    });
    $(document).ajaxStart(function () {
        loadingStart();
    }).ajaxStop(function () {
        loadingStop();
    });
}

function formConfirm(type) {
    if (type == 'save') {
        return confirm('保存してもよろしいですか？');
    }

    return false;
}

function delConfirm(id, type) {
    if (!confirm(msg)) {
        return;
    }

    $.getJSON(uri, data, function (json) {
        if (json.msg) {
            alert(json.msg);
        }

        if (json.status) {
            window.location.reload();
        }
    });
}

function pagingChange() {
    document.search_form.submit();
}

function searchReset() {
    var form = $('form[name=search_form]');
    var uri = '?';

    form.find('input[type=hidden]').each(function () {
        uri += $(this).attr('name') + '=' + $(this).val() + '&';
    });

    window.location.href = uri;
}

function upload(uri, data, func) {
    $.upload({
        url: uri,
        fileName: 'file',
        params: data,
        dataType: 'json',
        onSend: function () {
            return true;
        },
        onComplate: function (json) {
            func(json);
            loadingStop();
        }
    });
}

function uploadSortable(slc) {
    if (slc.find('.delete').length > 0) {
        slc.find('.upload_list').sortable('destroy');
        slc.find('.upload_list').sortable().bind('sortupdate', function () {});
    }
}

function uploadDeletable(slc, msg, uri, data) {
    slc.find('.upload_add span').html(slc.find('.delete').length);
    slc.find('.delete').each(function () {
        $(this).unbind('click');
        $(this).click(function () {
            if (confirm(msg)) {
                var item = $(this).parent(0);

                if (uri && data) {
                    loadingStart();
                    data.fid = item.attr('fid');

                    $.getJSON(uri, data, function (json) {
                        loadingStop();

                        if (json.status) {
                            item.remove();

                            if (slc.hasClass('upload_single')) {
                                slc.find('.upload_add').show();
                            } else {
                                slc.find('.upload_add span').html(slc.find('.delete').length);
                            }
                        } else {
                            alert(json.msg);
                        }
                    });
                } else {
                    item.remove();

                    if (slc.hasClass('upload_single')) {
                        slc.find('.upload_add').show();
                    } else {
                        slc.find('.upload_add span').html(slc.find('.delete').length);
                    }
                }
            }
        });
    });
}

function order(uri) {
    window.location.href = uri;
}

/*
 * rayu 
 */
var config = {
    server: {
        response_time: 120000
    }
};
function isMouseLeaveOrEnter(e, handler) { 
    var reltg = e.relatedTarget || e.type == 'mouseout' ? e.toElement : e.fromElement;
    while (reltg && reltg != handler) {
        reltg = reltg.parentNode;
    }
    return reltg != handler;
}
function getRandomColor(rgb) {
    return rgb ? 'rgb(' + (rgb[0] || Math.round(Math.random() * 255)) + ',' + (rgb[1] || Math.round(Math.random() * 255)) + ',' + (rgb[2] || Math.round(Math.random() * 255)) + ')' : '#' + ('00000' + (Math.random() * 0x1000000 << 0).toString(16)).slice(-6);
}
function markString(str, sign, color, tag) {
    color = color || '#F00';
    tag = tag || 'span';
    var regexp = new RegExp('(' + sign + ')', 'g');
    retStr = str.replace(regexp, "<" + tag + " style='color:" + color + ";'>$1</" + tag + ">");
    regexp = new RegExp("</" + tag + "><" + tag + " style='color:" + color + ";'>", 'g');
    return retStr.replace(regexp, "");
}

if (typeof jQuery !== 'undefined') {
    if (typeof layer === 'object') {
        layer.config({
            shade: 0.2, 
            shadeClose: true, 
            scrollbar: false, 
            moveType: 1
        });
        $.extend({
            layer: {
                id: 1,
                loadingFlag: true,
                alert: function (msg, i, f) {
                    var icon = typeof (i) === 'number' ? i : typeof (f) === 'number' ? f : -1,
                            fn = typeof (i) === 'function' ? i : typeof (f) === 'function' ? f : null,
                            shadeCloseFlag = fn === null ? true : false;
                    layer.alert(msg, {
                        icon: icon, 
                        shift: 5, 
                        shadeClose: shadeCloseFlag,
                        move: false, 
                    }, function (index) {
                        (!fn || fn() !== false) && layer.close(index);
                    });
                },
                confirm: function (msg, okFn, cancelFn) {
                    layer.confirm(msg, {
                        icon: 3,
                        shift: 6,
                        move: false
                    }, function (index) {
                        (!okFn || okFn() !== false) && layer.close(index);
                    }, cancelFn);
                },
                reload: function () {
                    layer.closeAll();
                    layer.msg('Loading...', {
                        icon: 6,
                        shadeClose: false,
                        time: config.server.response_time || 120000
                    });
                    location.reload();
                },
                loadingStart: function () {
                    layer.load(3, {
                        shadeClose: false,
                        shade: [0.1, '#000000'],
                        time: config.server.response_time || 120000
                    });
                },
                loadingStop: function () {
                    layer.closeAll('loading');
                }
            },
            cookie: {
                check: function () {
                    var flag = navigator.cookieEnabled;
                    !flag && $.layer.alert('enable cookie');
                    return flag;
                },
                set: function (name, value, expiredays) {
                    if (!this.check()) {
                        return;
                    }
                    if (expiredays) {
                        var exdate = new Date();
                        exdate.setDate(exdate.getDate() + expiredays);
                    }
                    document.cookie = name + "=" + escape(value) + (expiredays == null ? "" : ";expires=" + exdate.toGMTString());
                },
                get: function (name) {
                    if (!this.check()) {
                        return;
                    }
                    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
                    return arr = document.cookie.match(reg) ? (arr[2]) : null;
                },
                del: function (name) {
                    if (!this.check()) {
                        return;
                    }
                    var exp = new Date();
                    exp.setTime(exp.getTime() - 1);
                    var cval = getCookie(name);
                    if (cval != null) {
                        document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
                    }
                }
            },
            Object: {
                count: function (p) {
                    p = p || false;
                    return $.map(this, function (o) {
                        if (!p)
                            return o;
                        return true;
                    }).length;
                }
            },
            jsonFilter: function (filter) {
                var a = {}, c = [], l = filter.length;
                for (var i = 0; i < l; i++) {
                    var b = filter[i];
                    var d = (typeof b) + b;
                    if (a[d] === undefined) {
                        c.push(b);
                        a[d] = 1;
                    }
                }
                return c;
            },
        });
        $.fn.getLayerid = function () {
            var $this = $(this);
            !$this.data('layerid') && $this.data('layerid', 'layer-' + $.layer.id) && $.layer.id++;
            return $this.data('layerid');
        };
        $.ajaxSetup({
            type: 'POST',
            timeout: config.server.response_time || 120000,
            dataType: "json",
            beforeSend: function () {
            },
            complete: function () {
            },
            dataFilter: function (output, type) {
                return output;
            },
            error: function (jqXHR, textStatus, errorMsg) {
                errorMsg == 'timeout' ? parent.$.layer.alert('請求にタイムアウトしました', 0) : parent.$.layer.alert('to "' + this.url + '"error[' + jqXHR.status + ']:' + errorMsg, 0);
            },
            success: function (output) {
                output.code ? parent.$.layer.alert(output.msg, 2) : output.msg && parent.layer.msg(output.msg, {icon: 1, time: 1500});
            }
        });
        $(document).ajaxStart(function () {
            parent.$.layer.loadingFlag && parent.$.layer.loadingStart();
        }).ajaxStop(function () {
            parent.$.layer.loadingFlag && parent.$.layer.loadingStop();
        }).ready(function () {
            var $this = $(this);
            $.fn.getTipUploadHtml = function () {
                var $this = $(this),
                        width = $this.data("width"),
                        height = $this.data("height"),
                        bg = $this.data("bg"),
                        maxsize = $this.data("maxsize");
                var html = "";
                if (width || height || bg || maxsize) {
                    html += '<div class="tip_upload"><div><div>===アドバイス===</div>';
                    if (width) {
                        html += '<div>&nbsp;【広さ】' + width + '</div>';
                        $this.removeData("width").removeAttr("data-width");
                    }
                    if (height) {
                        html += '<div>&nbsp;【高さ】' + height + '</div>';
                        $this.removeData("height").removeAttr("data-height");
                    }
                    if (bg) {
                        html += '<div>&nbsp;【背景】' + bg + '</div>';
                        $this.removeData("bg").removeAttr("data-bg");
                    }
                    if (maxsize) {
                        html += '<div>&nbsp;【サイズ】' + maxsize + '以下</div>';
                        $this.removeData("maxsize").removeAttr("data-maxsize");
                    }
                    html += '</div></div>';
                }
                return html;
            };
            $(".upload").each(function () {
                var $this = $(this);
                var showHtml = '';
                var $img = $this.find(">img");
                if ($img.length) {
                    var rel = $img.attr("rel");
                    showHtml += '<div class="show_img_upload">';
                    showHtml += '<a class="a_pre_upload" href="' + rel + '"> <img src="' + rel + '" /></a>';
                    showHtml += '<a href="javascript:;" class="del_upload"></a>';
                    var field = $this.data("field");
                    showHtml += '<input type="hidden" name="' + field + '" value="' + rel + '">';
                    $img.remove();
                } else {
                    showHtml += '<div class="btn_upload"><div class="add_upload"><input type="file" name="file" unselectable="on" class="file_hidden"></div>';
                }
                showHtml += '</div>';
                var $pre = $this.prepend(showHtml + $this.getTipUploadHtml()).find(">.show_img_upload");
                if ($pre.length) {
                    var group = $this.data("group");
                    $pre.find(">.a_pre_upload").colorbox(group ? {rel: group, maxHeight: '90%', maxWidth: '90%'} : {maxHeight: '90%', maxWidth: '90%'})
                }
            });

            $(".uploads").each(function () {
                var $this = $(this);
                var $img = $this.find(">img"),
                        length = $img.length,
                        cnt = 0;
                var html = '<div class="clear"></div><div class="show">';
                if (length) {
                    var $form = $this.closest("form"),
                            show = $this.data("show"),
                            field = $this.data("field"),
                            deleted = $this.data("deleted");
                    $img.each(function (i) {
                        var $ts = $(this),
                                idImg = $ts.data("idimg"),
                                rel = $ts.attr("rel");
                        if ($ts.data("flagdel")) {
                            var hiddenHtml = '<input type="hidden" name="' + deleted + '" value="' + idImg + '" />';
                            hiddenHtml += '<input type="hidden" name="' + show + '[' + i + '][img_id]" value="' + idImg + '">';
                            hiddenHtml += '<input type="hidden" name="' + show + '[' + i + '][file]" value="' + rel + '">';
                            $form.append(hiddenHtml);
                        } else {
                            cnt++;
                            html += '<div class="show_img_upload">';
                            html += '<a class="a_pre_upload" href="' + rel + '"> <img src="' + rel + '" /></a>';
                            if (idImg) {
                                html += '<a href="javascript:;" class="del_upload" data-del="' + idImg + '"></a>';
                                html += '<input type="hidden" name="' + show + '[' + i + '][img_id]" value="' + idImg + '">';
                                html += '<input type="hidden" name="' + show + '[' + i + '][file]" value="' + rel + '">';
                            } else {
                                html += '<a href="javascript:;" class="del_upload"></a>';
                                html += '<input type="hidden" name="' + field + '" value="' + rel + '">';
                            }
                            html += "</div>";
                        }
                        $ts.remove();
                    });
                }
                html += "</div>";
                var showHtml = '<div class="btn_upload"><div class="add_upload" "><input type="file" name="file" unselectable="on"  class="file_hidden"></div><div class="cnt_upload"><span>' + cnt + '</span>枚アップロードしました</div></div>';
                var $pre = $this.prepend(showHtml + $this.getTipUploadHtml()).parent().append(html).find(">.show>.show_img_upload");
                if ($pre.length) {
                    var group = $this.data("group");
                    $pre.find(">.a_pre_upload").colorbox(group ? {rel: group, maxHeight: '90%', maxWidth: '90%'} : {maxHeight: '90%', maxWidth: '90%'});
                }
            });
            $this.on('click', '.rayu-ajax-confirm', function (e) {
                e.preventDefault();
                var $this = $(this);
                $.layer.confirm('確認' + $this.getMsg(),{btn: ['OK','キャンセル']} ,function () {
                    var href = $this.data('href');
                    if (!href) {
                        return;
                    }
                    $.get(href, function (output) {
                        if (output.code) {
                            if ($this.data('reload')) {
                                $.layer.alert(output.msg, 2, $.layer.reload);
                            } else {
                                $.layer.alert(output.msg, 2);
                            }
                        } else {
                            layer.msg(output.msg || '成功しました', {
                                icon: 1,
                                time: 1500
                            }, $.layer.reload);
                        }
                    });
                });
            }).on('click', '.rayu-confirm', function (e) {
                e.preventDefault();
                var $this = $(this);
                $.layer.confirm('確認' + $this.getMsg(),{btn: ['OK','キャンセル']}, function () {
                    var href = $this.data('href');
                    if (!href) {
                        return;
                    }
                    $.layer.loadingStart();
                    location.href = href;
                });
            }).on('click', 'form input[name=complete]', function (e) {
                var $this = $(this);
                !$this.data('form') && $this.data('form', $this.closest('form'));
                var $form = $this.data('form');
                if ($form[0]) {
                    e.preventDefault();
                    layer.confirm('保存してもよろしいでしょうか？', {btn: ['はい','いいえ'],title:'メッセージ',closeBtn: 0},function () {
                        $.layer.loadingStart();
                        $form.append('<input type="hidden" value="1" name="complete">').submit();
                    });
                }
            }).on('click', '.rayu-html-fetch', function (e) {
                e.preventDefault();
                var $this = $(this),
                        href = $this.data('href');
                if (!href) {
                    return;
                }
                var title = this.title,
                        width = $this.data('width'),
                        height = $this.data('height');
                $.get(href, function (output) {
                    if (output.code) {
                        $.layer.alert(output.msg, 2);
                    } else {
                        layer.open({
                            type: 1,
                            shift: 2,
                            title: title || 'メッセージ',
                            area: width ? height ? [width, height] : width : 'auto',
                            shade: 0.8,
                            maxmin: $this.data('maxmin') || false,
                            scrollbar: true,
                            id: $this.getLayerid(),
                            content: output.data.obj.html
                        });
                    }
                });
            }).on('click', '.rayu-html', function (e) {
                e.preventDefault();
                var $this = $(this),
                        href = $this.data('href');
                if (!href) {
                    return;
                }
                var title = this.title,
                        width = $this.data('width'),
                        height = $this.data('height');
                $.get(href, function (output) {
                    if (output.code) {
                        $.layer.alert(output.msg, 2);
                    } else {
                        layer.alert(output.data.obj.html, {
                            title: title || 'メッセージ',
                            closeBtn: 0
                        });
                    }
                });
            }).on('click', '.rayu-html-iframe', function (e) {
                e.preventDefault();
                var href = this.href;
                if (!href || href == 'javascript:;') {
                    return;
                }
                var $this = $(this),
                        width = $this.data('width'),
                        height = $this.data('height');
                layer.open({
                    type: 2,
                    shift: 3,
                    title: this.title || '&nbsp;',
                    area: width && height ? [width, height] : ['88%', '50%'],
                    shade: 0.8,
                    maxmin: true,
                    scrollbar: true,
                    id: $this.getLayerid(),
                    content: href
                });
            }).on("click", ".upload .del_upload", function (e) {
                e.preventDefault();
                var $this = $(this);
                $.layer.confirm('削除してもよろしいですか', function () {
                    var $parent = $this.parent();
                    $parent.parent().prepend('<div class="btn_upload"><div class="add_upload"><input type="file" name="file" unselectable="on" class="file_hidden"></div>');
                    $parent.remove();
                });
            }).on("click", ".show .del_upload", function (e) {
                e.preventDefault();
                var $this = $(this);
                $.layer.confirm('削除してもよろしいですか', function () {
                    var $uploads = $this.closest("td").find(">.uploads");
                    var $cntUpload = $uploads.find(">.btn_upload>.cnt_upload>span");
                    var idImg = $this.data("del");
                    if (idImg) {
                        $this.closest("form").append('<input type="hidden" name="' + $uploads.data("deleted") + '" value="' + idImg + '" />').append($this.siblings("input[type=hidden]").clone());
                    }
                    $cntUpload.text(parseInt($.text($cntUpload)) - 1);
                    $this.parent().remove();
                });
            }).on("click", ".add_upload", function () {
                var $this = $(this),
                        $parent = $this.parent(),
                        $upload = $parent.parent();
                var flagMultiple = $upload.hasClass("uploads") ? 1 : 0;
                if (flagMultiple) {
                    var $cntUpload = $this.next().find("span"),
                            cnt = parseInt($.text($cntUpload)),
                            maxcnt = $upload.data("maxcnt");
                    if (maxcnt && cnt == maxcnt) {
                        layer.msg('最大' + maxcnt + '枚', {icon: 0, time: 1500});
                        return;
                    }
                }
                $('.file_hidden').fileupload({
                    url: $upload.data('url'),
                    dataType: 'json',
                    timeout: 120000,
                    success: function (output) {
                        if (output && output.status == '1') {
                            var url = output.data.url;
                            if (url) {
                                var html = '<div class="show_img_upload">';
                                html += '<a class="a_pre_upload" href="' + url + '"> <img src="' + url + '" /></a>';
                                html += '<a href="javascript:;" class="del_upload"></a>';
                                var field = $upload.data("field");
                                html += '<input type="hidden" name="' + field + '" value="' + url + '">';
                                html += "</div>";
                                var group = $upload.data("group");
                                if (flagMultiple) {
                                    $this.closest("td").find(">.show").append(html).find(">.show_img_upload:last>.a_pre_upload").colorbox(group ? {rel: group, maxHeight: '90%', maxWidth: '90%'} : {maxHeight: '90%', maxWidth: '90%'});
                                    $cntUpload.text(cnt + 1);
                                } else {
                                    $upload.prepend(html).find(">.show_img_upload>.a_pre_upload").colorbox(group ? {rel: group, maxHeight: '90%', maxWidth: '90%'} : {maxHeight: '90%', maxWidth: '90%'});
                                    $parent.remove();
                                }
                            }
                        } else {
                            layer.msg((output && output.msg) || 'アップロードに失敗しました');
                        }
                        loadingStop();
                    },
                    error: function () {
                        layer.msg('アップロードに失敗しました')
                    },
                })
            });
        });
    }
    $.extend({
        browser: {
            msie: /msie/.test(navigator.userAgent.toLowerCase()),
            mozilla: /firefox/.test(navigator.userAgent.toLowerCase()),
            webkit: /webkit/.test(navigator.userAgent.toLowerCase()),
            opera: /opera/.test(navigator.userAgent.toLowerCase())
        }
    });
    $.fn.getMsg = function () {
        var $this = $(this);
        var msg = $this.data("msg");
        return msg ? msg : $this.is("input") ? $.trim($this.val()) : $.trim($.text($this));
    };
    
    $.fn.listenCbx = function (checkFn, uncheckFn) {
        var $checkAll = $('.check-all'),
                $checkOpt = $('.check-opt'),
                optLength = $checkOpt.length;
        $(this).on('click', '.check-all', function () {
            var flag = $checkAll.prop('checked');
            $checkOpt.each(function () {
                var $this = $(this);
                $this.prop('checked') !== flag && $this.prop('checked', flag).change();
            });
        }).on({
            click: function () {
                $(this).prop('checked') ? $('.check-opt:checked').length == optLength && $checkAll.prop('checked', true) : $checkAll.prop('checked', false);
            }, change: function () {
                $(this).prop("checked") ? checkFn && checkFn(this) : uncheckFn && uncheckFn(this);
            }
        }, '.check-opt');
    };
}

function iframeAuto(height) {
    setTimeout(function () {
        var layer_id = $('.layui-layer-content').last().attr('id');
        $('#' + layer_id).parents('.layui-layer-iframe').height((height + $('.layui-layer-title').height()));
        $('#' + layer_id).find('iframe').css({height: height});
        var h = ($(parent.window).height() - $('#' + layer_id).parents('.layui-layer').height()) / 2;
        $('#' + layer_id).parents('.layui-layer').css({top: h, height: 'auto'});
    }, 10)
}