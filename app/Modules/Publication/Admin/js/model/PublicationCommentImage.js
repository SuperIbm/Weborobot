Ext.define('Publication.model.PublicationCommentImage',
	{
    extend: 'Ext.data.Model',
	name: 'PublicationCommentImage',
	
	idProperty: 'idImage',
	clientIdProperty: "idImage",
	
    	fields:
		[			
			{
			name: "idImage",
			type: "int"
			},
			{
			name: "format",
			type: "string"
			},
			{
			name: "path",
			type: "string"
			},
			{
			name: "width",
			type: "int"
			},
			{
			name: "height",
			type: "int"
			}
		],
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