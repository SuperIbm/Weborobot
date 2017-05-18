Ext.define('User.view.UserBlockIpCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserBlockIpCreateForm',
	
		requires:
		[
		"User.view.field.UserBlockIpIpText"
		],
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			},
			{
			xtype: "User.view.field.UserBlockIpIpText"
			}
		]
	}
);