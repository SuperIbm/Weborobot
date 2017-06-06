Ext.define('Publication.view.PublicationSectionCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.view.PublicationSectionCreateWindow',
		
		requires:
		[
		"Publication.view.PublicationSectionCreateForm"
		],
	
	name: "Publication",
	title: "Добавить раздел",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 490,
	height: 345,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationSectionCreateForm"
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