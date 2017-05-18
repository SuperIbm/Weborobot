Ext.define('Infoblock.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Infoblock.view.Panel',

	icon: Admin.getApplication().Section.get("Infoblock")["iconSmall"],
	layout: 'fit',

	scrollable: false,
	frame: true,
	
		items:
		[
			{
			xtype: "Infoblock.view.InfoblockGrid"
			}
		]
	}
);