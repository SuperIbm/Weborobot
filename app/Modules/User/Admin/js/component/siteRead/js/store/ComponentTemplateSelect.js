Ext.define('User.action.siteRead.store.ComponentTemplateSelect',
	{
	extend: 'ComponentTemplate.store.ComponentTemplateSelect',
	alias: "store.User.action.siteRead.store.ComponentTemplateSelect",
	
		proxy:
		{
			extraParams:
			{
			nameComponent: "User"	
			}
		}
	}
);