Ext.define('User.view.field.UserAccountPasswordTriggerFieldGeneratePassword',
	{
    extend: 'Admin.view.ux.TriggerFieldGeneratePassword',
	xtype: "User.view.field.UserAccountPasswordTriggerFieldGeneratePassword",
	
	fieldLabel: "Пароль:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "password",
	reference: "password",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 6, 25) == false)
			return "Пароль должен содержать от 6 до 25 символов!";
			else return true;							
		}
	}
);
	