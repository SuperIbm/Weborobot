Ext.define('Seo.widget.seo.view.Panel', 
	{
    extend: 'Admin.view.ux.PanelPortletAnimate',
	alias: 'widget.Seo.widget.seo.view.Panel',
	
		requires:
		[
		"Seo.widget.seo.view.SeoChart"
		],
	
	layout: 'fit',
	scrollable: true,
		
		items:
		[
			{
			xtype: "Seo.widget.seo.view.SeoChart"
			}
		]
	}
);