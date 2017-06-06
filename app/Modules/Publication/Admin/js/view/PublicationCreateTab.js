Ext.define('Publication.view.PublicationCreateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Publication.view.PublicationCreateTab',
	
		requires:
		[
		"Publication.view.PublicationCreateForm", 
		"Publication.view.PublicationCreateContentCKEditor",
		"Publication.view.PublicationUpdateImagesZone"
		],
	
	name: "Publication",
	padding: 5,
	
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: false,
	forceLayout: true,
	
		items:
		[
			{
			title: "Основные данные",
			layout: "fit",
			itemId: "tab_1",
				items:
				[
					{
					xtype: "Publication.view.PublicationCreateForm"	
					}
				]
			},
			{
			title: "Статья",
			layout: "fit",
			itemId: "tab_2",
				items:
				[
					{
					xtype: "Publication.view.PublicationCreateContentCKEditor"	
					}
				]
			}
		]
	}
);