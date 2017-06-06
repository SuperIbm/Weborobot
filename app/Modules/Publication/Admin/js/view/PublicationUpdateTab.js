Ext.define('Publication.view.PublicationUpdateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Publication.view.PublicationUpdateTab',
	
		requires:
		[
		"Publication.view.PublicationUpdateForm", 
		"Publication.view.PublicationCreateContentCKEditor",
		"Publication.view.PublicationUpdateImagePanel",
		"Publication.view.PublicationCommentUpdateTree"
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
					xtype: "Publication.view.PublicationUpdateForm"	
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
			},
			{
			title: "Изображение",
			layout: "fit",
			itemId: "tab_3",
				items:
				[
					{
					xtype: "Publication.view.PublicationUpdateImagePanel"
					}
				]
			},
			{
			title: "Комментарии",
			layout: "fit",
			itemId: "tab_4",
				items:
				[
					{
					xtype: "Publication.view.PublicationCommentUpdateTree"
					}
				]
			}
		]
	}
);