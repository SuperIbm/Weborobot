Ext.define('PageTemplate.model.PageTemplate',
	{
    extend: 'Ext.data.Model',
	name: 'PageTemplate',
	idProperty: 'idPageTemplate',
	clientIdProperty: "idPageTemplate",
	
    	fields:
		[			
			{
			name: "idPageTemplate",
			type: "int"
			},
			{
			name: "idImage",
			type: "image"
			},
			{
			name: "labelTemplate",
			type: "string"
			},
			{
			name: "nameTemplate",
			type: "string"
			},
			{
			name: "countBlocks",
			type: "int"
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
			create: '_api/PageTemplate/PageTemplateAdminController/create/',
			update: '_api/PageTemplate/PageTemplateAdminController/update/',
			destroy: '_api/PageTemplate/PageTemplateAdminController/destroy/',
			read: '_api/PageTemplate/PageTemplateAdminController/read/'
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