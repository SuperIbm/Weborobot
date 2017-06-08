Ext.define('ModuleTemplate.view.Panel',
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.ModuleTemplate.view.Panel',
	
	title: "Шаблоны модулей",
	icon: Admin.getApplication().Section.get("ModuleTemplate")["iconSmall"],
	layout: 'border',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "ModuleTemplate.view.ModuleTree"
			},
			{
			xtype: "ModuleTemplate.view.ModuleTemplateGrid"
			}
		]
	}
);
