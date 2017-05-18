Ext.define('Seo.component.get.store.ComponentTemplateSelect',
	{
	extend: 'ComponentTemplate.store.ComponentTemplateSelect',
	alias: "store.Seo.component.get.store.ComponentTemplateSelect",
		
		proxy:
		{
			extraParams:
			{
			nameComponent: "Seo"	
			}
		}
	}
);