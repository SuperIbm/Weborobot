Ext.define('ModuleTemplate.store.ModuleTemplate',
	{
	extend: 'Ext.data.Store',
	model: 'ModuleTemplate.model.ModuleTemplate',
	
	pageSize: 20,
	remoteSort: true,
	remoteFilter: true,
		sorters:
		[
			{
			property: 'labelTemplate',
			direction: 'ASC'	
			}
		],
	autoLoad: true,
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
			create: '_api/ModuleTemplate/ModuleTemplateAdminController/create/',
			update: '_api/ModuleTemplate/ModuleTemplateAdminController/update/',
			destroy: '_api/ModuleTemplate/ModuleTemplateAdminController/destroy/',
			read: '_api/ModuleTemplate/ModuleTemplateAdminController/read/'
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