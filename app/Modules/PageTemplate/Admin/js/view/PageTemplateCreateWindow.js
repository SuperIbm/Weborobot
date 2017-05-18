Ext.define('PageTemplate.view.PageTemplateCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.PageTemplate.view.PageTemplateCreateWindow',
		
		requires:
		[
		"PageTemplate.view.PageTemplateCreateForm"
		],
	
	name: "PageTemplate",
	title: "Добавить шаблон",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 495,
	height: 280,
	
	modal: true,
		
		items:
		[
			{
			xtype: "PageTemplate.view.PageTemplateCreateForm"
			}
		],
		fbar:
		[
			{	
			xtype: "button",
			text: "Добавить",
			action: "send"
			},
			{	
			xtype: "button",
			text: "Очистить",
			action: "reset"
			},
			{	
			xtype: "button",
			text: "Отменить",
			action: "cancel"
			}
		]
	}
);