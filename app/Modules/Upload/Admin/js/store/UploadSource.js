Ext.define('Upload.store.UploadSource',
	{
	extend: 'Ext.data.Store',
	model: 'Upload.model.UploadSource',
	
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'login',
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
            create: '_api/Upload/UploadSourceAdminController/create/',
            update: '_api/Upload/UploadSourceAdminController/update/',
            destroy: '_api/Upload/UploadSourceAdminController/destroy/',
            read: '_api/Upload/UploadSourceAdminController/read/'
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