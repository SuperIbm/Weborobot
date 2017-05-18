Ext.define('Infoblock.component.get.store.ModuleTemplateSelect',
	{
	extend: 'ModuleTemplate.store.ModuleTemplateSelect',
	alias: "store.Infoblock.component.get.model.ModuleTemplateSelect",
	
		proxy:
		{
			extraParams:
			{
			nameModule: "Infoblock"
			}
		}
	}
);