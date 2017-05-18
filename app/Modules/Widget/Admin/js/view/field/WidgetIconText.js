Ext.define('Widget.view.field.WidgetIconText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Widget.view.field.WidgetIconText",
	
	fieldLabel: "Иконка:",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "icon",
	reference: "icon",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 255) == false)
			return "Путь к иконке должен быть не длинее 255 символов.";
			else return true;
		}
	}
);
	