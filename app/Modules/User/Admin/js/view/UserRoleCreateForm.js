Ext.define('User.view.UserRoleCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserRoleCreateForm',
	
		requires:
		[
		"User.view.field.UserRoleNameRoleText"
		],
	
	name: "User",
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			},
			{
			xtype: "User.view.field.UserRoleNameRoleText"
			}
		]
	}
);