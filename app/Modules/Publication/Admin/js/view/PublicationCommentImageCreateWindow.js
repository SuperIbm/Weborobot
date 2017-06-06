Ext.define('Publication.view.PublicationCommentImageCreateWindow',
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Publication.view.PublicationCommentImageCreateWindow',
		
		requires:
		[
		"Publication.view.PublicationCommentImageCreateForm"
		],
	
	name: "Publication",
	title: "Загрузить изображение",
	iconCls: "icon_create",
	layout: 'fit',
	width: 500,
	height: 135,
	autoScroll: true,
	constrain: true,
	minimizable: false,
	maximizable: false,
	resizable: false,
	modal: true,
		
		items:
		[
			{
			xtype: "Publication.view.PublicationCommentImageCreateForm"
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