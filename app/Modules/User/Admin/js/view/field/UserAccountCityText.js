Ext.define('User.view.field.UserAccountCityText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountCityText",
	
	fieldLabel: "Город:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "city",
	ref: "city",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 200) == false)
			return "Город должен содержать не более 200 символов!";
			else return true;
		}
	}
);
	