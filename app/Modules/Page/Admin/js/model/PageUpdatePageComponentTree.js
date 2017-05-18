Ext.define('Page.model.PageUpdatePageComponentTree',
	{
    extend: 'Ext.data.TreeModel',
	name: 'Page',
	
	idProperty: 'id',
	clientIdProperty: "id",
	
    	fields:
		[
			{
			name: "id",
			type: "string"
			},
            {
			name: "idPageComponent",
			type: "int"
            },
			{
			name: "idComponent",
			type: "int"
			},
			{
			name: "idPage",
			type: "int"
			},
			{
			name: "numberBlock",
			type: "int"
			},
			{
			name: "weight",
			type: "int"
			}
		],
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
			read: '_api/PageComponent/PageComponentAdminController/tree/',
			destroy: '_api/PageComponent/PageComponentAdminController/destroy/'
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