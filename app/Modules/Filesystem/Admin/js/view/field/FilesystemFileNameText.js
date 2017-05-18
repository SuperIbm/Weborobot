Ext.define('Filesystem.view.field.FilesystemFileNameText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Filesystem.view.field.FilesystemFileNameText",
	
	fieldLabel: "Название файла:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "nameFull",
	reference: "nameFull",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 255) == false)
			return "Название файла должно содержать до 255 символов!";
			else return true;
		}
	}
);
	