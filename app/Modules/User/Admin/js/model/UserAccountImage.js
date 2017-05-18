Ext.define('User.model.UserAccountImage',
	{
    extend: 'Ext.data.Model',
	name: 'UserAccountImage',
	
	idProperty: 'idImage',
	clientIdProperty: "idImage",
	
    	fields:
		[			
			{
			name: "idImage",
			type: "int"
			},
			{
			name: "format",
			type: "string"
			},
			{
			name: "path",
			type: "string"
			},
			{
			name: "width",
			type: "int"
			},
			{
			name: "height",
			type: "int"
			}
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			create: '_api/User/UserImageAdminController/create/',
			destroy: '_api/User/UserImageAdminController/destroy/',
			read: '_api/User/UserImageAdminController/read/'
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