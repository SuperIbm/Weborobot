Ext.define('User.view.field.UserAccountOrganFormaText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountOrganFormaText",
	
	fieldLabel: "Организационная форма:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "organForma",
	ref: "organForma",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 10) == false)
			return "Организационная форма должна содержать не более 10 символов!";
			else return true;
		}
	}
);
	