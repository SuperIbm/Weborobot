Ext.define('Module.view.ModuleCreateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Module.view.ModuleCreateWindow',
		
		requires:
		[
		"Module.view.ModuleCreateForm"
		],
	
	name: "Module",
	title: "Добавить модуль",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 495,
	height: 195,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Module.view.ModuleCreateForm"
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