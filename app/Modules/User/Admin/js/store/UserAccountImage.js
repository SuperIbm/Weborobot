Ext.define('User.store.UserAccountImage',
	{
	extend: 'Ext.data.Store',
	model: 'User.model.UserAccountImage',
	
	autoLoad: false,
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