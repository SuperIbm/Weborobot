Ext.define('Filesystem.view.FilesystemDirUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Filesystem.view.FilesystemDirUpdateWindow',
		
		requires:
		[
		"Filesystem.view.FilesystemDirUpdateForm"
		],
	
	name: "Filesystem",
	title: "Изменить папку",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 500,
	height: 135,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Filesystem.view.FilesystemDirUpdateForm"
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