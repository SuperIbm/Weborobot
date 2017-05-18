Ext.define('AdminSection.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.AdminSection.view.Panel',
	
	title: "Разделы",
	icon: Admin.getApplication().Section.get("AdminSection")["iconSmall"],
	layout: 'border',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "AdminSection.view.AdminSectionTab"	
			}
		],
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить',
			itemId: 'refresh'
			}
		]
	}
);