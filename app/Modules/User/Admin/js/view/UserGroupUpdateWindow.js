Ext.define('User.view.UserGroupUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserGroupUpdateWindow',
		
		requires:
		[
		"User.view.UserGroupUpdateTab"
		],
	
	name: "User",
	title: "Изменить группу",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 990,
	height: 550,
	
	modal: true,
		
		items:
		[
			{
			xtype: "User.view.UserGroupUpdateTab"
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