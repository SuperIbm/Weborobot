Ext.define('PageTemplate.view.field.PageTemplateImageFile', 
	{
    extend: 'Ext.form.field.File',
	xtype: "PageTemplate.view.field.PageTemplateImageFile",
	
	fieldLabel: "Изображение шаблона:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "image",
	reference: "image",
	
	msgTarget: 'side'	
	}
);
	