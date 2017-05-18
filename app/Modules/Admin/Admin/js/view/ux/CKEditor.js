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
			
			var defConfig = 
			{
			resize_enabled : false,
				on:
				{
					"instanceReady": function(evt)
					{
					evt.editor.resize((evt.editor.element.$.style.width ? evt.editor.element.$.style : "100%"), parseInt(evt.editor.element.$.style.height));
					evt.editor.is_instance_ready = true;
					}
				},
				
			showBaseInPathToObject: CKEDITOR.config.showBaseInPathToObject
			};

		Ext.apply(this.config.CKConfig, defConfig);
		
		CKEDITOR.basePath = baseHref + "bower_modules/ckeditor/";
        CKEDITOR.base = baseHref;
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