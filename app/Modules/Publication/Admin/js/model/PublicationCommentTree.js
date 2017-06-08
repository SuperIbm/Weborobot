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
			name: "idPublicationCommentReferen",
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
			dateFormat: "Y-m-d H:i:s"
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
			read: '_api/Publication/PublicationCommentAdminController/read/'
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