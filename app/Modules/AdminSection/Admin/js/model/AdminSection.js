Ext.define('AdminSection.model.AdminSection',
	{
    extend: 'Ext.data.Model',
	name: 'AdminSection',
	idProperty: 'idAdminSection',
	clientIdProperty: "idAdminSection",
	
    	fields:
		[			
			{
			name: "idAdminSection",
			type: "string"
			},
			{
			name: "labelSection",
			type: "string"
			},
			{
			name: "nameModule",
			mapping: 'module.nameModule',
			type: "string"
			},
			{
			name: "iconSmall",
			type: "string"
			},
			{
			name: "iconBig",
			type: "string"
			},
			{
			name: "menuLeft",
			type: "string"
			},
			{
			name: "bundle",
			type: "string"
			},
			{
			name: "pathToCss",
			type: "string"
			},
			{
			name: "pathToJs",
			type: "string"
			},
			{
			name: "weight",
			type: "int"
			},
			{
			name: "isRead",
			type: "string",
                convert: function(value)
                {
                return value == "Да";
                }
			},
			{
			name: "isUpdate",
			type: "string",
                convert: function(value)
                {
                return value == "Да";
                }
			},
			{
			name: "isCreate",
			type: "string",
                convert: function(value)
                {
                return value == "Да";
                }
			},
			{
			name: "isDestroy",
			type: "string",
                convert: function(value)
                {
                return value == "Да";
                }
			}
		],
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
			update: '_api/AdminSection/AdminSectionAdminController/update/',
			read: '_api/AdminSection/AdminSectionAdminController/read/'
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