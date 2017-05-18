Ext.define('User.view.field.UserAccountIcqText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountIcqText",
	
	fieldLabel: "ICQ:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "icq",
	reference: "icq",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 15) == false)
			return "Проверьте корректность введенного ICQ!";
			else return true;
		}
	}
);
	