Ext.define('Page.view.PageUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Page.view.PageUpdateWindow',
	
		requires:
		[
		"Page.view.PageUpdateTab"
		],
	
	name: "Page",
	title: "Изменить страницу",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	width: 900,
	height: 540,
	modal: true,
		items:
		[
			{
			xtype: "Page.view.PageUpdateTab"
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