Ext.define('Publication.model.Publication',
	{
    extend: 'Ext.data.Model',
	name: 'Publication',
	
	idProperty: 'idPublication',
	clientIdProperty: "idPublication",
	
    	fields:
		[			
			{
			name: "idPublication",
			type: "int"
			},
			{
			name: "idPublicationSection",
			type: "int"
			},
			{
			name: "labelSection",
			mapping: "publicationsection.labelSection"
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
			name: "dateAdd",
			type: "date",
			dateFormat: "Y-m-d H:i:s"
			},
			{
			name: "title",
			type: "string"
			},
			{
			name: "anons",
			type: "string",
				convert: function(value)
				{
				return Weborobot.Util.parserBr2Rn(value);
				}
			},
			{
			name: "queryWords",
                convert: function(value)
                {
                var queryWords = "";

                    if(value)
                    {
                        for(var i = 0; i < value.length; i++)
                        {
                            if(queryWords != "") queryWords += ", ";

                        queryWords += value[i]['queryWord'];
                        }
                    }

                return queryWords;
                }
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
			create: '_api/Publication/PublicationAdminController/create/',
			update: '_api/Publication/PublicationAdminController/update/',
			destroy: '_api/Publication/PublicationAdminController/destroy/',
			read: '_api/Publication/PublicationAdminController/read/'
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