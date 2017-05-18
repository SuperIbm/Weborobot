Ext.define('User.action.siteConfirm.view.Window', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.action.siteConfirm.view.Window',
	
		requires:
		[
		"User.action.siteConfirm.view.UserForm"
		],
	
	title: "Пользователи сайта: Подтверждение учетной записи",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	iconCls: "icon_Page_Action_small",
	
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
	
	width: 500,
	height: 135,
	
		
		items:
		[
			{
			xtype: "User.action.siteConfirm.view.UserForm"
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