Ext.define('Publication.view.PublicationCommentUpdateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.view.PublicationCommentUpdateWindow',
		
		requires:
		[
		"Publication.view.PublicationCommentUpdateTab"
		],
	
	name: "Publication",
	title: "Изменить комменарий",
	iconCls: "icon_update",
	layout: 'fit',
	autoScroll: true,
	constrain: true,
	
	width: 900,
	height: 585,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationCommentUpdateTab"
			}
		],
		fbar:
		[
			{	
			xtype: "button",
			text: "Изменить",
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