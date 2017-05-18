Ext.define('Sitemap.view.SitemapForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Sitemap.view.SitemapForm',
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	layout: 'fit',
	
		items:
		[
			{
			xtype: "codemirror",

			hideLabel: true,
			mode: "xml",
			height: "100%",
			layout: 'fit',
			
			name: "text"
			}
		]
	}
);