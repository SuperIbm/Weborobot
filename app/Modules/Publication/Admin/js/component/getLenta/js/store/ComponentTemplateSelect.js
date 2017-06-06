Ext.define('Publication.component.getLenta.store.ComponentTemplateSelect',
	{
	extend: 'ComponentTemplate.store.ComponentTemplateSelect',
	alias: "store.Publication.component.getLenta.store.ComponentTemplateSelect",
		
		proxy:
		{
			extraParams:
			{
			nameComponent: "Publication"	
			}
		}
	}
);