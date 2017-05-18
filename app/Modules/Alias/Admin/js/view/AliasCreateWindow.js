Ext.define('Alias.view.AliasCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Alias.view.AliasCreateWindow',
		
		requires:
		[
		"Alias.view.AliasCreateForm"
		],
	
	name: "Alias",
	title: "Добавить псевдоним",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 490,
	height: 195,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Alias.view.AliasCreateForm"
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