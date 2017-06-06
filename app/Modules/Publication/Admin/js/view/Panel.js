Ext.define('Publication.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Publication.view.Panel',
	
	title: "Публикации",
	icon: Admin.getApplication().Section.get("Publication")["iconSmall"],
	layout: 'border',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationTab"
			}
		]
	}
);
