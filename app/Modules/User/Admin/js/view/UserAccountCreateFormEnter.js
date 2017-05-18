Ext.define('User.view.UserAccountCreateFormEnter', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserAccountCreateFormEnter',
	itemId: "enter",
	
		requires:
		[
		"User.view.field.UserAccountStatusComboBox",
		"User.view.field.UserAccountLoginText",
		"User.view.field.UserAccountPasswordTriggerFieldGeneratePassword"
		],
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "User.view.field.UserAccountStatusComboBox"
			},
			{
			xtype: "User.view.field.UserAccountLoginText"
			},
			{
			xtype: "User.view.field.UserAccountPasswordTriggerFieldGeneratePassword"
			}
		]
	}
);