Ext.define('Upload.widget.upload.view.Panel', 
	{
    extend: 'Admin.view.ux.PanelPortletAnimate',
	alias: 'widget.Upload.widget.upload.view.Panel',
	
		requires:
		[
		"Upload.widget.upload.view.UploadGrid"
		],
	
	layout: 'fit',
	scrollable: true,
		
		items:
		[
			{
			xtype: "Upload.widget.upload.view.UploadGrid"
			}
		]
	}
);