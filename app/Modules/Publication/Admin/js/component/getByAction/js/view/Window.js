Ext.define('Publication.component.getByAction.view.Window',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.component.getByAction.view.Window',
	
		requires:
		[
		"Publication.component.getByAction.view.PublicationForm"
		],
	
	title: "Публикации: Публикация по запросу",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	iconCls: "icon_Component_small",
	
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
	
	width: 500,
	height: 265,
		
		items:
		[
			{
			xtype: "Publication.component.getByAction.view.PublicationForm"
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