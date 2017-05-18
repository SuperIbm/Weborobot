Ext.define('Infoblock.component.get.store.InfoblockSelect',
	{
	extend: 'Ext.data.Store',
	model: 'Infoblock.component.get.model.InfoblockSelect',
	
	pageSize: null,
		sorters:
		[
			{
			property: 'labelInfoblock',
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
		}
	}
);