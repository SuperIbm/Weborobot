Ext.define('User.view.field.UserAccountStreetText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountStreetText",
	
	fieldLabel: "Адрес:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "street",
	ref: "street",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 200) == false)
			return "Адрес должен содержать не более 200 символов!";
			else return true;
		}
	}
);
	