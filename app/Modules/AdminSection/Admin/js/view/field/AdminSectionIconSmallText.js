Ext.define('AdminSection.view.field.AdminSectionIconSmallText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "AdminSection.view.field.AdminSectionIconSmallText",
	
	fieldLabel: "Иконка маленькая:",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "iconSmall",
	reference: "iconSmall",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 255) == false)
			return "Путь к маленькой иконке должен быть не длинее 255 символов.";
			else return true;
		}
	}
);
	