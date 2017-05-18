Ext.define('Alias.view.field.AliasPatternText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Alias.view.field.AliasPatternText",
	
	fieldLabel: "Паттерн:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "pattern",
	reference: "pattern",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 255) == false)
			return "Паттерн должно содержать от 1 до 255 символов!";
			else return true;
		}
	}
);
	