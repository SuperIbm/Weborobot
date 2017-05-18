Ext.define('Log.widget.log.view.Panel',
	{
    extend: 'Admin.view.ux.PanelPortletAnimate',
	alias: 'widget.Log.widget.log.view.Panel',
	
		requires:
		[
		"Log.widget.log.view.LogGrid"
		],
	
	layout: 'fit',
	scrollable: true,
		
		items:
		[
			{
			xtype: "Log.widget.log.view.LogGrid"
			}
		]
	}
);