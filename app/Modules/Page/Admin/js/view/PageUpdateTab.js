Ext.define('Page.view.PageUpdateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Page.view.PageUpdateTab',
	
		requires:
		[
		"Page.view.PageUpdateContentCKEditor",
		"Page.view.PageUpdateSettingForm",
		"Page.view.PageUpdatePageComponentTree",
		"Page.view.PageUpdateModuleAndComponentTree",
		
		"PageTemplate.view.PageTemplateGrid",
		"PageTemplate.store.PageTemplate",
		"PageTemplate.model.PageTemplate"
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
					xtype: "Page.view.PageUpdateContentCKEditor"	
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
					xtype: "Page.view.PageUpdateSettingForm"	
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
			},
			{
			title: "Компоненты",
			iconCls: "icon_Page_PageComponent_small",
			layout: "border",
			itemId: "tab_4",
				items:
				[
					{
					xtype: "Page.view.PageUpdatePageComponentTree",
					border: true
					},
					{
					xtype: "Page.view.PageUpdateModuleAndComponentTree",
					border: true
					}
				]
			}
		]
	}
);