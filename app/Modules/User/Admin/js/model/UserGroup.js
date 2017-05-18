Ext.define('User.model.UserGroup',
	{
    extend: 'Ext.data.Model',
	name: 'UserGroup',
	idProperty: 'idUserGroup',
	clientIdProperty: "idUserGroup",
	
    	fields:
		[			
			{
			name: "idUserGroup",
			type: "int"
			},
			{
			name: "nameGroup",
			type: "string"
			},
			{
			name: "nameRoles",
			type: "string"
			},
			{
			name: "idPages",
			type: "string"
			},
			{
			name: "userGroup.status",
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
            create: '_api/User/UserGroupAdminController/create/',
            update: '_api/User/UserGroupAdminController/update/',
            destroy: '_api/User/UserGroupAdminController/destroy/',
            read: '_api/User/UserGroupAdminController/read/'
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