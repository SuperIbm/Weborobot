Ext.define('Publication.store.Publication',
	{
	extend: 'Ext.data.Store',
	model: 'Publication.model.Publication',
	
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'dateAdd',
			direction: 'ASC'
			},
			{
			property: 'publication.idPublication',
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
			create: '_api/Publication/PublicationAdminController/create/',
			update: '_api/Publication/PublicationAdminController/update/',
			destroy: '_api/Publication/PublicationAdminController/destroy/',
			read: '_api/Publication/PublicationAdminController/read/'
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