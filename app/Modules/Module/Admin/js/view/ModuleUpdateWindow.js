Ext.define('Module.view.ModuleUpdateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Module.view.ModuleUpdateWindow',
		
		requires:
		[
		"Module.view.ModuleUpdateForm"
		],
	
	name: "Module",
	title: "Изменить модуль",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 495,
	height: 135,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Module.view.ModuleUpdateForm"
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