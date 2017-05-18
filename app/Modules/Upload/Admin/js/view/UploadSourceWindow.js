Ext.define('Upload.view.UploadSourceWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Upload.view.UploadSourceWindow',
	
		requires:
		[
		"Upload.view.UploadSourceGrid"
		],
	
	name: "Upload",
	title: "Источники",
	iconCls: "icon_UploadSource_small",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	width: 750,
	height: 500,
	
	modal: true,
		
		items:
		[
			{
			xtype: "Upload.view.UploadSourceGrid"
			}
		]
	}
);