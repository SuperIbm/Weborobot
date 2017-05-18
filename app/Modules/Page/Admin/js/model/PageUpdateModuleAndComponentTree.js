Ext.define('Page.model.PageUpdateModuleAndComponentTree',
	{
    extend: 'Ext.data.TreeModel',
	name: 'TreeModel',
	
	idProperty: 'idComponent',
	clientIdProperty: "idComponent",
	
    	fields:
		[
			{
			name: "idComponent",
			type: "string"
			},
			{
			name: "nameModule",
			type: "string"
			},
			{
			name: "labelModule",
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
			read: '_api/Module/ModuleAndComponentAdminController/tree/'
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