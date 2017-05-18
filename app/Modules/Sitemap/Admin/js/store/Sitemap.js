Ext.define('Sitemap.store.Sitemap',
	{
	extend: 'Ext.data.Store',
	model: 'Sitemap.model.Sitemap',

		autoLoad:
		{
			callback: function(record, config, success)
			{
				if(success == false)
				{
					Ext.Msg.show
					(
						{
						title: "Ошибка!",
						msg: "Произошла ошибка выполнения программы на сервере!",
						icon: Ext.MessageBox.ERROR,
						buttons: Ext.MessageBox.OK
						}
					);
				}
			}
		},

		proxy:
		{
		type: 'ajax',
			api:
			{
			read: '_api/Sitemap/SitemapAdminController/read/',
			create: '_api/Sitemap/SitemapAdminController/create/'
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