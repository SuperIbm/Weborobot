Ext.define('User.action.siteForget.view.Window', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.action.siteForget.view.Window',
	
		requires:
		[
		"User.action.siteForget.view.UserForm"
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
	height: 170,
	
		
		items:
		[
			{
			xtype: "User.action.siteForget.view.UserForm"
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