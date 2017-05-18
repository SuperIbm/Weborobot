Ext.define('Widget.view.field.WidgetPathToJsText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Widget.view.field.WidgetPathToJsText",
	
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
	