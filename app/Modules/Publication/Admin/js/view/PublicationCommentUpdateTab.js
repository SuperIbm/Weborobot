Ext.define('Publication.view.PublicationCommentUpdateTab',
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Publication.view.PublicationCommentUpdateTab',
	
		requires:
		[
		"Publication.view.PublicationCommentUpdateForm",
		"Publication.view.PublicationCommentUpdateImagePanel"
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
					xtype: "Publication.view.PublicationCommentUpdateForm"
					}
				]
			},
			{
			title: "Изображение",
			layout: "fit",
			itemId: "tab_2",
				items:
				[
					{
					xtype: "Publication.view.PublicationCommentUpdateImagePanel"
					}
				]
			}
		]
	}
);