Ext.define('Publication.view.PublicationTab',
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Publication.view.PublicationTab',
	
	name: "Publication",
	margin: 5,
	region: "center",
	
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: true,
	
		items:
		[
			{
			title: "Публикации",
			iconCls: "icon_Publication_Articles_small",
			layout: "border",
			itemId: "Articles",
				items:
				[
					{
					xtype: "Publication.view.PublicationSectionTree"
					},
					{
					xtype: "Publication.view.PublicationGrid"
					}
				]
			},
			{
			title: "Комментарии",
			iconCls: "icon_Publication_Comment_small",
			layout: "fit",
			itemId: "Comments",
				items:
				[
					{
					xtype: "Publication.view.PublicationCommentGrid"
					}
				]
			}
		]
	}
);