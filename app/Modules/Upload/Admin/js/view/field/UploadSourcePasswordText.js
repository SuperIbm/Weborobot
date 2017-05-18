Ext.define('Upload.view.field.UploadSourcePasswordText',
	{
    extend: 'Admin.view.ux.TriggerFieldGeneratePassword',
	xtype: "Upload.view.field.UploadSourcePasswordText",
	
	fieldLabel: "Пароль:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "password",
	reference: "password",
	
	msgTarget: 'side',
	
		validator: function(value)
		{	
						
			if(Weborobot.Util.isLength(value, 0, 150) == false)
			return "Пароль должен содержать до 150 символов!";
			else return true;
		}
	}
);
	