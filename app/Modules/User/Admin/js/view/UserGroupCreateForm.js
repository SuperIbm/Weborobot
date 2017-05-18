Ext.define('User.view.UserGroupCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserGroupCreateForm',
	
	name: "UserGroupCreateForm",
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
			xtype: "User.view.field.UserGroupNameGroupText"
			}
		]
	}
);