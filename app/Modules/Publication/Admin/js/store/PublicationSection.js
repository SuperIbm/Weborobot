Ext.define('Publication.store.PublicationSection',
	{
	extend: 'Ext.data.TreeStore',
	model: 'Publication.model.PublicationSection',
	
		root:
		{
		allowDrop: false,
		text: "Все разделы",
		labelSection: "Все разделы",
		expanded: true,
		icon: "app/Modules/Admin/Admin/images/icon_folder.png",
		idPublicationSection: -1,
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
			create: '_api/Publication/PublicationSectionAdminController/create/',
			update: '_api/Publication/PublicationSectionAdminController/update/',
			destroy: '_api/Publication/PublicationSectionAdminController/destroy/',
			read: '_api/Publication/PublicationSectionAdminController/tree/'
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