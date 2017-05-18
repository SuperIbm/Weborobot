Ext.define('User.view.UserRoleUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserRoleUpdateWindow',
		
		requires:
		[
		"User.view.UserRoleUpdateTab"
		],
	
	name: "User",
	title: "Изменить роль",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 900,
	height: 500,
	
	modal: true,
		
		items:
		[
			{
			xtype: "User.view.UserRoleUpdateTab"
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