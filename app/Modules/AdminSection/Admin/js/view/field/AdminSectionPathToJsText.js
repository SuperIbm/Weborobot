Ext.define('AdminSection.view.field.AdminSectionPathToJsText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "AdminSection.view.field.AdminSectionPathToJsText",
	
	fieldLabel: "Путь к JavaScript:<span class='needsForm'>*</span>",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "pathToJs",
	reference: "pathToJs",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 255) == false)
			return "Путь к JavaScript файлу должен быть определен.";
			else return true;
		}
	}
);
	