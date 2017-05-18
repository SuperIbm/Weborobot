Ext.define('User.view.UserAccountCreateGroupGrid', 
	{
	extend: 'User.view.UserGroupGrid',
	alias: 'widget.User.view.UserAccountCreateGroupGrid',
	
		requires:
		[
		"User.view.UserGroupGrid"
		],
	
	store: "UserGroupSelect",
	
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