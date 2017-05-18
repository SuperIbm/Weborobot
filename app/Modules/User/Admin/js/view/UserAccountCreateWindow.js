Ext.define('User.view.UserAccountCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserAccountCreateWindow',
		
		requires:
		[
		"User.view.UserAccountCreateTab"
		],
	
	name: "User",
	title: "Добавить пользователя",
	iconCls: "icon_create",
	layout: 'fit',
	
	width: 860,
	height: 500,
	
	scrollable: true,
	constrain: true,
	modal: true,
		
		items:
		[
			{
			xtype: "User.view.UserAccountCreateTab"
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