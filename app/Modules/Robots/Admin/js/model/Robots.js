Ext.define('Robots.model.Robots',
	{
    extend: 'Ext.data.Model',
	
	name: 'Robots',

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
			read: '_api/Robots/RobotsAdminController/read/',
			create: '_api/Robots/RobotsAdminController/create/'
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