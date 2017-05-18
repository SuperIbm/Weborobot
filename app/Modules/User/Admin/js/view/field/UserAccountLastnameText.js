Ext.define('User.view.field.UserAccountLastnameText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountLastnameText",
	
	fieldLabel: "Отчество:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "lastname",
	reference: "lastname",
	
	msgTarget: 'side',
	
	invalidText: "Отчество должно содержать не более 150 символов!",
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 150) == false)
			return "Отчество должно содержать не более 150 символов!";
			else return true;
		}
	}
);
	