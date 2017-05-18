Ext.define('Filesystem.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Filesystem.view.Window',
		
	title: "Файловая система",
	icon: Admin.getApplication().Section.get("Filesystem")["iconSmall"],
	layout: 'border',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Filesystem.view.FilesystemDirTree"
			},
			{
			xtype: "Filesystem.view.FilesystemFileGrid"
			}
		]
	}
);