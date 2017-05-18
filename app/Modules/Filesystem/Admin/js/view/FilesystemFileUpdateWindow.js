Ext.define('Filesystem.view.FilesystemFileUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Filesystem.view.FilesystemFileUpdateWindow',
		
		requires:
		[
		"Filesystem.view.FilesystemFileUpdateTab"
		],
	
	name: "Filesystem",
	title: "Изменить файл",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 800,
	height: 500,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Filesystem.view.FilesystemFileUpdateTab"
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