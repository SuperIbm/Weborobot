Ext.define('Filesystem.view.FilesystemFileUpdateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Filesystem.view.FilesystemFileUpdateForm',
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "Filesystem.view.field.FilesystemFileNameText"
			}
		]
	}
);