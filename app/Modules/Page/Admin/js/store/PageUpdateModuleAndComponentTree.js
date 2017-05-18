Ext.define('Page.store.PageUpdateModuleAndComponentTree',
	{
	extend: 'Ext.data.TreeStore',
	model: 'Page.model.PageUpdateModuleAndComponentTree',
		
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
			read: '_api/Module/ModuleAndComponentAdminController/tree/'
			},
			reader:
			{
			type: 'json',
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