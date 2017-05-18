Ext.define('PageTemplate.view.PageTemplateUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.PageTemplate.view.PageTemplateUpdateWindow',
		
		requires:
		[
		"PageTemplate.view.PageTemplateUpdateForm"
		],
	
	name: "PageTemplate",
	title: "Изменить шаблон",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 495,
	height: 280,
	
	modal: true,
		
		items:
		[
			{
			xtype: "PageTemplate.view.PageTemplateUpdateForm"
			}
		],
		fbar:
		[
			{	
			xtype: "button",
			text: "Изменить",
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