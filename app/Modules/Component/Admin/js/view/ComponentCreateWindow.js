Ext.define('Component.view.ComponentCreateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Component.view.ComponentCreateWindow',
		
		requires:
		[
		"Component.view.ComponentCreateForm"
		],
	
	name: "ModuleTree",
	title: "Добавить компонент",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 490,
	height: 200,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Component.view.ComponentCreateForm"
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