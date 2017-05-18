Ext.define('Support.model.Support',
	{
    extend: 'Ext.data.Model',
	name: 'Support',
	idProperty: 'idSupport',
	clientIdProperty: "idSupport",
	
    	fields:
		[			
			{
			name: "idSupport",
			type: "int"
			},
			{
			name: "email",
			type: "string"
			},
			{
			name: "fio",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			update: '_api/Support/SupportAdminController/update/',
			read: '_api/Support/SupportAdminController/read/'
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