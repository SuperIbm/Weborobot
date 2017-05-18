Ext.define('Widget.view.WidgetCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Widget.view.WidgetCreateWindow',
		
		requires:
		[
		"Widget.view.WidgetCreateForm",
		],
	
	name: "Widget",
	title: "Добавить виджет",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 495,
	height: 195,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Widget.view.WidgetCreateForm"
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