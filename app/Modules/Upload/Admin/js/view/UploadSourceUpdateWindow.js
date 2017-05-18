Ext.define('Upload.view.UploadSourceUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Upload.view.UploadSourceUpdateWindow',
		
		requires:
		[
		"Upload.view.UploadSourceUpdateForm"
		],
	
	name: "Upload",
	title: "Изменить источник",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	
	width: 495,
	height: 230,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Upload.view.UploadSourceUpdateForm"
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