Ext.define('PageTemplate.view.field.PageTemplateLabelTemplateText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "PageTemplate.view.field.PageTemplateLabelTemplateText",
	
	fieldLabel: "Название шаблона:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "labelTemplate",
	reference: "labelTemplate",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 1, 100) == false)
			return "Название шаблона должно содержать от 1 до 100 символов!";
			else return true;
		}
	}
);
	