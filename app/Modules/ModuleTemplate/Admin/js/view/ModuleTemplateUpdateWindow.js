Ext.define('ModuleTemplate.view.ModuleTemplateUpdateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.ModuleTemplate.view.ModuleTemplateUpdateWindow',
		
		requires:
		[
		"ModuleTemplate.view.ModuleTemplateUpdateForm"
		],
	
	name: "ModuleTree",
	title: "Изменить шаблон модуля",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 900,
	height: 550,
	
	modal: true,
		
		items:
		[
			{
			xtype: "ModuleTemplate.view.ModuleTemplateUpdateForm"
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