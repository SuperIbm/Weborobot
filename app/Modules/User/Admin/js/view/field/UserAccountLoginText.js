Ext.define('User.view.field.UserAccountLoginText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountLoginText",
	
	fieldLabel: "Логин:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "login",
	reference: "login",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 4, 100) == false)
			return "Логин должен содержать от 4 до 100 символов!";
			else return true;
		}
	}
);
	