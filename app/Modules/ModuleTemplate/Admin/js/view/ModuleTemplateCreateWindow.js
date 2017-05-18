Ext.define('ModuleTemplate.view.ModuleTemplateCreateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.ModuleTemplate.view.ModuleTemplateCreateWindow',
		
		requires:
		[
		"ModuleTemplate.view.ModuleTemplateCreateForm"
		],
	
	name: "ModuleTree",
	title: "Добавить шаблон модуля",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 900,
	height: 550,
	
	modal: true,
		
		items:
		[
			{
			xtype: "ModuleTemplate.view.ModuleTemplateCreateForm"
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