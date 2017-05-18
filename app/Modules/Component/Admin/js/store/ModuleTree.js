Ext.define('Component.store.ModuleTree',
	{
	extend: 'Ext.data.TreeStore',
	model: 'Component.model.ModuleTree',
	
		root:
		{
		allowDrop: false,
		text: "Все модули",
		expanded: true,
		icon: "engine/app/Modules/Module/Admin/images/icon_small.png",
		idModule: -1,
		leaf: false
		},
		
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
			read: '_api/Module/ModuleAdminController/tree/'
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