Ext.define('Setting.model.Setting',
	{
    extend: 'Ext.data.Model',
	
	name: 'Setting',
	idProperty: 'id',
	clientIdProperty: "id",
	
    	fields:
		[			
			{
			name: "id",
			type: "string"
			},
			{
			name: "APP_NAME",
			type: "string"
			},
			{
			name: "MAIL_TO_ADDRESS",
			type: "string"
			},
			{
			name: "MAIL_FROM_ADDRESS",
			type: "string"
			},
			{
			name: "APP_SITE_RECONSTRUCTION",
			type: "string"
			},
			{
			name: "APP_CSS",
			type: "string"
			},
			{
			name: "APP_TIMEZONE",
			type: "string"
			},
            {
			name: "APP_LOCALE",
			type: "string"
            }
		],
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