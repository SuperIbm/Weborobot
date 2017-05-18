Ext.define('Widget.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Widget.view.Window',
	
	title: "Виджеты",
	icon: Admin.getApplication().Section.get("Widget")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Widget.view.WidgetGrid"
			}
		]
	}
);