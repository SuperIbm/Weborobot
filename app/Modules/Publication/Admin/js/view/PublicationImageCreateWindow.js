Ext.define('Publication.view.PublicationImageCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.view.PublicationImageCreateWindow',
		
		requires:
		[
		"Publication.view.PublicationImageCreateForm"
		],
	
	name: "Publication",
	title: "Загрузить изображение",
	iconCls: "icon_create",
	layout: 'fit',
	width: 500,
	height: 135,
	scrollable: true,
	constrain: true,
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationImageCreateForm"
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