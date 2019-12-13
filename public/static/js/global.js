// 菜单点击事件
function menu_fire(obj) {
    $('.down_menu li').removeClass('layui-this');
    $(obj).parent('li').addClass('layui-this');

    var controller = $.trim($(obj).attr('controller'));
    var action = $.trim($(obj).attr('action'));
    if (controller == '' || action == '') {
        return;
    }

    var src = '/admins/' + controller + '/' + action;
    $('#main_frame').attr('src', src);
    window.location.hash = '/' + controller + '/' + action;

    $('#phpcn_nav_side').find('a').removeClass('active');
    $(obj).addClass('active');
}

function init() {
    var url = hash_link();
    if (url != undefined && url != '') {
        var src = '/admins' + url;
        $('#main_frame').attr('src', src);
    }
    vm_menus.urls = url;
}

function hash_link() {
    var twa = window.top.location.href.split("#");
    var url = twa[1];
    return url == undefined ? '' : url;
}

// 加载菜单
function load_menu() {
    // 设置菜单容器高度
    var left_height = document.documentElement.clientHeight - 112;
    $('#phpcn_nav_side').height(left_height);

    $.get('/admins/home/ajax_get_left_menu', { 'rand': Math.random() }, function(res) {
        if (res.code > 0) {
            return;
        }
        vm_menus.items = res.data;
        setTimeout(function() {
            var url = hash_link();
            $('#phpcn_nav_side a[data="/admins' + url + '"]').addClass('active').parent('dl').parent('li').trigger('click');
        }, 50);
    }, 'json');
}
// 重新设置页面高度
function resetHeight(obj) {
    var left_height = parent.document.documentElement.clientHeight - 141;
    $(obj).parent('div').height(left_height);
}

function site_save(url) {
    if (!url || url == undefined) {
        return layer.msg('地址不能为空', { icon: 2 });
    }
    $.post(url, $('form').serialize(), function(res) {
        if (res.code > 0) {
            return layer.msg(res.msg, { icon: 2 });
        }
        layer.msg(res.msg, { icon: 1 });
    }, 'json');
}

function check_gd() {
    $.get('/admins/site/check_gd', {}, function(res) {
        if (res.code > 0) {
            return layer.msg(res.msg, { icon: 2 });
        }
        layer.msg(res.msg, { icon: 1 });
    }, 'json');
}
// 图片上传
function upload_img(obj) {
    layer.msg('上传中...', {
        icon: 16,
        shade: 0.3,
        time: 0
    });
    $(obj).parent('form').submit();
}

function upload_success(imgUrl) {
    layer.closeAll();
    layer.msg('上传成功', { icon: 1 });
    $('#pre_img').attr('src', imgUrl);
    $('#imgurl').val(imgUrl);
}

function upload_error(msg) {
    layer.closeAll();
    layer.open({
        icon: 2,
        content: msg
    });
}
// 预览图片
function show_img() {
    var imgurl = $('#pre_img').attr('src');
    var res = getMousePos();
    var html = '<div style="background:#fff;position: absolute;width: 200px;border:solid 1px #cdcdcd;border-radius: 6px;padding: 2px;left:' + res.x + 'px;top:' + res.y + 'px;z-index:1000" id="preview">\
						<img style="width: 100%;border-radius: 6px;" src="' + imgurl + '">\
				</div>';
    $('body').append(html);

}

function hide_img() {
    $('#preview').remove();
}
// 获取鼠标位置
function getMousePos(event) {
    var e = event || window.event;
    var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
    var scrollY = document.documentElement.scrollTop || document.body.scrollTop;
    var x = e.pageX || e.clientX + scrollX;
    var y = e.pageY || e.clientY + scrollY;
    return { 'x': x, 'y': y };
}
//邮件设置测试
function check_email() {
    $.ajax({
        type: "post",
        url: "/admins/site/check_email",
        xhrFields: {
            withCredentials: true
        },
        data: $('form').serialize(),
        dataType: 'json',
        success: function(res) {
            if (res.code > 0) {
                return layer.msg(res.msg, { icon: 2 });
            }
            layer.msg(res.msg, { icon: 1 });
        },
        error: function(err) {
            return layer.msg('发送失败，请检查配置信息', { icon: 2 });
        }
    });
}

function logout() {
    layer.confirm('确定要退出吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.get('/admins/account/logout', function(res) {
            if (res.code > 0) {
                return layer.alert(res.msg, { 'icon': 2 });
            }
            layer.msg(res.msg);
            setTimeout(function() { window.location.href = "/admins/account/login" }, 1000);
        }, 'json');
    });
}
// 加载编辑器
function init_editor(id, width, height) {
    if (!width || width == undefined) {
        width = 460;
    }
    if (!height || height == undefined) {
        height = 460;
    }
    ue = UE.getEditor(id, {
        toolbars: [
            [
                'source', //源代码
                'bold', //加粗
                'italic', //斜体
                'underline', //下划线
                'fontborder', //字符边框
                'blockquote', //引用
                'pasteplain', //纯文本粘贴模式
                'preview', //预览
                'horizontal', //分隔线
                'removeformat', //清除格式
                'unlink', //取消链接
                'deleterow', //删除行
                'deletecol', //删除列
                'splittorows', //拆分成行
                'splittocols', //拆分成列
                'splittocells', //完全拆分单元格
                'deletecaption', //删除表格标题
                'inserttitle', //插入标题
                'mergecells', //合并多个单元格
                'deletetable', //删除表格
                'insertparagraphbeforetable', //"表格前插入行"
                'insertcode', //代码语言
                'insertcode', //代码语言
                'fontfamily', //字体
                'fontsize', //字号
                'paragraph', //段落格式
                'simpleupload', //单图上传
                'insertimage', //多图上传
                'edittable', //表格属性
                'edittd', //单元格属性
                'link', //超链接
                'spechars', //特殊字符
                'justifyleft', //居左对齐
                'justifyright', //居右对齐
                'justifycenter', //居中对齐
                'justifyjustify', //两端对齐
                'forecolor', //字体颜色
                'backcolor', //背景色
                'insertorderedlist', //有序列表
                'insertunorderedlist', //无序列表
                'fullscreen', //全屏
                'rowspacingtop', //段前距
                'rowspacingbottom', //段后距
                'pagebreak', //分页
                'insertframe', //插入Iframe
                'lineheight', //行间距
                'customstyle', //自定义标题
                'touppercase', //字母大写
                'tolowercase', //字母小写
                'inserttable', //插入表格
                'snapscreen', //截图
                'drafts' // 从草稿箱加载
            ]
        ],
        wordCount: false,
        elementPathEnabled: false,
        pasteplain: true,
        allowDivTransToP: false,
        initialFrameWidth: width,
        initialFrameHeight: height,
        // iframeCssUrl:'/static/ueditor/plugin/js/user_code.css'
    });
}

function form_add(data) {
    var i = parseInt($(data).parent('.phpcn-form').attr('i')) + 1;
    var html = '<div class="phpcn-form-item phpcn-bg-fff">';
    html += '<div class="phpcn-input-block">';
    html += '    <input type="text" placeholder="请输入配置名" name="key' + i + '[]" class="phpcn-input" value="">';
    html += '  </div>';
    html += '  <div class="phpcn-input-block">';
    html += '    <input type="text" placeholder="请输入值" name="key' + i + '[]" class="phpcn-input" value="">';
    html += '   </div>';
    html += '   <div class="phpcn-input-block">';
    html += '<button type="button" class="phpcn-button phpcn-bg-red" onclick="form_del(this);">&nbsp;&nbsp;删除 -&nbsp;&nbsp;</button>';
    html += '   </div>';
    html += '</div>';
    $(data).before(html);
    $(data).parent('.phpcn-form').attr('i', i);
}

function form_del(data) {
    var i = parseInt($(data).parents('.phpcn-form').attr('i'));
    $(data).parents('.phpcn-form').attr('i', i - 1);
    $(data).parents('.phpcn-form-item').remove();
}

function model_add(id) {
    layer.open({
        type: 2,
        title: id > 0 ? '编辑' : '添加',
        shade: 0.3,
        area: ['680px', '650px'],
        content: '/admins/model/add?id=' + id
    });
}
// 管理员删除
function model_del(id) {
    layer.confirm('确定要删除吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.post('/admins/model/del', { id: id, _token: $('input[name="_token"]').val() }, function(res) {
            if (res.code > 0) {
                layer.msg(res.msg, { icon: 2 });
            } else {
                layer.msg(res.msg, { icon: 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}
// 搜索
function model_searchs() {
    var type = $('select[name="type"]').val();
    var wd = $.trim($('input[name="wd"]').val());
    window.location.href = '/admins/model/index?type=' + type + '&wd=' + wd;
}
// 数据库
function model_field_index(id) {
    window.location.href = '/admins/model/field_index?id=' + id;
}
// 配置模型字段
function model_table_index(id) {
    window.location.href = '/admins/model/table_index?id=' + id;
}
// 生成表单
function model_form_index(id) {
    window.location.href = '/admins/model/form_index?id=' + id;
}

function model_save(url) {
    $.post(url, $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
            if (res.code == 2) {
                setTimeout(function() { parent.window.location.reload(); }, 1000);
            }
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
// 取消
function model_cancel() {
    parent.window.layer.closeAll();
}
// 添加数据表
function model_add_table() {
    let html = '';
    id++;
    html += '<div class="phpcn-form-item" id="mysql_' + id + '">';
    html += ' <label class="phpcn-form-label">数据表</label>';
    html += ' <div class="phpcn-input-block">';
    html += '   <input type="text" class="phpcn-input" name="table_effect[' + id + ']" placeholder="请输入表作用">';
    html += ' </div>';
    html += ' <div class="phpcn-input-block">';
    html += '   <input type="text" class="phpcn-input" name="table_sql[' + id + ']" placeholder="请输入sql执行语句">';
    html += ' </div>';
    html += ' <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" onclick="model_del_table(' + id + ')">';
    html += '   <i class="layui-icon">&nbsp;&nbsp;-&nbsp;&nbsp;</i>';
    html += ' </button>';
    html += '</div>';
    $("#mysql").append(html);
}
// 删除数据表
function model_del_table(id) {
    $("#mysql_" + id).remove();
}

function model_add_index() {
    let html = '';
    index_id++;
    html += '<div class="phpcn-form-item" id="index_' + index_id + '">';
    html += '	<label class="phpcn-form-label">首页模板</label>';
    html += '	<div class="phpcn-input-block">';
    html += '		<input type="text" class="phpcn-input" name="index_tpl[]" value="" placeholder="模版可多个">';
    html += '	</div>';
    html += '	<button type="button" class="layui-btn layui-btn-primary layui-btn-sm" onclick="model_del_index(' + index_id + ')">';
    html += '		<i class="layui-icon">&nbsp;&nbsp;-&nbsp;&nbsp;</i>';
    html += '	</button>';
    html += '</div>';
    $("#index").append(html);
}

function model_del_index(index_id) {
    $("#index_" + index_id).remove();
}

function model_add_list() {
    let html = '';
    list_id++;
    html += '<div class="phpcn-form-item" id="list_' + list_id + '">';
    html += '	<label class="phpcn-form-label">列表页模板</label>';
    html += '	<div class="phpcn-input-block">';
    html += '		<input type="text" class="phpcn-input" name="list_tpl[]" value="" placeholder="模版可多个">';
    html += '	</div>';
    html += '	<button type="button" class="layui-btn layui-btn-primary layui-btn-sm" onclick="model_del_list(' + list_id + ')">';
    html += '		<i class="layui-icon">&nbsp;&nbsp;-&nbsp;&nbsp;</i>';
    html += '	</button>';
    html += '</div>';
    $("#list").append(html);
}

function model_del_list(list_id) {
    $("#list_" + list_id).remove();
}

function model_add_content() {
    let html = '';
    content_id++;
    html += '<div class="phpcn-form-item" id="content_' + content_id + '">';
    html += '	<label class="phpcn-form-label">内容页模板</label>';
    html += '	<div class="phpcn-input-block">';
    html += '		<input type="text" class="phpcn-input" name="detail_tpl[]" value="" placeholder="模版可多个">';
    html += '	</div>';
    html += '	<button type="button" class="layui-btn layui-btn-primary layui-btn-sm" onclick="model_del_content(' + content_id + ')">';
    html += '		<i class="layui-icon">&nbsp;&nbsp;-&nbsp;&nbsp;</i>';
    html += '	</button>';
    html += '</div>';
    $("#content").append(html);
}

function model_del_content(content_id) {
    $("#content_" + content_id).remove();
}

function model_data_save(url) {
    $.post(url, $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            // setTimeout(function(){parent.window.location.reload();},1000);
        }
    }, 'json');
}

function model_data_index_add(table_id, id) {
    layer.open({
        type: 2,
        title: '添加',
        shade: 0.3,
        area: ['680px', '650px'],
        content: '/admins/model/data_add?table_id=' + table_id + '&id=' + id
    });
}
// 管理员删除
function model_data_index_del(table_id, id) {
    layer.confirm('确定要删除吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.post('/admins/model/data_del', { id: id, table_id: table_id, _token: $('input[name="_token"]').val() }, function(res) {
            if (res.code > 0) {
                layer.msg(res.msg, { icon: 2 });
            } else {
                layer.msg(res.msg, { icon: 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}

function model_field_add_table() {
    let html = '';
    id++;
    html += '<div class="phpcn-form-item" id="mysql_' + id + '">';
    html += '	<label class="phpcn-form-label">数据表</label>';
    html += '	<div class="phpcn-input-block">';
    html += '		<input type="text" class="phpcn-input" name="table_effect[' + id + ']" placeholder="请输入表作用">';
    html += '	</div>';
    html += '	<div class="phpcn-input-block">';
    html += '		<input type="text" class="phpcn-input" name="table_sql[' + id + ']" placeholder="请输入sql执行语句">';
    html += '	</div>';
    html += '	<button type="button" class="layui-btn layui-btn-primary layui-btn-sm" onclick="model_field_del_table(' + id + ')">';
    html += '		<i class="layui-icon">&nbsp;&nbsp;-&nbsp;&nbsp;</i>';
    html += '	</button>';
    html += '</div>';
    $("#mysql").append(html);
}
// 删除数据表
function model_field_del_table(id) {
    $("#mysql_" + id).remove();
}
// 保存
function model_field_save(url) {
    $.post(url, $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}

function model_field_index_add(id) {
    layer.open({
        type: 2,
        title: '添加',
        shade: 0.3,
        area: ['680px', '650px'],
        content: '/admins/model/field_add?id=' + id
    });
}
// 数据表字段管理
function model_field_index_sql_index(id) {
    layer.open({
        type: 2,
        title: id > 0 ? '编辑' : '添加',
        shade: 0.3,
        area: ['900px', '650px'],
        content: '/admins/model/sql_index?id=' + id
    });
}
// 数据管理
function model_field_index_data_index(id) {
    window.location.href = '/admins/model/data_index?id=' + id;
}
// 管理员删除
function model_field_index_del(id) {
    layer.confirm('提醒一次：删除会把表删掉', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        layer.confirm('提醒二次：删除表，请先备份数据', {
            icon: 3,
            btn: ['确定', '取消']
        }, function() {
            layer.confirm('提醒三次：删除表不可恢复', {
                icon: 3,
                btn: ['确定', '取消']
            }, function() {
                $.post('/admins/model/field_del', { id: id, _token: $('input[name="_token"]').val() }, function(res) {
                    if (res.code > 0) {
                        layer.msg(res.msg, { icon: 2 });
                    } else {
                        layer.msg(res.msg, { icon: 1 });
                        setTimeout(function() { window.location.reload(); }, 1000);
                    }
                }, 'json');
            });
        });
    });
}

function model_form_index_save() {
    $.post('/admins/model/form_add', $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            // layer.msg(res.msg,{'icon':1});
            // $("#html").append(res.msg);
            layer.open({
                type: 1,
                shade: 0.3,
                area: ['680px', '650px'],
                content: res.msg
            });
            // setTimeout(function(){parent.window.location.reload();},1000);
        }
    }, 'json');
}

function model_sql_save() {
    var name = $.trim($('input[name="name"]').val());
    if (name == '') {
        layer.alert('请输入字段英文名', { 'icon': 2 });
        return;
    }
    var label = $.trim($('input[name="label"]').val());
    if (label == '') {
        layer.alert('请输入备注', { 'icon': 2 });
        return;
    }
    var type = $.trim($('select[name="type"]').val());
    if (type == '') {
        layer.alert('请选择类型', { 'icon': 2 });
        return;
    }
    var length = $.trim($('input[name="length"]').val());
    if (length <= 0) {
        layer.alert('请输入长度，长度要大于0', { 'icon': 2 });
        return;
    }

    $.post('/admins/model/field_edit', $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
// 保存
function model_sql_index_save() {
    $.post('/admins/model/sql_edit', $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
            if (res.code == 2) {
                setTimeout(function() { parent.window.location.reload(); }, 1000);
            }
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
// 删除字段
function model_sql_index_del(id, name) {
    $.post('/admins/model/sql_del', { id: id, name: name, _token: $('input[name="_token"]').val() }, function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            $("#" + name).remove();
            layer.msg(res.msg, { 'icon': 1 });
        }
    }, 'json');
}
// 添加数据表
function model_sql_index_add_field() {
    let html = '';
    id++;
    html += '<div class="phpcn-form-item" id="field_list_' + id + '">';
    html += '	<div class="phpcn-input-block">';
    html += '		<input type="text" class="phpcn-input" name="names[]" placeholder="请输入字段">';
    html += '	</div>';
    html += '	<div class="phpcn-input-block phpcn-form-select">';
    html += '		<i class="phpcn-trilateral"></i>';
    html += '		<select name="types[]" lay-filter="aihao">';
    html += '			<option value="0" selected=""></option>';
    html += '			<option value="tinyint">tinyint</option>';
    html += '			<option value="int">int</option>';
    html += '			<option value="char">char</option>';
    html += '			<option value="varchar">varchar</option>';
    html += '			<option value="text">text</option>';
    html += '		</select>';
    html += '		<dl class="phpcn-form-hide">';
    html += '			<dd phpcn-value="" class="phpcn-select-tips">请选择</dd>';
    html += '			<dd phpcn-value="0" class="on"></dd>';
    html += '			<dd phpcn-value="tinyint">tinyint</dd>';
    html += '			<dd phpcn-value="int">int</dd>';
    html += '			<dd phpcn-value="char">char</dd>';
    html += '			<dd phpcn-value="varchar">varchar</dd>';
    html += '			<dd phpcn-value="text">text</dd>';
    html += '		</dl>';
    html += '		<input type="text" placeholder="请选择" value="请选择" readonly="" class="phpcn-input">';
    html += '	</div>';
    html += '	<div class="phpcn-input-block">';
    html += '		<input type="text" class="phpcn-input" name="labels[]" placeholder="请输入作用">';
    html += '	</div>';
    html += '	<div class="phpcn-input-block">';
    html += '		<input type="text" class="phpcn-input" name="lengths[]" placeholder="请输入字段长度">';
    html += '	</div>';
    html += '	<div class="phpcn-input-block">';
    html += '		<button type="button" class="phpcn-button phpcn-bg-black" onclick="del_field(' + id + ');">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;</button>';
    html += '	</div>';
    html += '</div>';
    $("#field_list").append(html);
}
// 删除数据表
function model_sql_index_del_field(id) {
    $("#field_list_" + id).remove();
}

function model_table_index_chec(id, type) {
    if (type == 1) {
        $("[name=sys" + id + "]:checkbox").attr('disabled', true);
        layer.alert('系统表，只能使用全部字段', { 'icon': 2 });
    } else {
        $("[name=sysc" + id + "]:checkbox").attr('disabled', true);
        layer.alert('系统内容表，只能使用全部字段', { 'icon': 2 });
    }
}
//管理员添加修改
function admin_add(aid) {
    layer.open({
        type: 2,
        title: aid > 0 ? '修改管理员' : '添加管理员',
        shade: 0.3,
        area: ['680px', '650px'],
        content: '/admins/admin/add?aid=' + aid
    });
}
// 管理员删除
function admin_del(aid) {
    layer.confirm('确定要删除吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.post('/admins/admin/del', { aid: aid, _token: $('input[name="_token"]').val() }, function(res) {
            if (res.code > 0) {
                layer.msg(res.msg, { icon: 2 });
            } else {
                layer.msg(res.msg, { icon: 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}
//管理员保存
function admin_save() {
    var data = new Object();
    data._token = $('input[name="_token"]').val();
    data.id = $('#id').val();
    data.username = $.trim($('#username').val());
    data.group_id = $('#group_id').val();
    data.pwd = $.trim($('#pwd').val());
    data.real_name = $.trim($('#real_name').val());
    data.mobile = $.trim($('#mobile').val());
    data.status = $('#status').is(':checked') ? 1 : 0;

    if (data.username == '') {
        layer.msg('请填写用户名', { 'icon': 2, 'offset': 't', 'anim': 6 });
        return;
    }
    if (data.group_id == 0) {
        layer.msg('请选择角色', { 'icon': 2, 'offset': 't', 'anim': 6 });
        return;
    }
    if (data.id == 0 && data.pwd == '') {
        layer.msg('请输入密码', { 'icon': 2, 'offset': 't', 'anim': 6 });
        return;
    }
    if (data.real_name == '') {
        layer.msg('请填写真实姓名', { 'icon': 2, 'offset': 't', 'anim': 6 });
        return;
    }
    $.post('/admins/admin/save', data, function(res) {
        if (res.code > 0) {
            layer.msg(res.msg, { 'icon': 2, 'offset': 't', 'anim': 6 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
// 菜单添加
function menus_add(mid) {
    var pid = $('input[name="pid"]').val();
    layer.open({
        type: 2,
        title: mid > 0 ? '编辑菜单' : '添加菜单',
        shade: 0.3,
        area: ['480px', '420px'],
        content: '/admins/menus/add?mid=' + mid + '&pid=' + pid
    });
}

function menus_save() {
    var pid = parseInt($('input[name="pid"]').val());
    var title = $.trim($('input[name="title"]').val());
    var controller = $.trim($('input[name="controller"]').val());
    var action = $.trim($('input[name="action"]').val());

    if (title == '') {
        layer.alert('请输入菜单名称', { 'icon': 2 });
        return;
    }

    if (pid > 0 && controller == '') {
        layer.alert('请输入控制器', { 'icon': 2 });
        return;
    }
    if (pid > 0 && action == '') {
        layer.alert('请输入方法名称', { 'icon': 2 });
        return;
    }

    $.post('/index.php/admins/menus/save', $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });

            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
// 菜单删除
function menus_del(mid) {
    layer.confirm('确定要删除吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.get('/admins/menus/delete', { 'mid': mid }, function(res) {
            if (res.code > 0) {
                layer.alert(res.msg, { 'icon': 2 });
            } else {
                layer.msg(res.msg, { 'icon': 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}
// 子菜单
function menus_child(id) {
    window.location.href = '/admins/menus/index?pid=' + id;
}
// 返回上级
function menus_back(pid) {
    window.location.href = '/admins/menus/index?pid=' + pid;
}
// 菜单添加
function nav_add(id) {
    var pid = $('input[name="pid"]').val();
    layer.open({
        type: 2,
        title: id > 0 ? '编辑菜单' : '添加菜单',
        shade: 0.3,
        area: ['480px', '580px'],
        content: '/admins/extension/nav_add?id=' + id + '&pid=' + pid
    });
}
// 菜单删除
function nav_del(id) {
    layer.confirm('确定要删除吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.get('/admins/extension/nav_del', { 'id': id }, function(res) {
            if (res.code > 0) {
                layer.alert(res.msg, { 'icon': 2 });
            } else {
                layer.msg(res.msg, { 'icon': 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}

function nav_save() {
    var pid = parseInt($('input[name="pid"]').val());
    var title = $.trim($('input[name="title"]').val());
    var controller = $.trim($('input[name="controller"]').val());
    var action = $.trim($('input[name="action"]').val());

    if (title == '') {
        layer.alert('请输入菜单名称', { 'icon': 2 });
        return;
    }

    if (pid > 0 && controller == '') {
        layer.alert('请输入控制器', { 'icon': 2 });
        return;
    }
    if (pid > 0 && action == '') {
        layer.alert('请输入方法名称', { 'icon': 2 });
        return;
    }
    $.post('/index.php/admins/extension/nav_save', $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });

            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
// 子菜单
function nav_child(id) {
    window.location.href = '/admins/extension/index?pid=' + id;
}
// 返回上级
function nav_back(pid) {
    window.location.href = '/admins/extension/index?pid=' + pid;
}
// 敏感词删除
function badword_del(uid) {
    layer.confirm('确定要清空所有敏感词吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.get('/admins/extension/badword_del', {}, function(res) {
            if (res.code > 0) {
                layer.msg(res.msg, { icon: 2 });
            } else {
                layer.msg(res.msg, { icon: 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}
// 敏感词搜索
function badword_searchs() {
    var type = $('select[name="type"]').val();
    var wd = $.trim($('input[name="wd"]').val());
    if (wd == '') {
        return layer.msg('请输入搜索关键字', { icon: 2 });
    }
    if (type == 0) {
        return layer.msg('请选择搜索类型', { icon: 2 });
    }
    window.location.href = '/admins/extension/badword?type=' + type + '&wd=' + wd;
}
//分类添加页面
function category_add(id) {
    window.location.href = '/admins/category/add?id=' + id;
}

function category_next(id) {
    window.location.href = '/admins/category/index?id=' + id;
}

function category_save() { // 保存
    var data = new Object();
    data.id = parseInt($('input[name="id"]').val());
    data._token = $.trim($('input[name="_token"]').val());
    data.title = $.trim($('input[name="title"]').val());
    data.model_id = $('select[name="model_id"]').val();
    data.index_url = $.trim($('input[name="index_url"]').val());
    data.list_url = $.trim($('input[name="list_url"]').val());
    data.detail_url = $.trim($('input[name="detail_url"]').val());
    data.index_tpl = $.trim($('select[name="index_tpl"]').val());
    data.list_tpl = $.trim($('select[name="list_tpl"]').val());
    data.detail_tpl = $.trim($('select[name="detail_tpl"]').val());
    data.seo_title = $.trim($('input[name="seo_title"]').val());
    data.keyword = $.trim($('input[name="keyword"]').val());
    data.descs = $.trim($('textarea[name="descs"]').val());
    data.cover_img = $.trim($('input[name="cover_img"]').val());
    data.code = $.trim($('input[name="code"]').val());
    data.status = parseInt($('input[name="status"]').val());
    data.content = '';
    if ($('.edui-editor').length > 0) {
        data.content = ue.getContent();
    }
    if (data.title == '') {
        layer.alert('请输入分类名', { 'icon': 2 });
        return;
    }
    if (data.model_id == 0) {
        layer.alert('请选择模型', { 'icon': 2 });
        return;
    }
    if (data.index_url == '') {
        layer.alert('请选择首页URL', { 'icon': 2 });
        return;
    }
    if (data.list_url == '') {
        layer.alert('请选择列表URL', { 'icon': 2 });
        return;
    }
    if (data.detail_url == '') {
        layer.alert('请选择内容页URL', { 'icon': 2 });
        return;
    }

    $.post('/admins/category/save', data, function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
//内容保存
function content_save() {
    var id = parseInt($('input[name="id"]').val());
    var title = $.trim($('input[name="title"]').val());
    if (title == '') {
        layer.alert('请输入菜单名称', { 'icon': 2 });
        return;
    }

    $.post('/admins/content/save', $('.phpcn-form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { 'icon': 2 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
// 取消
function cancel() {
    history.go(-1);
}
//分类删除
function category_del(id) {
    layer.confirm('确定要删除吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.post('/admins/category/del', { id: id, _token: $('input[name="_token"]').val() }, function(res) {
            if (res.code > 0) {
                layer.msg(res.msg, { icon: 2 });
            } else {
                layer.msg(res.msg, { icon: 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}
//分类搜索
function category_searchs() {
    var type = $('select[name="type"]').val();
    var wd = $.trim($('input[name="wd"]').val());
    window.location.href = '/admins/category/index?type=' + type + '&wd=' + wd;
}
// 添加、编辑角色
function groups_add(id) {
    layer.open({
        type: 2,
        title: id > 0 ? '编辑角色' : '添加角色',
        shade: 0.3,
        area: ['680px', '80%'],
        content: '/admins/groups/add?id=' + id
    });
}
//角色保存
function groups_save() {
    var title = $.trim($('input[name="title"]').val());
    if (title == '') {
        layer.alert('请填写角色名称', { icon: 2 });
        return;
    }
    $.post('/admins/groups/save', $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.alert(res.msg, { icon: 2 });
        } else {
            layer.msg(res.msg);
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}

function users_add(uid) {
    layer.open({
        type: 2,
        title: '修改用户',
        shade: 0.3,
        area: ['680px', '650px'],
        content: '/admins/users/add?uid=' + uid
    });
}

function users_save() {
    var username = $.trim($('input[name="username"]').val());
    var group_id = $('select[name="group_id"]').val();

    if (username == '') {
        return layer.msg('用户名不能为空', { 'icon': 2, 'offset': 't', 'anim': 6 });
    }
    if (group_id == 0) {
        return layer.msg('请选择角色', { 'icon': 2, 'offset': 't', 'anim': 6 });
    }

    $.post('/admins/users/save', $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.msg(res.msg, { 'icon': 2, 'offset': 't', 'anim': 6 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
// 管理员删除
function users_del(uid) {
    layer.confirm('确定要删除吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.post('/admins/users/del', { uid: uid, _token: $('input[name="_token"]').val() }, function(res) {
            if (res.code > 0) {
                layer.msg(res.msg, { icon: 2 });
            } else {
                layer.msg(res.msg, { icon: 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}
//用户搜索
function users_searchs() {
    var type = $('select[name="type"]').val();
    var wd = $.trim($('input[name="wd"]').val());
    if (wd == '') {
        return layer.msg('请输入搜索关键字', { icon: 2 });
    }
    if (type == 0) {
        return layer.msg('请选择搜索类型', { icon: 2 });
    }
    window.location.href = '/admins/users/index?type=' + type + '&wd=' + wd;
}
// 日志清空
function clear_logs(uid) {
    layer.confirm('确定要清空所有日志吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.get('/admins/extension/clear_logs', {}, function(res) {
            if (res.code > 0) {
                layer.msg(res.msg, { icon: 2 });
            } else {
                layer.msg(res.msg, { icon: 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}
// 日志搜索
function logs_searchs() {
    var type = $('select[name="type"]').val();
    var wd = $.trim($('input[name="wd"]').val());
    if (wd == '') {
        return layer.msg('请输入搜索关键字', { icon: 2 });
    }
    if (type == 0) {
        return layer.msg('请选择搜索类型', { icon: 2 });
    }
    window.location.href = '/admins/extension/logs?type=' + type + '&wd=' + wd;
}
//敏感词添加
function badword_add(id) {
    layer.open({
        type: 2,
        title: id > 0 ? '编辑' : '添加',
        shade: 0.3,
        area: ['680px', '350px'],
        content: '/admins/extension/badword_add?id=' + id
    });
}
//敏感词添加执行
function badword_save() {
    var words = $.trim($('input[name="words"]').val());
    var level = $('select[name="level"]').val();

    if (words == '') {
        return layer.msg('敏感词不能为空', { 'icon': 2, 'offset': 't', 'anim': 6 });
    }
    if (level == 0) {
        return layer.msg('请选择过滤等级', { 'icon': 2, 'offset': 't', 'anim': 6 });
    }

    $.post('/admins/extension/badword_save', $('form').serialize(), function(res) {
        if (res.code > 0) {
            layer.msg(res.msg, { 'icon': 2, 'offset': 't', 'anim': 6 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}
//来源添加
function sources_add(sid) {
    layer.open({
        type: 2,
        title: sid > 0 ? '修改来源' : '添加来源',
        shade: 0.3,
        area: ['480px', '450px'],
        content: '/admins/sources/add?sid=' + sid
    });
}
//删除来源
function sources_del(sid) {
    layer.confirm('确定要删除吗？', {
        icon: 3,
        btn: ['确定', '取消']
    }, function() {
        $.post('/admins/sources/del', { sid: sid, _token: $('input[name="_token"]').val() }, function(res) {
            if (res.code > 0) {
                layer.msg(res.msg, { icon: 2 });
            } else {
                layer.msg(res.msg, { icon: 1 });
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        }, 'json');
    });
}
//来源保存
function sources_save() {
    var data = new Object();
    data._token = $('input[name="_token"]').val();
    data.sid = $('#sid').val();
    data.title = $.trim($('#title').val());
    data.url = $.trim($('#url').val());
    data.descs = $.trim($('#descs').val());
    data.status = $('#status').is(':checked') ? 1 : 0;

    if (data.title == '') {
        return layer.msg('请填写来源名称', { 'icon': 2, 'offset': 't', 'anim': 6 });
    }

    $.post('/admins/sources/save', data, function(res) {
        if (res.code > 0) {
            layer.msg(res.msg, { 'icon': 2, 'offset': 't', 'anim': 6 });
        } else {
            layer.msg(res.msg, { 'icon': 1 });
            setTimeout(function() { parent.window.location.reload(); }, 1000);
        }
    }, 'json');
}