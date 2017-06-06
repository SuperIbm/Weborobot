Ext.define('Publication.model.PublicationCommentTree',
	{
    extend: 'Ext.data.TreeModel',
	name: 'PublicationComment',
	
	idProperty: 'idPublicationComment',
	clientIdProperty: "idPublicationComment",
	
    	fields:
		[
			{
			name: "idPublicationComment",
			type: "int"
			},
			{
			name: "idPublication",
			type: "int"
			},
			{
			name: "idPublicationComment_referen",
			type: "int"
			},
			{
			name: "idUser",
			type: "int"
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
			create: '_api/Publication/PublicationCommentTreeAdminController/create/',
			update: '_api/Publication/PublicationCommentTreeAdminController/update/',
			destroy: '_api/Publication/PublicationCommentTreeAdminController/destroy/',
			read: '_api/Publication/PublicationCommentTreeAdminController/read/'
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