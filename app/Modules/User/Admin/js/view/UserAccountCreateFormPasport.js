Ext.define('User.view.UserAccountCreateFormPasport', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserAccountCreateFormPasport',
	itemId: "pasport",
	
		requires:
		[
		"User.view.field.UserAccountPassportSeriaAndNumberText",
		"User.view.field.UserAccountPassportWhoMadeText",
		"User.view.field.UserAccountPassportWhenMadeDatefield",
		"User.view.field.UserAccountPassportCodeSectionText",
		"User.view.field.UserAccountPassportAdressText"
		],
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "User.view.field.UserAccountPassportSeriaAndNumberText"
			},
			{
			xtype: "User.view.field.UserAccountPassportWhoMadeText"
			},
			{
			xtype: "User.view.field.UserAccountPassportWhenMadeDatefield"
			},
			{
			xtype: "User.view.field.UserAccountPassportCodeSectionText"
			},
			{
			xtype: "User.view.field.UserAccountPassportAdressText"
			}		
		]
	}
);