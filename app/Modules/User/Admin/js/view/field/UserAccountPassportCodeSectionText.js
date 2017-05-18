Ext.define('User.view.field.UserAccountPassportCodeSectionText', 
	{
    extend: 'Admin.view.ux.TextMasked',
	xtype: "User.view.field.UserAccountPassportCodeSectionText",
	
	fieldLabel: "Код подразделения:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "passportCodeSection",
	ref: "passportCodeSection",
	
	msgTarget: 'side',
	
	mask: "999-999",
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 7) == false)
			return "Код подразделения должен содержать не более 7 символов!";
			else return true;
		}
	}
);
	