Ext.define('Admin.view.AppContent', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Admin.view.AppContent',
	
		requires:
		[
		"Admin.view.AppRoot"
		], 
	
	scrollable: false,
	border: false,
	layout: 'fit',
	bodyPadding: "0 10 10 10",
	
		initComponent: function()
		{
			if(Ext.util.History.hasToken("section") == false && Ext.util.History.hasToken("menu") == false)
			{
				this.items =
				[
					{
					xtype: "Admin.view.AppRoot"	
					}
				];
			}
			
		this.callParent();	
		}
	}
);