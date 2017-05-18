Ext.define('Robots.store.Robots',
	{
	extend: 'Ext.data.Store',
	model: 'Robots.model.Robots',

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
			read: '_api/Robots/RobotsAdminController/read/',
			create: '_api/Robots/RobotsAdminController/create/'
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