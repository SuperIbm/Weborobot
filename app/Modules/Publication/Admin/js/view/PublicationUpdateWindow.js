Ext.define('Publication.view.PublicationUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.view.PublicationUpdateWindow',
		
		requires:
		[
		"Publication.view.PublicationUpdateTab"
		],
	
	name: "Publication",
	title: "Изменить публикацию",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 900,
	height: 565,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationUpdateTab"
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