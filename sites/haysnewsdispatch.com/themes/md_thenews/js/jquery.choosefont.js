/**
 * Megadrupal.com
 */

(function($) {
	$.fn.choosefont = function() {
		return this.each(function() {
			var self = $(this),
			id = self.attr('id'),
			inputhidden = 'input[name=' + id.replace(/-/g,"_") +']',
			fontfamilyval = "",
			fwchange = 1;

			// Restore from input
			data_arr = $(inputhidden).val().split('|');
			data_arr[0] = typeof data_arr[0] !== 'undefined' ? data_arr[0] : "0";
			if (!data_arr[0]) data_arr[0] = "0";
			data_arr[1] = typeof data_arr[1] !== 'undefined' ? data_arr[1] : "n4";
			data_arr[2] = typeof data_arr[2] !== 'undefined' ? data_arr[2] : "";
			data_arr[3] = typeof data_arr[3] !== 'undefined' ? data_arr[3] : "px";
			if (!Drupal.settings.font_vars[data_arr[0]]) {
				data_arr[0] = "1";
			}

			//Build HTML
			html = '<div class="form-font"><label>Font</label>';
			html += '<select id="'+id +'-fontfamily" class="form-select2">';
			$.each(Drupal.settings.font_array, function(key, value) {
				if (key == data_arr[0]) { _select = ' selected="selected"'} else { _select = '';}
				html += '<option'+_select+' value="'+key+'">'+value+'</option>';
			});
			html += '</select>';
			html += '<div id="fontweight-'+id+'" class="form-font-weight"></div>';
			html += '<div class="form-font-size"><input type="text" maxlength="128" size="60" value="'+data_arr[2]+'" id="'+id+'-fontsize" class="font-size form-text" /></div>';
			html += '<select id="'+id +'-sizetype" class="form-select2">';
			if (data_arr[3] == "em") {
				html += '<option value="px">px</option><option selected="selected" value="em">em</option>';
			} else {
				html += '<option value="px">px</option><option value="em">em</option>';
			}
			html += '</select></div>';

			self.prepend(html);

			fontfamilyval = data_arr[0];
			fontweight_html = '<select id="'+id +'-fontweight" class="form-select3">';
			fontweight_arr = Drupal.settings.font_vars[fontfamilyval].Weight.split(',');
			$.each(fontweight_arr, function(index, value) {
				optval = $.trim(value);
				if (optval == data_arr[1]) { _select = ' selected="selected"'} else { _select = '';}
				fontweight_html += '<option'+_select+' value="'+optval+'">'+_expandFontWeight(optval)+'</option>';
			});
			fontweight_html += '</select>';
			$('#fontweight-'+id).html(fontweight_html);
			$('#fontweight-'+id+' select').dropkick();

			$('.form-select2').dropkick();

			// Build preview
			self.next().addClass('withpreviewbtn').append('<div id="previewbtn-'+id+'" class="previewbtn"><a href="#">Preview</a></div>');
			self.parent().append('<div id="preview-'+id+'" class="textpreview"><div class="tp-textdemo">Grumpy wizards make toxic brew for the evil Queen and Jack.</div><a href="#" class="tp-close">Close preview</a></div>');
			$('#previewbtn-'+id+' a').click(function(){
				_updatePreview(id);
				$('#preview-'+id).show();
				$(this).text('Refresh').addClass('pbtn-refresh');
				return false;
			});

			$('#preview-'+id+' .tp-close').click(function(){
				$(this).parent().hide();
				$('#previewbtn-'+id+' a').text('Preview').removeClass('pbtn-refresh');;
				return false;
			});

			$('#dk_container_'+ id +'-fontfamily .dk_options_inner a').each(function(){
				$(this).click(function(){
					fontfamilyval = $(this).attr('data-dk-dropdown-value');
					fontweight_html = '<select id="'+id +'-fontweight" class="form-select3">';
					fontweight_arr = Drupal.settings.font_vars[fontfamilyval].Weight.split(',');
					$.each(fontweight_arr, function(index, value) {
						optval = $.trim(value);
						fontweight_html += '<option value="'+optval+'">'+_expandFontWeight(optval)+'</option>';
					});
					fontweight_html += '</select>';
					$('#fontweight-'+id).html(fontweight_html);
					$('#fontweight-'+id+' select').dropkick();
					fwchange = 1;
					_updateTextStyle(fontfamilyval)
				})
			});

			$('#dk_container_'+id +'-fontweight').live("mouseenter",function(){
				if (fwchange != 0) {
		      $(this).find('.dk_options_inner a').each(function(){
						$(this).click(function(){
							fontweightval = $(this).attr('data-dk-dropdown-value');
							fontfamilyval = $('#dk_container_'+ id +'-fontfamily .dk_option_current a').attr('data-dk-dropdown-value');
							_updateTextStyle(fontfamilyval,fontweightval)
						})
					})
					fwchange = 0;
				}
	    });

			$('#'+id+'-fontsize').bind("keydown", function(e) {
				if (e.keyCode == 13) {
					fontfamilyval = $('#dk_container_'+ id +'-fontfamily .dk_option_current a').attr('data-dk-dropdown-value');
					fontweightval = $('#dk_container_'+ id +'-fontweight .dk_option_current a').attr('data-dk-dropdown-value');
					fontsizeval = $(this).val();
					_updateTextStyle(fontfamilyval,fontweightval, fontsizeval);
					return false;
				}
			}).focusout(function() {
				fontfamilyval = $('#dk_container_'+ id +'-fontfamily .dk_option_current a').attr('data-dk-dropdown-value');
				fontweightval = $('#dk_container_'+ id +'-fontweight .dk_option_current a').attr('data-dk-dropdown-value');
				fontsizeval = $(this).val();
				_updateTextStyle(fontfamilyval,fontweightval, fontsizeval)
			})

			$('#dk_container_'+id +'-sizetype .dk_options_inner a').each(function(){
				$(this).click(function(){
					fontfamilyval = $('#dk_container_'+ id +'-fontfamily .dk_option_current a').attr('data-dk-dropdown-value');
					fontweightval = $('#dk_container_'+ id +'-fontweight .dk_option_current a').attr('data-dk-dropdown-value');
					fontsizeval = $('#'+id+'-fontsize').val();
					sizetypeval = $(this).attr('data-dk-dropdown-value');
					_updateTextStyle(fontfamilyval,fontweightval, fontsizeval, sizetypeval)
				})
	    });

  		// Functions
			function _updateTextStyle(_fontfamily, _fontweight, _fontsize, _sizetype) {
				_fontfamily = typeof _fontfamily !== 'undefined' ? _fontfamily : $('#dk_container_'+ id +'-fontfamily .dk_option_current a').attr('data-dk-dropdown-value');
				_fontweight = typeof _fontweight !== 'undefined' ? _fontweight : $('#dk_container_'+ id +'-fontweight .dk_option_current a').attr('data-dk-dropdown-value');
				_fontsize = typeof _fontsize !== 'undefined' ? _fontsize :  $('#'+id+'-fontsize').val();
				_sizetype = typeof _sizetype !== 'undefined' ? _sizetype : $('#dk_container_'+ id +'-sizetype .dk_option_current a').attr('data-dk-dropdown-value');

				_fontfamilydetail = Drupal.settings.font_vars[_fontfamily].CSS;
				$(inputhidden).val(_fontfamily + "|" + _fontweight + "|" + _fontsize + "|" + _sizetype + "|" + _fontfamilydetail)
			}

			function _updatePreview(id) {
				_fontfamily = $('#dk_container_'+ id +'-fontfamily .dk_option_current a').attr('data-dk-dropdown-value');
				_fontweight = $('#dk_container_'+ id +'-fontweight .dk_option_current a').attr('data-dk-dropdown-value');
				_fontsize = $('#'+id+'-fontsize').val();
				_sizetype = $('#dk_container_'+ id +'-sizetype .dk_option_current a').attr('data-dk-dropdown-value');
				_color = '#' + $('#'+id).next().find('input.form-colorpicker').val();
				_fontweightarr = _fontweight.split('');
				if (_fontweightarr[0] == "i") {_fontweightarr[0] = "italic"}
				else {_fontweightarr[0] = "normal"}

				_fontfamilydetail = Drupal.settings.font_vars[_fontfamily].CSS;
				$('#preview-'+id+' .tp-textdemo').css({
					'font-family': _fontfamilydetail,
					'font-weight': _fontweightarr[1] + "00",
					'font-style': _fontweightarr[0],
					'font-size': _fontsize + _sizetype,
					'color': _color
				})
			}

			function _expandFontWeight(fw, ept) {
				switch(fw) {
					case 'n1':
						fontExpand = "Thin";
				  	break;
					case 'i1':
						fontExpand = "Thin Italic";
						break;
					case 'n2':
						fontExpand = "Extra Light";
				  	break;
					case 'i2':
						fontExpand = "Extra Light Italic";
						break;
					case 'n3':
						fontExpand = "Light";
				  	break;
					case 'i3':
						fontExpand = "Light Italic";
						break;
					case 'n4':
						fontExpand = "Normal";
				  	break;
					case 'i4':
						fontExpand = "Italic";
						break;
					case 'n5':
						fontExpand = "Medium";
				  	break;
					case 'i5':
						fontExpand = "Medium Italic";
						break;
					case 'n6':
						fontExpand = "Semi Bold";
				  	break;
					case 'i6':
						fontExpand = "Semi Bold Italic";
						break;
					case 'n7':
						fontExpand = "Bold";
				  	break;
					case 'i7':
						fontExpand = "Bold Italic";
						break;
					case 'n8':
						fontExpand = "Extra Bold";
				  	break;
					case 'i8':
						fontExpand = "Extra Bold Italic";
						break;
					case 'n9':
						fontExpand = "Heavy";
				  	break;
					case 'i9':
						fontExpand = "Heavy Italic";
						break;
					default:
						fontExpand = "undefined";
				}

				return fontExpand;
			}

			$(document).bind('keydown', function (e) {

				var
	        $open    = $('.dk_container.dk_open'),
	        $focused = $('.dk_container.dk_focus'),
		      $dk = null;

	      // If we have an open dropdown, key events should get sent to that one
	      if ($open.length) {
	        $dk = $open;
	      } else if ($focused.length && !$open.length) {
	        // But if we have no open dropdowns, use the focused dropdown instead
	        $dk = $focused;
	      }

				if ((e.keyCode == 13) && $dk) {
					fontfamilyval = $('#dk_container_'+ id +'-fontfamily .dk_option_current a').attr('data-dk-dropdown-value');
					fontweightval = $('#dk_container_'+ id +'-fontweight .dk_option_current a').attr('data-dk-dropdown-value');
					fontsizeval = $('#'+id+'-fontsize').val();
					sizetypeval = $('#dk_container_'+ id +'-fontsize .dk_option_current a').attr('data-dk-dropdown-value');
					_updateTextStyle(fontfamilyval,fontweightval, fontsizeval, sizetypeval)
				}

			});

		});
	}
})(jQuery);