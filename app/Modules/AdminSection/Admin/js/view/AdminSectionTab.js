Ext.define('AdminSection.view.AdminSectionTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.AdminSection.view.AdminSectionTab',
	
		requires:
		[
		"AdminSection.view.AdminSectionGrid"
		],
	
	name: "AdminSection",
	margin: 5,
	region: "center",
	
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: false,
	forceLayout: true,
	
		items:
		[
			{
			title: 'Контент',
			layout: "fit",
			iconCls: "bundle_content",
			itemId: "content",
				items:
				[
					{
					xtype: "AdminSection.view.AdminSectionGrid",
					bundleShow: "CONTENT"	
					}
				]
			},
			{
			title: 'Сервисы',
			layout: "fit",
			iconCls: "bundle_services",
			itemId: "services",
				items:
				[
					{
					xtype: "AdminSection.view.AdminSectionGrid",
					bundleShow: "SERVICES"	
					}
				]
			},
			{
			title: 'Продажи',
			layout: "fit",
			iconCls: "bundle_sales",
			itemId: "sales",
				items:
				[
					{
					xtype: "AdminSection.view.AdminSectionGrid",
					bundleShow: "SALES"	
					}
				]
			},
			{
			title: 'Продвижение',
			layout: "fit",
			iconCls: "bundle_maneger",
			itemId: "maneger",
				items:
				[
					{
					xtype: "AdminSection.view.AdminSectionGrid",
					bundleShow: "SEO"	
					}
				]
			},
			{
			title: 'Управления',
			layout: "fit",
			iconCls: "bundle_seo",
			itemId: "seo",
				items:
				[
					{
					xtype: "AdminSection.view.AdminSectionGrid",
					bundleShow: "MANEGER"	
					}
				]
			},
			{
			title: 'Система',
			layout: "fit",
			iconCls: "bundle_system",
			itemId: "system",
				items:
				[
					{
					xtype: "AdminSection.view.AdminSectionGrid",
					bundleShow: "SYSTEM"	
					}
				]
			}
		]
	}
);