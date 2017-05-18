Ext.define('PageTemplate.store.PageTemplate',
	{
	extend: 'Ext.data.Store',
	model: 'PageTemplate.model.PageTemplate',
	storeId: "PageTemplate",
	
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'labelTemplate',
			direction: 'ASC'	
			}
		],
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
		noCache: false,
			api:
			{
			create: '_api/PageTemplate/PageTemplateAdminController/create/',
			update: '_api/PageTemplate/PageTemplateAdminController/update/',
			destroy: '_api/PageTemplate/PageTemplateAdminController/destroy/',
			read: '_api/PageTemplate/PageTemplateAdminController/read/'
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