Ext.define('Filesystem.store.File',
	{
	extend: 'Ext.data.Store',
	model: 'Filesystem.model.File',
	
		sorters:
		[
			{
			property: 'type',
			direction: 'ASC'	
			},
			{
			property: 'nameFull',
			direction: 'ASC'	
			}
		],
	
	autoLoad: false,
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