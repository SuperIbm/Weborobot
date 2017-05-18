Ext.define('User.view.UserAccountCreateFormPersonal', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserAccountCreateFormPersonal',
	itemId: "personal",
	
		requires:
		[
		"User.view.field.UserAccountFirstnameText",
		"User.view.field.UserAccountSecondnameText",
		"User.view.field.UserAccountLastnameText",
		"User.view.field.UserAccountEmailText",
		"User.view.field.UserAccountTelephoneText",
		"User.view.field.UserAccountSexComboBox",
		"User.view.field.UserAccountBirthdayDatefield",
		"User.view.field.UserAccountIcqText",
		"User.view.field.UserAccountSkypeText"
		],
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "User.view.field.UserAccountFirstnameText"
			},
			{
			xtype: "User.view.field.UserAccountSecondnameText"
			},
			{
			xtype: "User.view.field.UserAccountLastnameText"
			},
			{
			xtype: "User.view.field.UserAccountEmailText"
			},
			{
			xtype: "User.view.field.UserAccountTelephoneText"
			},
			{
			xtype: "User.view.field.UserAccountSexComboBox"
			},
			{
			xtype: "User.view.field.UserAccountBirthdayDatefield"
			},
			{
			xtype: "User.view.field.UserAccountIcqText"
			},
			{
			xtype: "User.view.field.UserAccountSkypeText"
			}
		]
	}
);