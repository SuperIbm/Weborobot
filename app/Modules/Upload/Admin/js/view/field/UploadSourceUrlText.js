Ext.define('Upload.view.field.UploadSourceUrlText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Upload.view.field.UploadSourceUrlText",
	
	fieldLabel: "Путь к источнику:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "url",
	reference: "url",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isUrl(value, true) == false)
			return "источник должен содержать ссылку!";
			else return true;
		}
	}
);
	