Ext.define('Publication.component.getByAction.store.ComponentTemplateSelect',
	{
	extend: 'ComponentTemplate.store.ComponentTemplateSelect',
	alias: "store.Publication.component.getByAction.store.ComponentTemplateSelect",
		
		proxy:
		{
			extraParams:
			{
			nameComponent: "Publication"	
			}
		}
	}
);