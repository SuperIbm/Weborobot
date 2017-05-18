Ext.define('Filesystem.view.FilesystemDirCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Filesystem.view.FilesystemDirCreateForm',
	
		requires:
		[
		"Filesystem.view.field.FilesystemDirNameText"
		],
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "Filesystem.view.field.FilesystemDirNameText"
			}
		]
	}
);