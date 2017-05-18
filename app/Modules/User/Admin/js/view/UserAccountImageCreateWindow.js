Ext.define('User.view.UserAccountImageCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.User.view.UserAccountImageCreateWindow',
		
		requires:
		[
		"User.view.UserAccountImageCreateForm"
		],
	
	name: "User",
	title: "Загрузить изображение",
	iconCls: "icon_create",
	layout: 'fit',
	width: 500,
	height: 135,
	scrollable: true,
	constrain: true,
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
		
		items:
		[
			{
			xtype: "User.view.UserAccountImageCreateForm"
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