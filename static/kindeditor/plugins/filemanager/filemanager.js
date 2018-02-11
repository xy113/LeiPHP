/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('filemanager', function(K) {
	var self = this, name = 'filemanager',
		fileManagerJson = K.undef(self.fileManagerJson, self.basePath + 'php/file_manager_json.php'),
		imgPath = self.pluginsPath + name + '/images/',
		lang = self.lang(name + '.');
	function makeFileTitle(filename, filesize, datetime) {
		return filename + '(' + filesize + ',' + datetime + ')';
	}
	function bindTitle(el, data) {
		if (data.is_dir) {
			el.attr('title', data.filename);
		} else {
			el.attr('title', makeFileTitle(data.filename, data.filesize, data.datetime));
		}
	}
	self.plugin.filemanagerDialog = function(options) {
		var width = K.undef(options.width, 650),
			height = K.undef(options.height, 510),
			dirName = K.undef(options.dirName, ''),
			//viewType = K.undef(options.viewType, 'VIEW').toUpperCase(), // "LIST" or "VIEW"
			clickFn = options.clickFn;
		var html = [
			'<div style="padding:10px 20px;">',
			// header start
			'<div class="ke-plugin-filemanager-header">',
			// left start
			'<div class="ke-left">',
			'</div>',
			// right start
			'<div class="ke-right">',
			lang.orderType + ' <select class="ke-inline-block" name="orderType">',
			'<option value="NAME">' + lang.fileName + '</option>',
			'<option value="SIZE">' + lang.fileSize + '</option>',
			'<option value="TYPE">' + lang.fileType + '</option>',
			'</select>',
			'</div>',
			'<div class="ke-clearfix"></div>',
			'</div>',
			// body start
			'<div class="ke-plugin-filemanager-body"></div>',
			'</div>'
		].join('');
		var dialog = self.createDialog({
			name : name,
			width : width,
			height : height,
			title : self.lang(name),
			body : html
		}),
		div = dialog.div,
		albumid = 0,
		bodyDiv = K('.ke-plugin-filemanager-body', div),
		leftDiv = K('.ke-left', div),
		viewServerBtn = K('[name="viewServer"]', div),
		orderTypeBox = K('[name="orderType"]', div);
		K('.ke-dialog-footer', div).remove();
		function reloadPage(orderby) {
			var param = 'orderby=' + orderby + '&dir=' + dirName;
			if(dirName == 'image') param+= '&albumid='+albumid;
			dialog.showLoading(self.lang('ajaxLoading'));
			K.ajax(K.addParam(fileManagerJson, param + '&' + new Date().getTime()), function(data) {
				dialog.hideLoading();
				if(dirName == 'image'){
					createView(data);
				}else {
					createList(data);
				}
			});
		}
		function loadAlbum(){
			K.ajax(K.addParam(fileManagerJson, 'dir='+dirName+'&datatype=album&' + new Date().getTime()), function(data) {
				var albumList = '相册 <select class="ke-inline-block" name="albumid">';
				albumList+= '<option value="0">所有图片</option>';
				for (var i = 0, len = data.album_list.length; i < len; i++) {
					var album = data.album_list[i];
					albumList+= '<option value="'+album.albumid+'">' + album.title + '</option>';
				}
				albumList+= '</select>';
				leftDiv.html(albumList);
				var albumChoose = K('[name=albumid]', div);
				albumChoose.change(function(e){
					albumid = K(this).val();
					reloadPage(orderTypeBox.val());
				});
			});
		}
		var elList = [];
		function bindEvent(el, result, data) {
			if (data.isimage) {
				el.click(function(e) {
					clickFn.call(this, data.imageurl, data.filename);
				});
			} else {
				el.click(function(e) {
					clickFn.call(this, data.fileurl, data.filename);
				});
			}
			elList.push(el);
		}
		function createCommon(result) {
			// remove events
			K.each(elList, function() {
				this.unbind();
			});
			orderTypeBox.unbind();
			orderTypeBox.change(function(){
				reloadPage(orderTypeBox.val());
			});
			bodyDiv.html('');
		}
		function createList(result) {
			createCommon(result);
			var table = document.createElement('table');
			table.className = 'ke-table';
			table.cellPadding = 0;
			table.cellSpacing = 0;
			table.border = 0;
			bodyDiv.append(table);
			var fileList = result.file_list;
			for (var i = 0, len = fileList.length; i < len; i++) {
				var data = fileList[i], row = K(table.insertRow(i));
				row.mouseover(function(e) {
					K(this).addClass('ke-on');
				})
				.mouseout(function(e) {
					K(this).removeClass('ke-on');
				});
				var iconUrl = imgPath + 'file-16.gif',
					img = K('<img src="' + iconUrl + '" width="16" height="16" alt="' + data.filename + '" align="absmiddle" />'),
					cell0 = K(row[0].insertCell(0)).addClass('ke-cell ke-name').append(img).append(document.createTextNode(' ' + data.filename));
				row.css('cursor', 'pointer');
				cell0.attr('title', data.filename);
				bindEvent(cell0, result, data);
				K(row[0].insertCell(1)).addClass('ke-cell ke-size').html(data.filesize);
				K(row[0].insertCell(2)).addClass('ke-cell ke-datetime').html(data.datetime);
			}
		}
		function createView(result) {
			createCommon(result);
			var fileList = result.file_list;
			for (var i = 0, len = fileList.length; i < len; i++) {
				var data = fileList[i],
					div = K('<div class="ke-inline-block ke-item"></div>');
				bodyDiv.append(div);
				var photoDiv = K('<div class="ke-inline-block ke-photo"></div>')
					.mouseover(function(e) {
						K(this).addClass('ke-on');
					})
					.mouseout(function(e) {
						K(this).removeClass('ke-on');
					});
				div.append(photoDiv);
				var img = K('<img src="' + data.imageurl + '" width="84" height="84" alt="' + data.filename + '" />');
				photoDiv.css('cursor', 'pointer');
				bindTitle(photoDiv, data);
				bindEvent(photoDiv, result, data);
				photoDiv.append(img);
			}
		}
		reloadPage(orderTypeBox.val());
		if(dirName == 'image') loadAlbum();
		return dialog;
	}

});
