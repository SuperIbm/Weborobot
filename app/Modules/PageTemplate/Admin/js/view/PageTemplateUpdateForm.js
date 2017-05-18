Ext.define('PageTemplate.view.PageTemplateUpdateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.PageTemplate.view.PageTemplateUpdateForm',
	
		requires:
		[
		"PageTemplate.view.field.PageTemplateLabelTemplateText",
		"PageTemplate.view.field.PageTemplateNameTemplateText",
		"PageTemplate.view.field.PageTemplateCountBlocksNumber",
		"PageTemplate.view.field.PageTemplateTemplateFile",
		"PageTemplate.view.field.PageTemplateImageFile"
		],
	
	name: "PageTemplate",
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			},
			{
			xtype: "PageTemplate.view.field.PageTemplateLabelTemplateText"
			},
			{
			xtype: "PageTemplate.view.field.PageTemplateNameTemplateText"
			},
			{
			xtype: "PageTemplate.view.field.PageTemplateCountBlocksNumber"
			},
			{
			xtype: "PageTemplate.view.field.PageTemplateTemplateFile",
			fieldLabel: "Архив с шаблоном:",
			validator: null	
			},
			{
			xtype: "PageTemplate.view.field.PageTemplateImageFile"
			}
		]
	}
);