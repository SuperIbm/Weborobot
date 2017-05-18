Ext.define('Infoblock.store.Infoblock',
	{
	extend: 'Ext.data.Store',
	model: 'Infoblock.model.Infoblock',
	
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'labelInfoblock',
			direction: 'ASC'	
			}
		],
		autoLoad: false,
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