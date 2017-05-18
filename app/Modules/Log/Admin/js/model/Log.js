Ext.define('Log.model.Log',
	{
    extend: 'Ext.data.Model',
	name: 'Log',
	
    	fields:
		[			
			{
			name: "date",
			type: "string"
			},
			{
			name: "level",
			type: "string"
			},
			{
			name: "environment",
			type: "string"
			},
			{
			name: "header",
			type: "string"
			},
			{
			name: "stack",
			type: "string"
			},
            {
			name: "login",
			mapping: 'context.login',
			type: "string"
            },
            {
			name: "type",
			mapping: 'context.type',
			type: "string"
            },
            {
			name: "module",
			mapping: 'context.module',
			type: "string"
            },
            {
			name: "time",
			mapping: 'context.time',
			type: "float"
            },
            {
			name: "memory",
			mapping: 'context.memory',
			type: "float"
            },
            {
			name: "cpu",
			mapping: 'context.cpu',
			type: "float"
            }
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			read: '_api/Log/LogAdminController/read/'
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