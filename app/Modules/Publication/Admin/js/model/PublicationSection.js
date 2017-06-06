Ext.define('Publication.model.PublicationSection',
	{
    extend: 'Ext.data.TreeModel',
	name: 'PublicationSection',
	
	idProperty: 'idPublicationSection',
	clientIdProperty: "idPublicationSection",
	
    	fields:
		[
			{
			name: "idPublicationSection",
			type: "string"
			},
			{
			name: "text",
			type: "string"
			},
			{
			name: "labelSection",
			type: "string"
			},
			{
			name: "expanded",
			type: "bool"
			},
			{
			name: "leaf",
			type: "bool"
			},
			{
			name: "icon",
			type: "string"
			},
			{
			name: "status",
			type: "string"
			}
		],
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