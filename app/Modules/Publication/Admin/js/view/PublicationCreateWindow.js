Ext.define('Publication.view.PublicationCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.view.PublicationCreateWindow',
		
		requires:
		[
		"Publication.view.PublicationCreateTab"
		],
	
	name: "Publication",
	title: "Добавить публикацию",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 900,
	height: 565,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationCreateTab"
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