Ext.define('Admin.view.ux.LinkPicker',
	{
    extend: 'Ext.form.field.Text',
	xtype: 'linkpicker',
	alias: 'widget.linkpicker',
	
	editable: true,
	
		triggers:
		{
			searcher:
			{
			cls: 'x-form-select-trigger',			
				handler: function()	
				{
				var thisObj = this;
				
					var params = 
					{
					menubar: false,
					toolbar: false,
					directories: false,
					status: false,
					resizable: true,
					scrollbars: false,
					width: 990,
					height: 600,
					left: (window.innerWidth - 990) / 2,
					top: (window.innerHeight - 600) / 2
					};
				
				var paramsStr = "";
					
					for(k in params)
					{
						if(paramsStr != "") paramsStr += ",";
						
						if(params[k] === true) params[k] = "yes";
						else if(params[k] === false) params[k] = "no";
					
					paramsStr += k + "=" + params[k];
					}
				
				var base = $("BASE").attr("href");
				var newWin = window.open(base + "ckeditor/ckfinder/ckfinder.html?langCode=ru&action=js&func=setUrl", "LinkPickerWindow", paramsStr);	
				newWin.focus();
				
					window.setUrl = function(url)
					{
					thisObj.setValue(url);
					}
				}
			}
		}
	}
);