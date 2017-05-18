Ext.define('Page.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Page.view.Panel',

	title: "Структура сайта",
	icon: Admin.getApplication().Section.get("Page")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
	
		items:
		[
			{
			xtype: "Page.view.PageTree"
			}
		],
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить дерево',
			itemId: 'refresh'
			},
			{
			type: 'expand',
			tooltip: 'Развернуть',
			itemId: 'expand'
			},
			{
			type: 'collapse',
			tooltip: 'Свернуть',
			itemId: 'collapse'
			}
		]
	}
);