Ext.define('User.view.field.UserAccountPassportSeriaAndNumberText', 
	{
    extend: 'Admin.view.ux.TextMasked',
	xtype: "User.view.field.UserAccountPassportSeriaAndNumberText",
	
	fieldLabel: "Серия и номер:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "passportSeriaAndNumber",
	ref: "passportSeriaAndNumber",
	
	msgTarget: 'side',
	
	mask: "9999 999999",
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 11) == false)
			return "Серия и номер паспорта должна содержать не более 11 символов!";
			else return true;
		}
	}
);
	