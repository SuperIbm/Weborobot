Ext.define('User.model.UserRole',
	{
    extend: 'Ext.data.Model',
	name: 'UserRole',
	idProperty: 'idUserRole',
	clientIdProperty: "idUserRole",
	
    	fields:
		[			
			{
			name: "idUserRole",
			type: "int"
			},
			{
			name: "nameRole",
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
			create: '_api/User/UserRoleAdminController/create/',
			update: '_api/User/UserRoleAdminController/update/',
			destroy: '_api/User/UserRoleAdminController/destroy/',
			read: '_api/User/UserRoleAdminController/read/'
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