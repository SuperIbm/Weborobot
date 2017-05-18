Ext.define('Component.model.Component',
	{
    extend: 'Ext.data.Model',
	name: 'Component',
	idProperty: 'idComponent',
	clientIdProperty: "idComponent",
	
    	fields:
		[
			{
			name: "idComponent",
			type: "int"
			},
            {
			name: "idModule",
			type: "int"
            },
			{
			name: "nameBundle",
			type: "string"
			},
			{
			name: "labelModule",
            mapping: 'module.labelModule',
			type: "string"
			},
            {
            name: "nameComponent",
            type: "string"
            },
            {
            name: "labelComponent",
            type: "string"
            },
            {
            name: "pathToCss",
            type: "string"
            },
            {
            name: "pathToJs",
            type: "string"
            },
			{
			name: "status",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
			create: '_api/Component/ComponentAdminController/create/',
			update: '_api/Component/ComponentAdminController/update/',
			read: '_api/Component/ComponentAdminController/read/'
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
			writeAllFields: true
			}
		}
	}
);