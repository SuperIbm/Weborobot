Ext.define('User.view.field.UserAccountTelephoneText', 
	{
    extend: 'Admin.view.ux.TextMasked',
	xtype: "User.view.field.UserAccountTelephoneText",
	
	fieldLabel: "Телефон:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "telephone",
	reference: "telephone",
	
	msgTarget: 'side',
	mask: "+7 (999) 999-99-99",
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 18) == false)
			return "Телефон должен содержать не более 18 символов!";
			else return true;
		}
	}
);
	