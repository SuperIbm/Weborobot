Ext.define('Sitemap.model.Sitemap',
	{
    extend: 'Ext.data.Model',
	
	name: 'Sitemap',

	idProperty: 'id',
	clientIdProperty: "id",
	
    	fields:
		[
			{
			name: "id",
			type: "int"
			},
			{
			name: "text",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			read: '_api/Sitemap/SitemapAdminController/read/',
			create: '_api/Sitemap/SitemapAdminController/create/'
			},
			reader:
			{
			type: 'json',
			rootProperty: "data",
			messageProperty: "errortype"
			},
			writer:
			{
			type: 'cgi',
			writeAllFields: false
			}
		}
	}
);