Ext.define('Admin.model.EnterForm',
	{
	extend: 'Ext.data.Model',
	
		fields: 
		[
		"login",
		"password",
		"remember"
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			create: '_api/Access/AccessAdminController/attempt/'
			},
			reader:
			{
			type: 'json',
			successProperty: 'success'
			},
			writer:
			{
			type: 'cgi',
			writeAllFields: true
			}
		}
	}
);