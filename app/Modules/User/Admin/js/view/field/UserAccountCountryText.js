Ext.define('User.view.field.UserAccountCountryText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountCountryText",
	
	fieldLabel: "Страна:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "country",
	ref: "country",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 200) == false)
			return "Страна должна содержать не более 200 символов!";
			else return true;
		}
	}
);
	