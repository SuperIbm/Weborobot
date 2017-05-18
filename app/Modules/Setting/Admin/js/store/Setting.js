Ext.define('Setting.store.Setting',
	{
	extend: 'Ext.data.Store',
	model: 'Setting.model.Setting',
	
	pageSize: null,
	
	autoLoad: false,
		proxy:
		{
		type: 'ajax',
			api:
			{
			update: '_api/Setting/SettingAdminController/update/',
			read: '_api/Setting/SettingAdminController/read/'
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