Ext.define('Infoblock.component.get.view.Window',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Infoblock.component.get.view.Window',
	
		requires:
		[
		"Infoblock.component.get.view.InfoblockForm"
		],
	
	title: "Инфоблок: Установить",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	iconCls: "icon_Page_PageComponent_small",
	
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
	
	width: 500,
	height: 165,
	
		
		items:
		[
			{
			xtype: "Infoblock.component.get.view.InfoblockForm"
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