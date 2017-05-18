Ext.define('Widget.view.WidgetUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Widget.view.WidgetUpdateWindow',
		
		requires:
		[
		"Widget.view.WidgetUpdateForm"
		],
	
	name: "Widget",
	title: "Изменить виджет",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 495,
	height: 260,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Widget.view.WidgetUpdateForm"
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