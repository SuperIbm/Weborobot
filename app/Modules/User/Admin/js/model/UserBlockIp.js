Ext.define('User.model.UserBlockIp',
	{
    extend: 'Ext.data.Model',
	name: 'UserBlockIp',
	idProperty: 'idBlockIp',
	clientIdProperty: "idBlockIp",
	
    	fields:
		[			
			{
			name: "idBlockIp",
			type: "int"
			},
			{
			name: "ip",
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
			create: '_api/User/BlockIpAdminController/create/',
			update: '_api/User/BlockIpAdminController/update/',
			destroy: '_api/User/BlockIpAdminController/destroy/',
			read: '_api/User/BlockIpAdminController/read/'
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