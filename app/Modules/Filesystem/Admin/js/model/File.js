Ext.define('Filesystem.model.File',
	{
    extend: 'Ext.data.Model',
	name: 'File',
	
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
			name: "type",
			type: "string"
			},
			{
			name: "size",
			type: "int"
			},
			{
			name: "dateAccess",
			type: "string"
			},
			{
			name: "dateModify",
			type: "string"
			},
			{
			name: "dateCreate",
			type: "string"
			},
			{
			name: "extension",
			type: "string"
			},
			{
			name: "mode",
			type: "string"
			},
			{
			name: "uid",
			type: "string"
			},
			{
			name: "gid",
			type: "string"
			},
			{
			name: "content",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			create: '_api/Filesystem/FilesystemFileAdminController/create/',
			update: '_api/Filesystem/FilesystemFileAdminController/update/',
			destroy: '_api/Filesystem/FilesystemFileAdminController/destroy/',
			read: '_api/Filesystem/FilesystemFileAdminController/read/'
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