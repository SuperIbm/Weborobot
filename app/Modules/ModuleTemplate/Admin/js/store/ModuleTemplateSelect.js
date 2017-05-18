Ext.define('ModuleTemplate.store.ModuleTemplateSelect',
	{
	extend: 'Ext.data.Store',
	model: 'ModuleTemplate.model.ModuleTemplateSelect',
	
	pageSize: null,
		sorters:
		[
			{
			property: 'labelTemplate',
			direction: 'ASC'	
			}
		],
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
			read: '_api/ModuleTemplate/ModuleTemplateAdminController/read/'
			},
			reader:
			{
			type: 'json',
			rootProperty: "data",
			messageProperty: "errortype"
			}
		},
	
	autoLoad: true
	}
);