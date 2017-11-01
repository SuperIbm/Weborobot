Ext.define('Publication.component.getByAction.store.ModuleTemplateSelect',
	{
	extend: 'ModuleTemplate.store.ModuleTemplateSelect',
	alias: "store.Publication.component.getByAction.store.ModuleTemplateSelect",
		
		proxy:
		{
			extraParams:
			{
			nameModule: "Publication"
			}
		}
	}
);