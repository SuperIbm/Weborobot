Ext.define('Component.view.ComponentUpdateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Component.view.ComponentUpdateWindow',
		
		requires:
		[
		"Component.view.ComponentUpdateForm"
		],
	
	name: "ModuleTree",
	title: "Изменить компонент",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,

	width: 490,
	height: 200,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Component.view.ComponentUpdateForm"
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