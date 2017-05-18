Ext.define('Page.view.field.PageNamePageText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Page.view.field.PageNamePageText",
	
	fieldLabel: "Название страницы:<span class='needsForm'>*</span>",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "namePage",
	reference: "namePage",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 1, 255) == false)
			return "Название страницы должно содержать от 1 до 255 символов!";
			else return true;
		}
	}
);
	