Ext.application
( 
	{
	name: 'Filesystem',
	id: "Filesystem",
	
	appFolder: 'engine/app/Modules/Filesystem/admin/js',
	views: ["Panel"],
	controllers: ['Dir', 'File'],
	
	extend: "Admin.view.ux.Application"
	}
);