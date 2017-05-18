Ext.define('Seo.view.SeoTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Seo.view.SeoTab',
	
		requires:
		[
		"Seo.view.SeoChart",
		"Seo.view.SeoGrid"
		],		
	
	name: "Seo",
	padding: 5,
	region: "center",
	
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: false,
	forceLayout: true,
	
		items:
		[
			
			{
			title: "График",
			iconCls: "icon_Seo_char_small",
			layout: "fit",
			itemId: "tab_1",
			border: true,
				items:
				[
					{
					xtype: "Seo.view.SeoChart"	
					}
				]
			},
			{
			title: "Таблица",
			iconCls: "icon_Seo_table_small",
			layout: "fit",
			itemId: "tab_2",
			border: true,
				items:
				[
					{
					xtype: "Seo.view.SeoGrid"
					}
				]
			}			
		]
	}
);