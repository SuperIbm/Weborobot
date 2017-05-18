Ext.application
( 
	{
	name: 'User',
	id: "User",
	
	appFolder: 'app/Modules/User/admin/js',
	views: ["Panel"],
	
		controllers: 
		[
		'User',
		'UserAccount',
		'UserGroup',
		'UserRole',
		'UserBlockIp'
		],
	
	extend: "Admin.view.ux.Application"
	}
);