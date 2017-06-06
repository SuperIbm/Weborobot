Ext.define('Publication.store.PublicationCommentImage',
	{
	extend: 'Ext.data.Store',
	model: 'Publication.model.PublicationCommentImage',
	
	autoLoad: false,
		proxy:
		{
		type: 'ajax',
			api:
			{
			create: '_api/Publication/PublicationCommentImageAdminController/create/',
			destroy: '_api/Publication/PublicationCommentImageAdminController/destroy/',
			read: '_api/Publication/PublicationCommentImageAdminController/read/'
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