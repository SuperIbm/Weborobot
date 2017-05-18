Ext.define('Upload.store.Upload',
	{
	extend: 'Ext.data.Store',
	model: 'Upload.model.Upload',
	
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'labelModule',
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
			read: '_api/Upload/UploadAdminController/read/'
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