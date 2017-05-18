Ext.define('Filesystem.view.FilesystemDirCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Filesystem.view.FilesystemDirCreateWindow',
		
		requires:
		[
		"Filesystem.view.FilesystemDirCreateForm"
		],
	
	name: "Filesystem",
	title: "Добавить папку",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 500,
	height: 135,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Filesystem.view.FilesystemDirCreateForm"
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