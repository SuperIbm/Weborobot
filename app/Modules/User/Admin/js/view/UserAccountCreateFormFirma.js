Ext.define('User.view.UserAccountCreateFormFirma', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserAccountCreateFormFirma',
	itemId: "firma",
	
		requires:
		[
		"User.view.field.UserAccountOrganFormaText",
		"User.view.field.UserAccountOrganNameText",
		"User.view.field.UserAccountOrganAboutTextArea",
		"User.view.field.UserAccountSiteText"
		],
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "User.view.field.UserAccountOrganFormaText"
			},
			{
			xtype: "User.view.field.UserAccountOrganNameText"
			},
			{
			xtype: "User.view.field.UserAccountOrganAboutTextArea"
			},
			{
			xtype: "User.view.field.UserAccountSiteText"
			}	
		]
	}
);