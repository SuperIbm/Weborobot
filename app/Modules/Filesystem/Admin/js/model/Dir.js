Ext.define('Filesystem.model.Dir',
	{
    extend: 'Ext.data.TreeModel',
	name: 'Dir',
	
	idProperty: 'path',
	clientIdProperty: "path",
	
    	fields:
		[
			{
			name: "name",
			type: "string"
			},
			{
			name: "nameFull",
			type: "string"
			},
			{
			name: "path",
			type: "string"
			},
			{
			name: "pathFull",
			type: "string"
			},
			{
			name: "expanded",
			type: "bool"
			},
			{
			name: "leaf",
			type: "bool"
			},
			{
			name: "icon",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			create: '_api/Filesystem/FilesystemDirAdminController/create/',
			update: '_api/Filesystem/FilesystemDirAdminController/update/',
			destroy: '_api/Filesystem/FilesystemDirAdminController/destroy/',
			read: '_api/Filesystem/FilesystemDirAdminController/read/'
			},
			reader:
			{
			type: 'json',
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