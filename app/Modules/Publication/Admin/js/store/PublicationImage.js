Ext.define('Publication.store.PublicationImage',
	{
	extend: 'Ext.data.Store',
	model: 'Publication.model.PublicationImage',
	
	autoLoad: false,
		proxy:
		{
		type: 'ajax',
			api:
			{
			create: '_api/Publication/PublicationImageAdminController/create/',
			destroy: '_api/Publication/PublicationImageAdminController/destroy/',
			read: '_api/Publication/PublicationImageAdminController/read/'
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