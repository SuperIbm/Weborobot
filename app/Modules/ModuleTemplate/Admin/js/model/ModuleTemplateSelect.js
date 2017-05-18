Ext.define('ModuleTemplate.model.ModuleTemplateSelect',
	{
    extend: 'Ext.data.Model',
	name: 'ModuleTemplateSelect',
	idProperty: 'idModuleTemplate',
	clientIdProperty: "idModuleTemplate",
	
	noCache: false,
	
    	fields:
		[			
			{
			name: "idModuleTemplate",
			type: "int"
			},
			{
			name: "idModule",
			type: "int"
			},
			{
			name: "labelTemplate",
			type: "string"
			},
			{
			name: "labelModule",
			type: "string"
			},
			{
			name: "componentTemplate.status",
			mapping: "status",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
			read: '_api/ModuleTemplate/ModuleTemplateAdminController/read/'
			},
			reader:
			{
			type: 'json',
			rootProperty: "data",
			messageProperty: "errortype"
			}
		}
	}
);