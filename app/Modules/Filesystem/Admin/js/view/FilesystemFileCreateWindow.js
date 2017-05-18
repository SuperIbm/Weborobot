Ext.define('Filesystem.view.FilesystemFileCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Filesystem.view.FilesystemFileCreateWindow',
		
		requires:
		[
		"Filesystem.view.FilesystemFileCreateForm"
		],
	
	name: "Filesystem",
	title: "Добавить файл",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 500,
	height: 165,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Filesystem.view.FilesystemFileCreateForm"
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