Ext.define('User.action.siteForget.store.ComponentTemplateSelect',
	{
	extend: 'ComponentTemplate.store.ComponentTemplateSelect',
	alias: "store.User.action.siteForget.store.ComponentTemplateSelect",
	
		proxy:
		{
			extraParams:
			{
			nameComponent: "User"	
			}
		}
	}
);