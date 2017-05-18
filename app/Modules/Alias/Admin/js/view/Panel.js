Ext.define('Alias.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Alias.view.Panel',
	
	title: "Псевдонимы",
	icon: Admin.getApplication().Section.get("Alias")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Alias.view.AliasGrid"
			}
		]
	}
);