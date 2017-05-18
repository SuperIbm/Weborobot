Ext.define('User.view.UserAccountUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserAccountUpdateWindow',
		
		requires:
		[
		"User.view.UserAccountUpdateTab"
		],
	
	name: "User",
	title: "Изменить пользователя",
	iconCls: "icon_update",
	layout: 'fit',
	
	width: 860,
	height: 500,
	
	scrollable: true,
	constrain: true,
	modal: true,
		
		items:
		[
			{
			xtype: "User.view.UserAccountUpdateTab"
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