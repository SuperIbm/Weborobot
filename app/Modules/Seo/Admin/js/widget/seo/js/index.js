Ext.application
( 
	{
	name: 'Seo.widget.seo',
	id: "Seo.widget.seo",
	
	appFolder: 'app/Modules/Seo/Admin/js/widget/seo/js',
	views: ["Panel"],
	stores: ["SeoWidget"],
	models: ["SeoWidget"],
	
	extend: "Admin.view.ux.Application"
	}
);