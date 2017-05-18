Ext.define('User.view.UserGroupCreateUserRoleGrid', 
	{
    extend: 'User.view.UserRoleGrid',
	alias: 'widget.User.view.UserGroupCreateUserRoleGrid',
	
	store: "UserRoleSelect",
	
		requires:
		[
		'User.view.UserRoleGrid'
		],
	
		selModel:
		{
		mode: "MULTI",
		injectCheckbox: "first",
		allowDeselect: true	
		},
	
	selType: "checkboxmodel",
	dockedItems: null,
	border: true,
	
	dblclickUpdate: false,
	height: 350, 
	width: 400,
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить',
			itemId: 'refresh'
			}
		]
	}
);