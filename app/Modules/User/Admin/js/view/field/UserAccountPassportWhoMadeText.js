Ext.define('User.view.field.UserAccountPassportWhoMadeText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountPassportWhoMadeText",
	
	fieldLabel: "Кем выдан:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "passportWhoMade",
	ref: "passportWhoMade",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 250) == false)
			return "Кем выдан должен содержать не более 250 символов!";
			else return true;
		}
	}
);
	