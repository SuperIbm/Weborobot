Ext.define('Alias.view.AliasUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Alias.view.AliasUpdateWindow',
		
		requires:
		[
		"Alias.view.AliasUpdateForm"
		],
	
	name: "Alias",
	title: "Изменить псевдоним",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 490,
	height: 195,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Alias.view.AliasUpdateForm"
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