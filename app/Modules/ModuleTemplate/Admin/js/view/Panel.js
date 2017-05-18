Ext.define('Component.view.Panel',
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Component.view.Panel',
	
	title: "Шаблоны модулей",
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
