Ext.define('Filesystem.view.field.FilesystemDirNameText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Filesystem.view.field.FilesystemDirNameText",
	
	fieldLabel: "Название папки:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "name",
	reference: "name",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 255) == false)
			return "Название папки должно содержать от 1 до 255 символов!";
			else return true;
		}
	}
);
	