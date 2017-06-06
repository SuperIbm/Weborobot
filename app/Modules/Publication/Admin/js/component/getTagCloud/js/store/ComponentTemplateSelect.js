Ext.define('Publication.component.getTagCloud.store.ComponentTemplateSelect',
	{
	extend: 'ComponentTemplate.store.ComponentTemplateSelect',
	alias: "store.Publication.component.getTagCloud.store.ComponentTemplateSelect",
		
		proxy:
		{
			extraParams:
			{
			nameComponent: "Publication"	
			}
		}
	}
);