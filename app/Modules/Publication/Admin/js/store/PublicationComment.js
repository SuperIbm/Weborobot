Ext.define('Publication.store.PublicationComment',
	{
	extend: 'Ext.data.Store',
	model: 'Publication.model.PublicationComment',
		
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,

		sorters:
		[
			{
			property: 'dateAdd',
			direction: 'DESC'
			},
            {
			property: 'publicationComment.idPublicationComment',
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
			create: '_api/Publication/PublicationCommentTreeAdminController/create/',
			update: '_api/Publication/PublicationCommentTreeAdminController/update/',
			destroy: '_api/Publication/PublicationCommentTreeAdminController/destroy/',
			read: '_api/Publication/PublicationCommentAdminController/read/'
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