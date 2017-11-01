// Подгрузим саму библиотеку
var elems = document.getElementsByTagName("BASE");
window.CKEDITOR_BASEPATH = elems[0].href + "bower_modules/ckeditor/";

Ext.Loader.loadScript
(
	{
	url: "bower_modules/ckeditor/ckeditor.js"
	}
);


// Определим сам класс
Ext.define("Admin.view.ux.CKEditor",
	{
	extend: 'Ext.form.field.TextArea',
	xtype: 'ckeditor',
	alias: 'widget.ckeditor',
	
		listeners:
		{
			destroy: function(ct)
			{
			ct.destroyInstance();	
			}
		},
		onRender: function(ct, position)
		{		
			if(!this.el)
			{
				this.defaultAutoCreate = 
				{
				tag: "textarea",
				autocomplete: "off"
				};
			}

		var value = this.valueForAdd == undefined ? '&nbsp;' : this.valueForAdd;
		Ext.form.TextArea.superclass.onRender.call(this, ct, position);
		
		var elems = document.getElementsByTagName("BASE");
		var baseHref = elems[0].href;
		
		var dateNow = new Date();
		var timeStamp = dateNow.getTime();
		
			if(!this.config.CKConfig)
			{
				this.config.CKConfig =
				{
				bodyClass: this.bodyClass == undefined ? "CONTENT" : this.bodyClass,
				contentsCss: baseHref + this.contentsCss + "?" + timeStamp,
				baseHref: baseHref
				};
			}
			
		CKEDITOR.config.showBaseInPathToObject = this.showBaseInPathToObject == undefined ? false : this.showBaseInPathToObject;
        CKEDITOR.basePath = baseHref + "bower_modules/ckeditor/";
        CKEDITOR.base = baseHref;

        var extraPlugins = (CKEDITOR.config.extraPlugins ? ',module' : 'module');
        extraPlugins += (extraPlugins ? ',typograph' : 'typograph');
        extraPlugins += (extraPlugins ? ',imap' : 'imap');
        extraPlugins += (extraPlugins ? ',youtube' : 'youtube');
        extraPlugins += (extraPlugins ? ',codemirror' : 'codemirror');
        extraPlugins += (extraPlugins ? ',video' : 'video');
        extraPlugins += (extraPlugins ? ',gallery' : 'gallery');
			
			var defConfig = 
			{
			resize_enabled: false,
				on:
				{
					"instanceReady": function(evt)
					{
					evt.editor.resize((evt.editor.element.$.style.width ? evt.editor.element.$.style : "100%"), parseInt(evt.editor.element.$.style.height));
					evt.editor.is_instance_ready = true;
					}
				},

            extraPlugins: extraPlugins,
			showBaseInPathToObject: CKEDITOR.config.showBaseInPathToObject,

            filebrowserBrowseUrl: CKEDITOR.base + 'vendor/richardfan1126/kcfinder/browse.php?opener=ckeditor&type=files',
            filebrowserImageBrowseUrl: CKEDITOR.base + 'vendor/richardfan1126/kcfinder/browse.php?opener=ckeditor&type=images',
            filebrowserFlashBrowseUrl: CKEDITOR.base + 'vendor/richardfan1126/kcfinder/browse.php?opener=ckeditor&type=flash',
            filebrowserUploadUrl: CKEDITOR.base + 'vendor/richardfan1126/kcfinder/upload.php?opener=ckeditor&type=files',
            filebrowserImageUploadUrl: CKEDITOR.base + 'vendor/richardfan1126/kcfinder/upload.php?opener=ckeditor&type=images',
            filebrowserFlashUploadUrl: CKEDITOR.base + 'vendor/richardfan1126/kcfinder/upload.php?opener=ckeditor&type=flash',

            templates_files: [CKEDITOR.basePath + "templates.js"],

            language: 'ru',
            skin: "Moono_blue",
            forcePasteAsPlainText: false,
            templates_replaceContent: false,
            format_tags: 'p;div;h1;h2;h3;h4;h5',
            entities: false,
            toolbar: 'MyToolbarAll',
            fillEmptyBlocks: false,
            baseFloatZIndex: 100000,
            disableNativeSpellChecker: false,

                allowedContent:
                {
                    $1:
                    {
                    elements: CKEDITOR.dtd,
                    attributes: true,
                    styles: true,
                    classes: true
                    }
                },

            disallowedContent: 'img{width,height}',

            toolbar_MyToolbarAll:
                [
                    { name: 'document', items : [ 'Source', '-','Preview','-','Templates','-','module' ] },
                    { name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
                    { name: 'editing', items : [ 'Find','Replace','-','SelectAll' ] },
                    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat','-', 'typograph' ] },
                    '/',
                    { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
                    { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                    { name: 'insert', items : [ 'Image','Flash','Table','SpecialChar', 'Imap', 'Youtube', 'Video', 'gallery' ] },
                    { name: 'styles', items : [ 'Format', 'Styles' ] },
                    { name: 'tools', items : [ 'Maximize', 'ShowBlocks' ] }
                ],

            gallery_default_img_resize_width: 800,
            gallery_default_img_resize_height: 0,

            gallery_default_thumb_resize_width: 200,
            gallery_default_thumb_resize_height: 0,

                gallery_template:
                '<div class="item">' +
                    '<a rel="{SET_ID}" href="{IMAGE}" target="_inBox">' +
                        '<img src="{PREVIEW}" />' +
                    '</a>' +
                '</div>',

            gallery_template_wrap: '<div class="gallery" data-id="{SET_ID}">{ITEMS}</div>'
			};

		Ext.apply(this.config.CKConfig, defConfig);
		CKEDITOR.replace(this.id, this.config.CKConfig);
		CKEDITOR.instances[this.id].setData(value);
		
			CKEDITOR.editor.prototype.getSelectedHtml = function()
			{
			var selection = this.getSelection();
				
				if(selection)
				{
				var bookmarks = selection.createBookmarks(),
				range = selection.getRanges()[0],
				fragment = range.clone().cloneContents();
				
				selection.selectBookmarks(bookmarks);
				var retval = "",
				childList = fragment.getChildren(),
				childCount = childList.count();
			
					for(var i = 0; i < childCount; i++)
					{
					var child = childList.getItem(i);
					retval += (child.getOuterHtml ? child.getOuterHtml() : child.getText());
					}
				
				return retval;
				}
			};
		},
		onResize: function(width, height)
		{
		Ext.form.TextArea.superclass.onResize.call(this, width, height);    	
			
			if(CKEDITOR.instances[this.id].is_instance_ready)
			{
			CKEDITOR.instances[this.id].resize(width, height);
			}		
		},
		setValue:function(value)
		{		
			if(!value) value = '&nbsp;';
			
		this.valueForAdd = value;			
		Ext.form.TextArea.superclass.setValue.apply(this, arguments);

			if(CKEDITOR.instances[this.id])
			{
			CKEDITOR.instances[this.id].setData(value);
			}

		},
		getValue:function()
		{					
			if(CKEDITOR.instances[this.id])
			{			
			return CKEDITOR.instances[this.id].getData();	
			}
			else return null;
		},
		getRawValue:function()
		{
		return this.getValue();
		},
		destroyInstance: function()
		{
			if(CKEDITOR.instances[this.id])
			{
			delete CKEDITOR.instances[this.id];
			}
		},
		insertHtml: function(value)
		{
		CKEDITOR.instances[this.id].insertHtml(value);
		}
	}
);