Ext.define('Page.store.PageTreeComponent',
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
		}
	}
);