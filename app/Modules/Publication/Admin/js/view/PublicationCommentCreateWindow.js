Ext.define('Publication.view.PublicationCommentCreateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.view.PublicationCommentCreateWindow',
		
		requires:
		[
		"Publication.view.PublicationCommentCreateTab"
		],
	
	name: "Publication",
	title: "Добавить комменарий",
	iconCls: "icon_create",
	layout: 'fit',
	autoScroll: true,
	constrain: true,
	
	width: 900,
	height: 585,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationCommentCreateTab"
			}
		],
		fbar:
		[
			{	
			xtype: "button",
			text: "Добавить",
			action: "send"
			},
			{	
			xtype: "button",
			text: "Очистить",
			action: "reset"
			},
			{	
			xtype: "button",
			text: "Отменить",
			action: "cancel"
			}
		]
	}
);