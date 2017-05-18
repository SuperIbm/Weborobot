Ext.define('Filesystem.store.Dir',
	{
	extend: 'Ext.data.TreeStore',
	model: 'Filesystem.model.Dir',

        root:
        {
        name: "/",
        nameFull: "/",
        path: "/",
        pathFull: "/",
        expanded: true,
        leaf: false,
        icon: "engine/app/Modules/Admin/Admin/images/icon_folder.png",
        allowDrop: true
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
			api:
			{
			create: '_api/Filesystem/FilesystemDirAdminController/create/',
			update: '_api/Filesystem/FilesystemDirAdminController/update/',
			destroy: '_api/Filesystem/FilesystemDirAdminController/destroy/',
			read: '_api/Filesystem/FilesystemDirAdminController/read/'
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