Ext.define('Component.store.Component',
	{
	extend: 'Ext.data.Store',
	model: 'Component.model.Component',
	
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'labelComponent',
			direction: 'ASC'	
			}
		],
	autoLoad: true,
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
			create: '_api/Component/ComponentAdminController/create/',
			update: '_api/Component/ComponentAdminController/update/',
			read: '_api/Component/ComponentAdminController/read/'
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