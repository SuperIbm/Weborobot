Ext.define('User.view.field.UserAccountOrganAboutTextArea', 
	{
    extend: 'Ext.form.field.TextArea',
	xtype: "User.view.field.UserAccountOrganAboutTextArea",
	
	fieldLabel: "Об организации:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	height: 150,
	
	name: "organAbout",
	ref: "organAbout",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 1000) == false)
			return "Информации об организации должна содержать не более 1000 символов!";
			else return true;
		}
	}
);
	