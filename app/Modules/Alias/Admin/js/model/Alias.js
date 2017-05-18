Ext.define('Alias.model.Alias',
	{
    extend: 'Ext.data.Model',
	name: 'Alias',
	idProperty: 'idAlias',
	clientIdProperty: "idAlias",
	
    	fields:
		[			
			{
			name: "idAlias",
			type: "int"
			},
			{
			name: "pattern",
			type: "string"
			},
            {
            name: "idPage",
            mapping: 'page.idPage',
            type: "int"
            },
            {
			name: "namePage",
            mapping: 'page.namePage',
            type: "string"
            },
            {
            name: "path",
            mapping: 'page.path',
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
			create: '_api/Alias/AliasAdminController/create/',
			update: '_api/Alias/AliasAdminController/update/',
			destroy: '_api/Alias/AliasAdminController/destroy/',
			read: '_api/Alias/AliasAdminController/read/'
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