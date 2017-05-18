Ext.define('User.store.UserGroupSelect',
	{
	extend: 'User.store.UserGroup',
	model: 'User.model.UserGroup',
	
		requires:
		[
		"User.store.UserGroup"
		],
	
	pageSize: null
	}
);