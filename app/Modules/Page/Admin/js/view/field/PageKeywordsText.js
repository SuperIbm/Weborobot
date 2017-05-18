Ext.define('Page.view.field.PageKeywordsText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Page.view.field.PageKeywordsText",
	
	fieldLabel: "Ключевые слова:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "keywords",
	reference: "keywords",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 0, 1000) == false)
			return "Ключевые слова должны содержать до 1000 символов!";
			else return true;
		}
	}
);
	