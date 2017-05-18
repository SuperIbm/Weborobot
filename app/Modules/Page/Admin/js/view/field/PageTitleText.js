Ext.define('Page.view.field.PageTitleText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Page.view.field.PageTitleText",
	
	fieldLabel: "Загаловок:",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "title",
	reference: "titler",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 0, 255) == false)
			return "Загаловок должен содержать до 255 символов!";
			else return true;
		}
	}
);
	