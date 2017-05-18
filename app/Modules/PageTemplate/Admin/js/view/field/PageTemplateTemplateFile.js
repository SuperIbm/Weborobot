Ext.define('PageTemplate.view.field.PageTemplateTemplateFile', 
	{
    extend: 'Ext.form.field.File',
	xtype: "PageTemplate.view.field.PageTemplateTemplateFile",
	
	fieldLabel: "Архив с шаблоном:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "template",
	reference: "template",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 1) == false)
			return "Путь к архиву шаблона должен быть определен! Допустимые форматы: *.zip";
			else return true;
		}
	}
);
	