Ext.application
( 
	{
	name: 'Upload',
	id: "Upload",
	
	appFolder: 'app/Modules/Upload/admin/js',
	views: ["Panel"],
	controllers: ['Upload'],
	
	extend: "Admin.view.ux.Application"
	}
);