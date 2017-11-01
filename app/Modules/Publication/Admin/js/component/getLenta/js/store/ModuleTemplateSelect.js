Ext.define('Publication.component.getLenta.store.ModuleTemplateSelect',
	{
	extend: 'ModuleTemplate.store.ModuleTemplateSelect',
	alias: "store.Publication.component.getLenta.store.ModuleTemplateSelect",
		
		proxy:
		{
			extraParams:
			{
			nameModule: "Publication"
			}
		}
	}
);