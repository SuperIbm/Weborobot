Ext.define('Publication.model.PublicationImage',
	{
    extend: 'Ext.data.Model',
	name: 'PublicationImage',
	
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