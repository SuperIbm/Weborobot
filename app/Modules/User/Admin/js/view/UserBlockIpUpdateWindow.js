Ext.define('User.view.UserBlockIpUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserBlockIpUpdateWindow',
		
		requires:
		[
		"User.view.UserBlockIpUpdateForm"
		],
	
	name: "User",
	title: "Изменить блокированное IP",
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
			xtype: "User.view.UserBlockIpUpdateForm"
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