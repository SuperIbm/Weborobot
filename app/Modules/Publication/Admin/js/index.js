Ext.application
( 
	{
	name: 'Publication',
	id: "Publication",
	
	appFolder: 'app/Modules/Publication/Admin/js',
	views: ["Panel"],
	controllers: 
	[
	"PublicationSection",
	"Publication",
	"PublicationComment"
	],
	
	extend: "Admin.view.ux.Application"
	}
);