Ext.define('AdminSection.view.field.AdminSectionPathToCssText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "AdminSection.view.field.AdminSectionPathToCssText",
	
	fieldLabel: "Путь к CSS:",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "pathToCss",
	reference: "pathToCss",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 255) == false)
			return "Путь к CSS файлу должен быть длиной не более 255 символов!";
			else return true;
		}
	}
);
	