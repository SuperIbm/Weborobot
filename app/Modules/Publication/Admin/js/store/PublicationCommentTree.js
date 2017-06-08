Ext.define('Publication.store.PublicationCommentTree',
	{
	extend: 'Ext.data.TreeStore',
	model: 'Publication.model.PublicationCommentTree',
		
	autoLoad: false,

		root:
		{
		allowDrop: false,
		expanded: false,
		leaf: false,
		icon: "app/Modules/Admin/Admin/images/icon_folder.png",
		idPublicationComment: 0,
		name: "Все комментарии"
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
			read: '_api/Publication/PublicationCommentTreeAdminController/tree/'
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