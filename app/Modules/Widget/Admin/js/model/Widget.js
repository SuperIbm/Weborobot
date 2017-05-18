Ext.define('Widget.model.Widget',
	{
    extend: 'Ext.data.Model',
	name: 'Widget',
	idProperty: 'idWidget',
	clientIdProperty: "idWidget",
	
    	fields:
		[			
			{
			name: "idWidget",
			type: "int"
			},
            {
			name: "actionWidget",
			type: "string"
            },
			{
			name: "labelWidget",
			type: "string"
			},
            {
            name: "labelModule",
            mapping: 'module.labelModule',
            type: "string"
            },
			{
			name: "icon",
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
			name: "def",
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
			create: '_api/Widget/WidgetAdminController/create/',
			update: '_api/Widget/WidgetAdminController/update/',
			read: '_api/Widget/WidgetAdminController/read/'
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