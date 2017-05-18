Ext.define('User.store.UserRoleSelect',
	{
	extend: 'User.store.UserRole',
	model: 'User.model.UserRole',
	
		requires:
		[
		"User.store.UserRole"
		],
	
	pageSize: null
	}
);