Ext.define('AdminSection.store.AdminSection',
	{
	extend: 'Ext.data.Store',
	alias: 'store.AdminSection.store.AdminSection',
	model: 'AdminSection.model.AdminSection',
	
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'bundle',
			direction: 'ASC'	
			},
            {
            property: 'weight',
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
			update: '_api/AdminSection/AdminSectionAdminController/update/',
			read: '_api/AdminSection/AdminSectionAdminController/read/'
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