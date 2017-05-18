Ext.define('User.view.UserAccountCreateFormAdress', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserAccountCreateFormAdress',
	itemId: "adress",
	
		requires:
		[
		"User.view.field.UserAccountZipText",
		"User.view.field.UserAccountCountryText",
		"User.view.field.UserAccountCityText",
		"User.view.field.UserAccountStreetText"
		],
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "User.view.field.UserAccountZipText"
			},
			{
			xtype: "User.view.field.UserAccountCountryText"
			},
			{
			xtype: "User.view.field.UserAccountCityText"
			},
			{
			xtype: "User.view.field.UserAccountStreetText"
			}			
		]
	}
);