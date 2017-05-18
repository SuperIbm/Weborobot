Ext.define('AdminSection.view.field.AdminSectionIconBigText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "AdminSection.view.field.AdminSectionIconBigText",
	
	fieldLabel: "Иконка большая:",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "iconBig",
	reference: "iconBig",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 255) == false)
			return "Путь к большой иконке должен быть не длинее 255 символов.";
			else return true;
		}
	}
);
	