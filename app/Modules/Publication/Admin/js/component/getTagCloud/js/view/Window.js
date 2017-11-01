Ext.define('Publication.component.getTagCloud.view.Window',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.component.getTagCloud.view.Window',
	
		requires:
		[
		"Publication.component.getTagCloud.view.PublicationForm"
		],
	
	title: "Публикации: Облака тэгов",
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
			xtype: "Publication.component.getTagCloud.view.PublicationForm"
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