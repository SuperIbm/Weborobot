Ext.define('Publication.view.PublicationCommentCreateTab',
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Publication.view.PublicationCommentCreateTab',
	
		requires:
		[
		"Publication.view.PublicationCommentCreateForm"
		],
	
	name: "PublicationComment",
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
					xtype: "Publication.view.PublicationCommentCreateForm"
					}
				]
			}
		]
	}
);