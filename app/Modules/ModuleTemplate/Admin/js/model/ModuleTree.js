Ext.define('ModuleTemplate.model.ModuleTree',
	{
    extend: 'Ext.data.TreeModel',
	name: 'ModuleTree',
	
	idProperty: 'idModule',
	clientIdProperty: "idModule",
	
    	fields:
		[
			{
			name: "idModule",
			type: "string"
			},
			{
			name: "text",
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
			read: '_api/Module/ModuleAdminController/tree/'
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