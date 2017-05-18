Ext.define('Log.store.Log',
	{
	extend: 'Ext.data.Store',
	model: 'Log.model.Log',
	
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'date',
			direction: 'DESC'	
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
			api:
			{
			read: '_api/Log/LogAdminController/read/'
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