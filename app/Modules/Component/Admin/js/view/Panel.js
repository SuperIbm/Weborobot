Ext.define('Component.view.Panel',
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Component.view.Panel',
	
	title: "Компоненты",
	icon: Admin.getApplication().Section.get("Component")["iconSmall"],
	layout: 'border',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Component.view.ModuleTree"
			},
			{
			xtype: "Component.view.ComponentGrid"
			}
		]
	}
);
