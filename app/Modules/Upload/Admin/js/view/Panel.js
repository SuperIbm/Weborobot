Ext.define('Upload.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Upload.view.Panel',
	
	title: "Обновления",
	icon: Admin.getApplication().Section.get("Upload")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Upload.view.UploadGrid"
			}
		],
		tools:
		[
			{
			type: "gear",
			itemId: "UploadSource",
			tooltip: "Настройка источников"
			}
		]
	}
);