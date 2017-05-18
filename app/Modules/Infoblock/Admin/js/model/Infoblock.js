Ext.define('Infoblock.model.Infoblock',
	{
    extend: 'Ext.data.Model',
	name: 'Infoblock',
	idProperty: 'idInfoblock',
	clientIdProperty: "idInfoblock",
	
    	fields:
		[			
			{
			name: "idInfoblock",
			type: "string"
			},
			{
			name: "labelInfoblock",
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
			create: '_api/Infoblock/InfoblockAdminController/create/',
			update: '_api/Infoblock/InfoblockAdminController/update/',
			destroy: '_api/Infoblock/InfoblockAdminController/destroy/',
			read: '_api/Infoblock/InfoblockAdminController/read/'
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