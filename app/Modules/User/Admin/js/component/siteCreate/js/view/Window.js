Ext.define('User.action.siteCreate.view.Window', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.action.siteCreate.view.Window',
	
		requires:
		[
		"User.action.siteCreate.view.UserForm"
		],
	
	title: "Пользователи сайта: Регистрация",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	iconCls: "icon_Page_Action_small",
	
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
	
	width: 500,
	height: 200,
	
		
		items:
		[
			{
			xtype: "User.action.siteCreate.view.UserForm"
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