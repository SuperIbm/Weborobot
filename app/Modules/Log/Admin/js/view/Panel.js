Ext.define('Log.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Log.view.Panel',
	
	title: "Журнал логов",
	icon: Admin.getApplication().Section.get("Log")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Log.view.LogGrid"
			}
		]
	}
);