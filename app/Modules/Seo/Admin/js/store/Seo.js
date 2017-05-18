Ext.define('Seo.store.Seo',
	{
	extend: 'Ext.data.Store',
	model: 'Seo.model.Seo',
	
	autoLoad: true,
		proxy:
		{
		type: 'ajax',
			extraParams:
			{
			detalization: "По дням",
			date: "Месяц"
			},
			api:
			{
			read: '_api/Seo/SeoAdminController/read/'
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
			writeAllFields: false
			}
		}
	}
);