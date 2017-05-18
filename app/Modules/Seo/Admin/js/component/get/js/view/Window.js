Ext.define('Seo.component.get.view.Window',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Seo.component.get.view.Window',
	
		requires:
		[
		"Seo.component.get.view.SeoForm"
		],
	
	title: "Статистика посещения: Установить",
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
			xtype: "Seo.component.get.view.SeoForm"
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