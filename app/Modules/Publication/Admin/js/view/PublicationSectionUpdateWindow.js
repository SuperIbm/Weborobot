Ext.define('Publication.view.PublicationSectionUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.view.PublicationSectionUpdateWindow',
		
		requires:
		[
		"Publication.view.PublicationSectionUpdateForm"
		],
	
	name: "Publication",
	title: "Изменить раздел",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 490,
	height: 345,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationSectionUpdateForm"
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