Ext.define('User.view.field.UserAccountOrganNameText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountOrganNameText",
	
	fieldLabel: "Название организации:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "organName",
	ref: "organName",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 250) == false)
			return "Название организации должна содержать не более 250 символов!";
			else return true;
		}
	}
);
	