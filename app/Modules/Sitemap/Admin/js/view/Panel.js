Ext.define('Sitemap.view.Panel',
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Sitemap.view.Panel',

		requires:
		[
		"Sitemap.view.SitemapForm"
		],
	
	title: "Sitemap",
	icon: Admin.getApplication().Section.get("Sitemap")["iconSmall"],
	layout: 'fit',
	frame: true,
	scrollable: false,
		
		items:
		[
			{
			xtype: "Sitemap.view.SitemapForm"
			}
		],
		tbar:
		[
			"->",
			{
			xtype: "button",
			text: "Сканировать",
			action: "scan",
			icon: "app/Modules/Sitemap/Admin/images/icon_scan.png"
			}
		],
		fbar:
		[
			{
			xtype: "button",
			text: "Сохранить",
			action: "send"
			},
			{
			xtype: "button",
			text: "Очистить",
			action: "reset"
			}
		]
	}
);
