Ext.application
( 
	{
	name: 'Setting',
	id: "Setting",
	
	appFolder: 'engine/app/Modules/Setting/admin/js',
	views: ["Panel", "SettingGridProperty"],
	controllers: ['Setting'],
	
	extend: "Admin.view.ux.Application"
	}
);