Ext.define('Upload.view.field.UploadSourceLoginText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Upload.view.field.UploadSourceLoginText",
	
	fieldLabel: "Логин:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "login",
	reference: "login",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 100) == false)
			return "Логин должен содержать до 100 символов!";
			else return true;
		}
	}
);
	