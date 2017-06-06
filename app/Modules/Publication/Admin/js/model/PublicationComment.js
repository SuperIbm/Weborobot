Ext.define('Publication.model.PublicationComment',
	{
    extend: 'Ext.data.Model',
	name: 'PublicationComment',
	
	idProperty: 'idPublicationComment',
	clientIdProperty: "idPublicationComment",
	
    	fields:
		[
			{
			name: "idPublicationComment",
			type: "string"
			},
			{
			name: "idPublication",
			type: "string"
			},
			{
			name: "idPublicationComment_referen",
			type: "string"
			},
			{
			name: "idUser",
			type: "string"
			},
			{
			name: "idImageBig",
			type: "image"
			},
			{
			name: "idImageMiddle",
			type: "image"
			},
			{
			name: "idImageSmall",
			type: "image"
			},
			{
			name: "name",
			type: "string"
			},
			{
			name: "email",
			type: "string"
			},
			{
			name: "url",
			type: "string"
			},
			{
			name: "comment",
			type: "string",
				convert: function(value)
				{
				return Weborobot.Util.parserBr2Rn(value);
				}
			},
			{
			name: "dateAdd",
			type: "date",
			dateFormat: "d.m.Y H:i:s"
			},
			{
			name: "timeAdd",
			type: "date",
			dateFormat: "H:i:s"
			},
			{
			name: "ip",
			type: "string"
			},
			{
			name: "currentNode",
			type: "bool"
			},
			{
			name: "currentBranch",
			type: "bool"
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
			create: '_api/Publication/PublicationCommentAdminController/create/',
			update: '_api/Publication/PublicationCommentAdminController/update/',
			destroy: '_api/Publication/PublicationCommentAdminController/destroy/',
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