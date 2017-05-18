Ext.define('Support.view.SupportUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Support.view.SupportUpdateWindow',
		
		requires:
		[
		"Support.view.SupportUpdateForm"
		],
	
	name: "Support",
	title: "Изменить данные администратора поддержки",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 490,
	height: 165,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Support.view.SupportUpdateForm"
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