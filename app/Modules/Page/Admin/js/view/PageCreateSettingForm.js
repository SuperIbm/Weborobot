Ext.define('Page.view.PageCreateSettingForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Page.view.PageCreateSettingForm',
	
		requires:
		[
		"Page.view.field.PageShowInMenuComboBox",
		"Page.view.field.PageModeAccessComboBox",
		"Page.view.field.PageNamePageText",
		"Page.view.field.PageNameLinkText",
		"Page.view.field.PageTitleText",
		"Page.view.field.PageKeywordsText",
		"Page.view.field.PageDescriptionText",
		"Page.view.field.PageRedirectText"
		],
	
	name: "Page",
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
			xtype: "Page.view.field.PageShowInMenuComboBox"
			},
			{
			xtype: "Page.view.field.PageModeAccessComboBox"
			},
			{
			xtype: "Page.view.field.PageNamePageText",
			
				listeners:
				{
					change: function(input, newValue, oldValue, eOpts)
					{
					input.up("window").down("textfield[name='nameLink']").setValue(Weborobot.Util.toLatin(newValue).toLowerCase());
					}
				}
			},
			{
			xtype: "Page.view.field.PageNameLinkText"
			},
			{
			xtype: "Page.view.field.PageTitleText"
			},
			{
			xtype: "Page.view.field.PageKeywordsText"
			},
			{
			xtype: "Page.view.field.PageDescriptionText"
			},
			{
			xtype: "Page.view.field.PageRedirectText"
			}
		]
	}
);