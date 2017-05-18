Ext.define('User.view.field.UserAccountZipText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountZipText",
	
	fieldLabel: "Индекс:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "zip",
	ref: "zip",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 20) == false)
			return "Индекс должен содержать не более 20 символов!";
			else return true;
		}
	}
);
	