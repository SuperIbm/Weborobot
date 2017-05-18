Ext.define('Upload.view.UploadSourceCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Upload.view.UploadSourceCreateForm',
	
		requires:
		[
		"Upload.view.field.UploadSourceLoginText",
		"Upload.view.field.UploadSourcePasswordText",
		"Upload.view.field.UploadSourceUrlText"
		],
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			},
			{
			xtype: "Upload.view.field.UploadSourceLoginText"
			},
			{
			xtype: "Upload.view.field.UploadSourcePasswordText"
			},
			{
			xtype: "Upload.view.field.UploadSourceUrlText"
			}
		]
	}
);