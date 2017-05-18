Ext.define('User.action.siteConfirm.store.ComponentTemplateSelect',
	{
	extend: 'ComponentTemplate.store.ComponentTemplateSelect',
	alias: "store.User.action.siteConfirm.store.ComponentTemplateSelect",
	
		proxy:
		{
			extraParams:
			{
			nameComponent: "User"	
			}
		}
	}
);