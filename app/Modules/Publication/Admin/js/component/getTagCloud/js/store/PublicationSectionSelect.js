Ext.define('Publication.component.getTagCloud.store.PublicationSectionSelect',
	{
	extend: 'Ext.data.Store',
	model: 'Publication.component.getTagCloud.model.PublicationSectionSelect',
	
	pageSize: null,
		sorters:
		[
			{
			property: 'labelSection',
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