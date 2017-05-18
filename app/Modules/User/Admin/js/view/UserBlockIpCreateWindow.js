Ext.define('User.view.UserBlockIpCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserBlockIpCreateWindow',
		
		requires:
		[
		"User.view.UserBlockIpCreateForm"
		],
	
	name: "User",
	title: "Добавить блокированное IP",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 490,
	height: 165,
	
	modal: true,
		
		items:
		[
			{
			xtype: "User.view.UserBlockIpCreateForm"
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