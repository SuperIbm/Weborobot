Ext.define('Upload.view.UploadSourceCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Upload.view.UploadSourceCreateWindow',
		
		requires:
		[
		"Upload.view.UploadSourceCreateForm"
		],
	
	name: "Upload",
	title: "Добавить источник",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 495,
	height: 230,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Upload.view.UploadSourceCreateForm"
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