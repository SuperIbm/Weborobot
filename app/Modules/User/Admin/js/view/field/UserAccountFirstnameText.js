Ext.define('User.view.field.UserAccountFirstnameText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountFirstnameText",
	
	fieldLabel: "Имя:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "firstname",
	reference: "firstname",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 150) == false)
			return "Имя должно содержать не более 150 символов!";
			else return true;
		}
	}
);
	