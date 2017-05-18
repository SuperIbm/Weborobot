Ext.define('Page.view.PageCreateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Page.view.PageCreateTab',
	
		requires:
		[
		"Page.view.PageCreateContentCKEditor",
		"Page.view.PageCreateSettingForm",
		
		"PageTemplate.model.PageTemplate",
		"PageTemplate.store.PageTemplate",
		"PageTemplate.view.PageTemplateGrid"
		],
	
	name: "Page",
	padding: 5,
	
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: false,
	forceLayout: true,
	
		items:
		[
			{
			title: "Контент",
			iconCls: "icon_Page_Content_small",
			layout: "fit",
			itemId: "tab_1",
				items:
				[
					{
					xtype: "Page.view.PageCreateContentCKEditor"	
					}
				]
			},
			{
			title: "Настройки",
			iconCls: "icon_Page_Setting_small",
			layout: "fit",
			itemId: "tab_2",
				items:
				[
					{
					xtype: "Page.view.PageCreateSettingForm"	
					}
				]
			},
			{
			title: "Шаблоны",
			iconCls: "icon_Page_PageTemplate_small",
			layout: "fit",
			itemId: "tab_3",
				items:
				[
					{
					xtype: "PageTemplate.view.PageTemplateGrid",
					store: "PageTemplateSelect",
						selModel: 
						{
						mode: "SINGLE",
						injectCheckbox: "first",
						allowDeselect: true
						},	
					selType: "checkboxmodel",
					border: true,
					dockedItems: null
					}
				]
			}
		]
	}
);