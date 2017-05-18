Ext.define('User.action.siteCreate.store.ComponentTemplateSelect',
	{
	extend: 'ComponentTemplate.store.ComponentTemplateSelect',
	alias: "store.User.action.siteCreate.store.ComponentTemplateSelect",
	
		proxy:
		{
			extraParams:
			{
			nameComponent: "User"	
			}
		}
	}
);