Ext.define('Module.model.Module',
	{
    extend: 'Ext.data.Model',
	name: 'Module',
	idProperty: 'idModule',
	clientIdProperty: "idModule",
	
    	fields:
		[			
			{
			name: "idModule",
			type: "int"
			},
			{
			name: "labelModule",
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
			create: '_api/Module/ModuleAdminController/create/',
			update: '_api/Module/ModuleAdminController/update/',
			read: '_api/Module/ModuleAdminController/read/'
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