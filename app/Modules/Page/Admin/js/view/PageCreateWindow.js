Ext.define('Page.view.PageCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Page.view.PageCreateWindow',
	
		requires:
		[
		"Page.view.PageCreateTab"
		],
	
	name: "Page",
	title: "Добавить страницу",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	width: 900,
	height: 540,
	modal: true,
		items:
		[
			{
			xtype: "Page.view.PageCreateTab"
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