Ext.define('Publication.view.field.PublicationAnonsTextarea', 
	{
    extend: 'Ext.form.field.TextArea',
	xtype: "Publication.view.field.PublicationAnonsTextarea",
	
	fieldLabel: "Анонс:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 700,
	height: 200,
	
	name: "anons",
	reference: "anons",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 1000) == false)
			return "Анонс должен быть длиной не более 1000 символов.";
			else return true;
		}
	}
);
	