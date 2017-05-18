Ext.define('User.action.siteExit.view.Window', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.action.siteExit.view.Window',
	
		requires:
		[
		"User.action.siteExit.view.UserForm"
		],
	
	title: "Пользователи сайта: Выход",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	iconCls: "icon_Page_Action_small",
	
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
	
	width: 500,
	height: 145,
	
		
		items:
		[
			{
			xtype: "User.action.siteExit.view.UserForm"
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