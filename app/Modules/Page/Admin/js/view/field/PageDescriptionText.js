Ext.define('Page.view.field.PageDescriptionText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Page.view.field.PageDescriptionText",
	
	fieldLabel: "Описание:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "description",
	reference: "description",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 0, 1000) == false)
			return "Описание должно содержать до 1000 символов!";
			else return true;
		}
	}
);
	