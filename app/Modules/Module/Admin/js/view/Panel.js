Ext.define('Module.view.Panel',
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Module.view.Panel',
	
	title: "Модули",
	icon: Admin.getApplication().Section.get("Module")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Module.view.ModuleGrid"
			}
		]
	}
);