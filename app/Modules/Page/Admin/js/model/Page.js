Ext.define('Page.model.Page',
	{
    extend: 'Ext.data.TreeModel',
	name: 'Page',
	
	idProperty: 'idPage',
	clientIdProperty: "idPage",
	
    	fields:
		[
			{
			name: "idPage",
			type: "string"
			},
			{
			name: "text",
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
			name: "path",
			type: "string"
			},
			{
			name: "nameLink",
			type: "string"
			},
			{
			name: "isMeetsEdit",
			type: "int"
			},
			{
			name: "description",
			type: "string"
			},
			{
			name: "keywords",
			type: "string"
			},
			{
			name: "title",
			type: "string"
			},
			{
			name: "html",
			type: "string"
			},
			{
			name: "weight",
			type: "int"
			},
			{
			name: "showInMenu",
			type: "string"
			},
			{
			name: "modeAccess",
			type: "string"
			},
			{
			name: "redirect",
			type: "string"
			},
			{
			name: "dateEdit",
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
			create: '_api/Page/PageAdminController/create/',
			update: '_api/Page/PageAdminController/update/',
			destroy: '_api/Page/PageAdminController/destroy/',
			read: '_api/Page/PageAdminController/tree/'
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