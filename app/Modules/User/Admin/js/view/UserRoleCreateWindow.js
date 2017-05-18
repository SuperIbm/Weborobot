Ext.define('User.view.UserRoleCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserRoleCreateWindow',
		
		requires:
		[
		"User.view.UserRoleCreateTab"
		],
	
	name: "User",
	title: "Добавить роль",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 900,
	height: 500,
	
	modal: true,
		
		items:
		[
			{
			xtype: "User.view.UserRoleCreateTab"
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