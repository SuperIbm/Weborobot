Ext.define('User.view.UserGroupCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserGroupCreateWindow',
		
		requires:
		[
		"User.view.UserGroupCreateTab"
		],
	
	name: "User",
	title: "Добавить группу",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 990,
	height: 550,
	
	modal: true,
		
		items:
		[
			{
			xtype: "User.view.UserGroupCreateTab"
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