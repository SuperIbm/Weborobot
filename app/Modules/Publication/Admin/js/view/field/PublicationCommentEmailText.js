Ext.define('Publication.view.field.PublicationCommentEmailText',
	{
    extend: 'Ext.form.field.Text',
	xtype: "Publication.view.field.PublicationCommentEmailText",
	
	fieldLabel: "E-mail:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "email",
	reference: "email",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isEmail(value, false) == false)
			return "Проверьте корректность введенной электронной почты!";
			else return true;
		}
	}
);
	