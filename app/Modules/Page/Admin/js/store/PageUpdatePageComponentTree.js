Ext.define('Page.store.PageUpdatePageComponentTree',
	{
	extend: 'Ext.data.TreeStore',
	model: 'Page.model.PageUpdatePageComponentTree',
	autoLoad: false,
		
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