Ext.define('ModuleTemplate.model.ModuleTemplate',
	{
    extend: 'Ext.data.Model',
	name: 'ModuleTemplate',
	idProperty: 'idModuleTemplate',
	clientIdProperty: "idModuleTemplate",
	
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
            mapping: 'module.labelModule',
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
			create: '_api/ModuleTemplate/ModuleTemplateAdminController/create/',
			update: '_api/ModuleTemplate/ModuleTemplateAdminController/update/',
			destroy: '_api/ModuleTemplate/ModuleTemplateAdminController/destroy/',
			read: '_api/ModuleTemplate/ModuleTemplateAdminController/read/'
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