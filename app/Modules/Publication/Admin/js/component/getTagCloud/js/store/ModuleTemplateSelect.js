Ext.define('Publication.component.getTagCloud.store.ModuleTemplateSelect',
	{
	extend: 'ModuleTemplate.store.ModuleTemplateSelect',
	alias: "store.Publication.component.getTagCloud.store.ModuleTemplateSelect",
		
		proxy:
		{
			extraParams:
			{
			nameModule: "Publication"
			}
		}
	}
);