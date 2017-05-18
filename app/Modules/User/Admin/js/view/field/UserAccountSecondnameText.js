Ext.define('User.view.field.UserAccountSecondnameText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountSecondnameText",
	
	fieldLabel: "Фамилия:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "secondname",
	reference: "secondname",
	
	msgTarget: 'side',
	
	invalidText: "Фамилия должна содержать не более 150 символов!",
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 150) == false)
			return "Фамилия должна содержать не более 150 символов!";
			else return true;
		}
	}
);
	