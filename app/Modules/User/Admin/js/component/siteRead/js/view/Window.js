Ext.define('User.action.siteRead.view.Window', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.action.siteRead.view.Window',
	
		requires:
		[
		"User.action.siteRead.view.UserForm"
		],
	
	title: "Пользователи сайта: Восстановления пароля",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	iconCls: "icon_Page_Action_small",
	
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
	
	width: 500,
	height: 195,
	
		
		items:
		[
			{
			xtype: "User.action.siteRead.view.UserForm"
			}
		],
		fbar:
		[
			{	
			xtype: "button",
			text: "Применить",
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