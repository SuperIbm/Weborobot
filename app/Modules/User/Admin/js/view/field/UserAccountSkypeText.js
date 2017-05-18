Ext.define('User.view.field.UserAccountSkypeText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountSkypeText",
	
	fieldLabel: "Skype:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "skype",
	reference: "skype",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 150) == false)
			return "Проверьте корректность введенного skype адреса!";
			else return true;
		}
	}
);
	