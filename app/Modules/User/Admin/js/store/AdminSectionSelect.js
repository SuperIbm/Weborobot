Ext.define('User.store.AdminSectionSelect',
	{
	extend: 'AdminSection.store.AdminSection',
	alias: 'store.User.store.AdminSectionSelect',
	model: 'AdminSection.model.AdminSection',
	
		requires:
		[
		'AdminSection.model.AdminSection',
		'AdminSection.store.AdminSection'
		],
	
	pageSize: null,
	remoteSort: false,
	remoteFilter: false,
	
		sorters:
		[
			{
			property: 'bundle',
			direction: 'ASC'	
			}
		],
	
	autoLoad: false
	}
);