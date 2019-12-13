$(function(){
$('.phpcn-form-file').find('.phpcn-button').on('click',function(){
	$('#file').trigger('click');
});
$("#postionId").trigger("mychange");
//选项卡
var tab=$('.phpcn-tab dd');
jQuery.each(tab, function(e,b){
	if($(this).attr('class')=='phpcn-tab-on'){
		$('.phpcn-tab-item').eq(e).show();
	}
});
//选项卡事件
$('.phpcn-tab dd').click(function(){
	if($(this).attr('class')!='phpcn-tab-on'){
		$('.phpcn-tab dd').removeAttr('class');
		$(this).attr('class','phpcn-tab-on');
		$('.phpcn-tab-item').hide();
		index=$('.phpcn-tab dd').index(this);
		$('.phpcn-tab-item').eq(index).show();
	}
});
//开关按钮2生成
var radio= $('.phpcn-form-switch2');
jQuery.each(radio, function(e,b){
	var dlStr='<dl class="phpcn-form-switch2-dl">';
	var title = '',classNameI='',classNameSpan='',checked_class='';
	var checkboxIput=$(this).children('input');
	jQuery.each(checkboxIput, function(e,b){
		if($(this).attr('checked') != undefined){
			title= $(this).attr('title');
			checked_class='class="on"';
			classNameI='class="phpcn-form-switch2-dl-i"';
			classNameSpan='class="phpcn-form-switch2-dl-span"';
		}else if(e == 0){
			title= $(this).attr('title');
		}
	});
	dlStr+='<dd '+checked_class+'><i '+classNameI+'></i><span '+classNameSpan+'>'+title+'</span></dd>';
	$(this).append(dlStr+'</dl>');
});
//开关按钮2点击事件
$('.phpcn-form-switch2-dl dd').click(function(){
	var title = '';
	$('.phpcn-form-switch2').children('input').removeAttr('checked');
	if($(this).attr('class')=='on'){
	    $(this).removeClass('on');
		$(this).children('span').removeClass('phpcn-form-switch2-dl-span');
		$(this).children('i').removeClass('phpcn-form-switch2-dl-i');	
		$('.phpcn-form-switch2').children('input').eq(0).attr('checked','checked');
		title = $('.phpcn-form-switch2').children('input').eq(0).attr('title');
	}else{
		$(this).addClass('on');
		$(this).children('span').addClass('phpcn-form-switch2-dl-span');
		$(this).children('i').addClass('phpcn-form-switch2-dl-i');
		$('.phpcn-form-switch2').children('input').eq(1).attr('checked','checked');
		title = $('.phpcn-form-switch2').children('input').eq(1).attr('title');
	}
	$(this).children('span').html(title);
});

//单选按钮选中事件
$(document).on('click','.phpcn-form-radio-dl dd',function(){
	var ddText=$(this).children('span').html();
	var allIput=$(this).parent().siblings('input');
	$(this).parent().find('i').removeClass('phpcn-icon-plus-radio');
	$(this).parent().find('i').addClass('phpcn-icon-danxuan1');
	$(this).parent().find('i').removeClass('on');;
	if($(this).children('i').attr('class')!='on'){
		jQuery.each(allIput, function(e,b){
			var title=$(this).attr('title');
			$(this).removeAttr('checked','checked');
			if(title==ddText){
				$(this).attr('checked','checked');
			}
		});
		$(this).children('i').addClass('on');
		$(this).find('i').removeClass('phpcn-icon-danxuan1');
		$(this).children('i').addClass('phpcn-icon-plus-radio');
	}else{
		jQuery.each(allIput, function(e,b){
			var title=$(this).attr('title');
			if(title==ddText){
				$(this).removeAttr('checked','checked');
			}
		});
		$(this).children('span').removeClass('on');
		$(this).children('i').removeClass('phpcn-color-green');
	}
	
});

//开关按钮选中事件
$('.phpcn-form-switch .phpcn-form-radio-dl dd').click(function(){
	ddText=$(this).children('span').html();
	var allIput=$(this).parent().siblings('input');
	if($(this).attr('class')!='on'){
		jQuery.each(allIput, function(e,b){
			var title=$(this).attr('title');
			if(title==ddText){
				$(this).attr('checked','checked');
			}
		});
		$(this).children('span').addClass('on');
		$(this).children('i').addClass('phpcn-color-green');
	}else{
		jQuery.each(allIput, function(e,b){
			var title=$(this).attr('title');
			if(title==ddText){
				$(this).removeAttr('checked','checked');
			}
		});
		$(this).children('span').removeClass('on');
		$(this).children('i').removeClass('phpcn-color-green');
	}
});

//单选按钮生成
var radio= $('.phpcn-form-radio');
jQuery.each(radio, function(e,b){
	dlStr='<dl class="phpcn-form-radio-dl">'
	var checkboxIput=$(this).children('input');
	var that = $(this);
	jQuery.each(checkboxIput, function(e,b){
	     var title= $(this).attr('title');
	     var value=$(this).attr('value');
	     var checked=$(this).attr('checked');
	     if(checked!=undefined){
	     	checked='on';
	     	className='phpcn-icon-plus-radio';
	     }else{
	     	className='phpcn-icon-danxuan1';
	     	checked='';
	     }
	     dlStr+='<dd><i class="phpcn-icon '+className+' '+checked+'"></i><span>'+title+'</span></dd>';
	     if(that.is('.phpcn-br')){
	     	dlStr += '<br>';
	     }
	})
	$(this).append(dlStr+'</dl>');
});

//多选按钮2，生成
var checkbox= $('.phpcn-form-checkbox2');
jQuery.each(checkbox, function(e,b){
	dlStr='<dl class="phpcn-form-checkbox2-dl">';
	var checkboxIput=$(this).children('input');
	jQuery.each(checkboxIput, function(e,b){
	     var title= $(this).attr('title');
	     var value=$(this).attr('value');
	     var checked=$(this).attr('checked');
	     if(checked!=undefined){
	     	className='on phpcn-icon-duoxuan';
	     }else{
	     	className='phpcn-icon-duoxuankuang';
	     }
	     dlStr+='<dd><i class="phpcn-icon '+className+'"></i><span>'+title+'</span></dd>';
	})
	$(this).append(dlStr+'</dl>');
})

//多选2按钮选中事件
$(document).on('click','.phpcn-form-checkbox2-dl dd',function(){	
	ddText=$(this).children('span').html();
	var allIput=$(this).parent().siblings('input');
	if($(this).children('i').is('.phpcn-icon-duoxuan')){
		jQuery.each(allIput, function(e,b){
			var title=$(this).attr('title');
			if(title==ddText){
				$(this).removeAttr('checked');
			}
		});
		$(this).children('i').removeClass('on');
		$(this).children('i').removeClass('phpcn-icon-duoxuan');
		$(this).children('i').addClass('phpcn-icon-duoxuankuang');
	}else{
		jQuery.each(allIput, function(e,b){
			var title=$(this).attr('title');
			if(title==ddText){
				$(this).attr('checked','checked');
			}
		});
		$(this).children('i').addClass('on');
		$(this).children('i').addClass('phpcn-icon-duoxuan');
		$(this).children('i').removeClass('phpcn-icon-duoxuankuang');
	}
});
//多选菜单生成
var checkbox= $('.phpcn-form-checkbox');
jQuery.each(checkbox, function(e,b){
	dlStr='<dl class="phpcn-form-checkbox-dl">';
	var checkboxIput=$(this).children('input');
	jQuery.each(checkboxIput, function(e,b){
	     var title= $(this).attr('title');
	     var value=$(this).attr('value');
	     var checked=$(this).attr('checked');
	     var disabled=$(this).attr('disabled');

	     if(disabled == undefined){
		     if(checked!=undefined){
		     	checked='class="on"';
		     	color='phpcn-color-green';
		     }else{
		     	checked='';
		     	color='';
		     }
		     disabled_point = '';
	 	 }else{
	 	 	 disabled_point = 'class="php-disableds"';
	 	 	 checked='';
	     	 color='';
	 	 }
	     dlStr+='<dd '+disabled_point+'><span '+checked+'>'+title+'</span><i class="phpcn-icon phpcn-icon-duigoux '+color+'"></i></dd>';
	})
	$(this).append(dlStr+'</dl>');
})


//多选按钮选中事件
$('.phpcn-form-checkbox-dl dd:not(".php-disableds")').click(function(){
	ddText=$(this).children('span').html();
	var allIput=$(this).parent().siblings('input');
	if($(this).children('span').attr('class')!='on'){
		jQuery.each(allIput, function(e,b){
			var title=$(this).attr('title');
			if(title==ddText){
				$(this).attr('checked','checked');
			}
		});
		$(this).children('span').addClass('on');
		$(this).children('i').addClass('phpcn-color-green');

	}else{
		jQuery.each(allIput, function(e,b){
			var title=$(this).attr('title');
			if(title==ddText){
				$(this).removeAttr('checked','checked');
			}
		});
		$(this).children('span').removeClass('on');
		$(this).children('i').removeClass('phpcn-color-green');
	}
	
});
//多选按钮选中事件结束

//下拉菜单DL生成
var selectLength= $('.phpcn-form-select select');
jQuery.each(selectLength, function(e,b){
	var phpcnformselect = $(this).children('option');
	var html="<i class='phpcn-icon phpcn-icon-xiajiantou'></i>";
	html+="<dl class='phpcn-form-hide'>";
	var inputs,this_value='请选择',input;
	html += "<dd phpcn-value='' class='phpcn-select-tips'>请选择</dd>";
	jQuery.each(phpcnformselect, function(){
	 	var inputName= $('.phpcn-form-select select').attr('name');
	    var option= $(this).attr('value');
	    var selected= $(this).attr('selected');
	    
	    var text= $(this).html();
	    if(selected!=undefined){
	    	selected="class='on'";
	    	input= $(this).attr('value');
	    	this_value = $(this).html();
	    }else{
	    	selected="";
	    }
	    html += "<dd phpcn-value="+option+" "+selected+">"+text+"</dd>";
	});
	html=html+"</dl>";
    inputs='<input type="text" placeholder="'+this_value+'" value="'+this_value+'" readonly="" class="phpcn-input">';
	$(this).parent().append(html);
	$(this).parent().append(inputs);
});
var progress = $('.phpcn-progress .phpcn-row');
//下拉菜单生成结束 

//下拉菜单点事件
$(document).on('click','.phpcn-form-select',function(event){
	event.stopPropagation();
	if($(this).is('.is_show')){
		$('.phpcn-form-select').find('i').addClass('phpcn-icon-xiajiantou').removeClass('phpcn-icon-shangjiantou');
		$('.phpcn-form-select').removeClass('is_show').find('dl.phpcn-form-hide').hide();
	}else{
		$('.phpcn-form-select').find('i').addClass('phpcn-icon-xiajiantou').removeClass('phpcn-icon-shangjiantou');
		$('.phpcn-form-select').removeClass('is_show').find('dl.phpcn-form-hide').hide();
		$(this).find('i').removeClass('phpcn-icon-xiajiantou').addClass('phpcn-icon-shangjiantou');
		$(this).addClass('is_show').find('dl.phpcn-form-hide').show();
	}
});
$(document).click(function(){
	if($(this).find('i').is('.phpcn-icon-shangjiantou')){
		$(this).find('i').addClass('phpcn-icon-xiajiantou').removeClass('phpcn-icon-shangjiantou');
		$('.phpcn-form-hide').hide();
	}
});
//下拉菜单选择事件
$(document).on('click','.phpcn-form-hide dd',function(){
	//获取value值
	value=$(this).attr('phpcn-value');
	//获取DD的内容
	var text =$(this).html();
	//修改input显示的内容 
	$(this).parent().siblings('input').attr('value',text);

	//返回父级元素，并找到父级元素的同级元素下的SELECT
	var select=$(this).parent().siblings('select').children('option');
     //遍历所有的option 去除选中，并重新设置selected
	jQuery.each(select, function(){
		$(this).removeAttr('selected');
		if($(this).attr('value')==value){
			$(this).attr('selected','selected');
			var id = $(this).data('id');
			if($("#con_"+id).length>0){
				$("#con_"+id).hide();
				$("#sele_"+id).remove();
				$("#button_"+id).remove();
				$("#create_"+id).remove();
			}else{
				$("#sele_"+id).remove();
				$("#button_"+id).remove();
				$("#create_"+id).remove();
			}
			if($(this).data('select') == 'input'){
				var html = '<div class="phpcn-input-block" id="sele_'+id+'">';
				html += '	<input type="text" class="phpcn-input" name="" placeholder="请输入">';
				html += '</div>';
				$("#"+id).before(html);
			}
			if($(this).data('select') == 'textarea'){
				var html = '<div class="phpcn-input-block" id="sele_'+id+'">';
				html += '	<textarea class="phpcn-input" name=""></textarea>';
				html += '</div>';
				$("#"+id).before(html);
			}
			if($(this).data('select') == 'radio'){
				var ids = $(this).data('ids');
				var name = ids.split('-');
				var html = '<div class="phpcn-input-block" id="create_'+id+'">';
				html += '	<input type="text" class="phpcn-input" name="'+name[0]+'['+name[1]+'][field_value]" value="" placeholder="格式：1:开启,0:关闭,2:待审核">';
				html += '</div>';
				html += '<div class="phpcn-input-block" id="button_'+id+'">';
				html += '<button type="button" class="phpcn-button" onclick="create(\''+id+'\',\'radio\')">生成</button>';
				html += '</div>';
				$("#"+id).after(html);
			}
			if($(this).data('select') == 'checkbox'){
				var ids = $(this).data('ids');
				var name = ids.split('-');
				var html = '<div class="phpcn-input-block" id="create_'+id+'">';
				html += '	<input type="text" class="phpcn-input" name="'+name[0]+'['+name[1]+'][field_value]" value="" placeholder="格式：1:开启,0:关闭,2:待审核">';
				html += '</div>';
				html += '<div class="phpcn-input-block" id="button_'+id+'">';
				html += '<button type="button" class="phpcn-button" onclick="create(\''+id+'\',\'checkbox\')">生成</button>';
				html += '</div>';
				$("#"+id).after(html);
			}
			if($(this).data('select') == 'select'){
				var ids = $(this).data('ids');
				var name = ids.split('-');
				var html = '<div class="phpcn-input-block" id="create_'+id+'">';
				html += '	<input type="text" class="phpcn-input" name="'+name[0]+'['+name[1]+'][field_value]" value="" placeholder="格式：1:开启,0:关闭,2:待审核">';
				html += '</div>';
				html += '<div class="phpcn-input-block" id="button_'+id+'">';
				html += '<button type="button" class="phpcn-button" onclick="create(\''+id+'\',\'select\')">生成</button>';
				html += '</div>';
				$("#"+id).after(html);
			}
			if($(this).data('select') == 'upload'){
				var html = '<div class="phpcn-input-block" id="sele_'+id+'">';
				html += '	<button class="phpcn-button" type="button" onclick="$(\'#file_upload\').click();">上传LOGO图片</button>';
				html += '	<img id="pre_img" src="" style="height:38px;" onmouseover="show_img()" onmouseleave="hide_img()" />';
				html += '	<span style="color gray;">图片格式为PNG/JPG/GIF</span>';
				html += '	<iframe name="frame'+id+'" id="frame1" style="display:none;"></iframe>';
				html += '	<input type="hidden" name="" id="imgurl" value="">';
				html += '</div>';
				$("#"+id).before(html);
			}
			if($(this).data('select') == 'ruchtext'){
				if($("#con_"+id).length>0){
					$("#con_"+id).show();
				}else{
					var html = '<div class="phpcn-input-block" id="con_'+id+'">';
					html += '	<textarea class="phpcn-input" name="" id="content'+id+'"></textarea>';
					html += '</div>';
					$("#"+id).before(html);
					init_editor('content'+id);
				}
			}
		}
	});
	$('.phpcn-form-hide').hide();
});

jQuery.each(progress, function(){
     $(this).find('.phpcn-progress-bor').css('width',$(this).find('.phpcn-progress-percent').html());
});

$('.phpcn-dl dl').last().css('border-bottom','1px solid #C9C9C9');
$('#admin-select').mouseover(function(){
	$(this).find('dl').show();
});
$('#admin-select').mouseout(function(){
	$(this).find('dl').hide();
});
$('.phpcn-button').mouseover(function(){
	$(this).addClass('phpcn-button-hover');
 });
$('.phpcn-button').mouseout(function(){
	$(this).removeClass('phpcn-button-hover');
});
$('.tree').css('min-height',$(document).height()-160);

$(document).on('click','.tree li',function(){
	$('.tree li').find('i').removeClass('phpcn-icon-up').addClass('phpcn-icon-down');
	$('.tree li').find('dl').hide();

	if(!$(this).is('.is_show')){
		$(this).find('i').removeClass('phpcn-icon-down').addClass('phpcn-icon-up');
		$(this).find('dl').fadeIn();
		$('.tree li').removeClass('is_show');
		$(this).addClass('is_show');
	}else{
		$('.tree li').removeClass('is_show');
	}
});

//table窗口
$(document).on('click','.tree li a',function(){
	var tabs = $('.phpcn-tab-title dd a');
	var that = $(this);
	var arr = [];
	jQuery.each(tabs, function(){
		arr.push($(this).attr('data'));
	});
	if(arr.indexOf(that.attr('data')) <= 0){
		$('.phpcn-tab-title li').removeClass('on');
		//待删除
		$('.phpcn-tab-title li').remove();

		var tabs=$('.phpcn-tab-title ul');
		// var html='<li class="on"><i></i><dd>'+that.html()+' <a class="phpcn-icon phpcn-icon-guanbi" data='+that.attr('data')+' href="javascript:;"></a></dd></li>';
		var html='<li class="on"><i></i><dd>'+that.html()+' <a class="phpcn-icon phpcn-hide-sm" data='+that.attr('data')+' href="javascript:;"></a></dd></li>';
		tabs.append(html);
		 return false;
	}
});
//table窗口
$(document).on('click','.phpcn-tab-title .phpcn-icon-guanbi',function(){
	if($(this).parent().parent('li').next().length == 0 && $(this).parent().parent('li').prev().length == 0){
		return false;
	}
	if($(this).parent().parent('li').next().length == 0){
		$(this).parent().parent('li').prev('li').addClass('on');
	}
	if($(this).parent().parent('li').prev().length == 0){
		$(this).parent().parent('li').next('li').addClass('on');
	}	
	$(this).parent().parent('li').remove();
});
$(document).on('click','.tree li dl a',function(event){
    event.stopPropagation();
});

$('.phpcn-tab-title').find('li').mouseover(function(){
	var i=$(this).find('i');
	$('.phpcn-tab-title').find('li').find('i').css('width','0%');
	if($(this).css('background')!='#f6f6f6'){
		$('.phpcn-tab-title').find('li').css('background','none');
		$(this).css('background','#f6f6f6');
	}
	if(i.css('width')!='100%'){
		i.css('width','100%');
	}
});

$('.url_rule').find(".phpcn-form-radio-dl dd").click(function(){
	var this_val = $(this).find('span').text();
	$(this).parents('.url_rule').find('.phpcn-width300').val(this_val);
});
});
function keydown_remove(data){
    $(data).parents('.phpcn-form-item').find('input').removeAttr('checked');
    if($(data).parents('.phpcn-form-item').find('i').is('.phpcn-icon-plus-radio')){
    	$(data).parents('.phpcn-form-item').find('i').removeClass('on').removeClass('phpcn-icon-plus-radio').addClass('phpcn-icon-danxuan1');
    }
}