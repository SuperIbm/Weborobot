Ext.define('Publication.component.getLenta.view.Window',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.component.getLenta.view.Window',
	
		requires:
		[
		"Publication.component.getLenta.view.PublicationForm"
		],
	
	title: "Публикации: Лента публикаций",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	iconCls: "icon_Component_small",
	
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
	
	width: 500,
	height: 290,
		
		items:
		[
			{
			xtype: "Publication.component.getLenta.view.PublicationForm"
			}
		],
		fbar:
		[
			{	
			xtype: "button",
			text: "Применить",
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