Ext.define('User.view.field.UserAccountPassportAdressText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountPassportAdressText",
	
	fieldLabel: "Адрес прописки:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "passportAdress",
	ref: "passportAdress",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 255) == false)
			return "Адрес прописки должен содержать не более 255 символов!";
			else return true;
		}
	}
);
	