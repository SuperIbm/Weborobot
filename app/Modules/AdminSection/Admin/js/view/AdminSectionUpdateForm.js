Ext.define('AdminSection.view.AdminSectionUpdateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.AdminSection.view.AdminSectionUpdateForm',
	
		requires:
		[
		"AdminSection.view.field.AdminSectionMenuLeftComboBox",
		"AdminSection.view.field.AdminSectionIconSmallText",
		"AdminSection.view.field.AdminSectionIconBigText",
		"AdminSection.view.field.AdminSectionPathToJsText",
		"AdminSection.view.field.AdminSectionPathToCssText"
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
			xtype: "AdminSection.view.field.AdminSectionMenuLeftComboBox"
			},
			{
			xtype: "AdminSection.view.field.AdminSectionIconSmallText"
			},
			{
			xtype: "AdminSection.view.field.AdminSectionIconBigText"
			},
			{
			xtype: "AdminSection.view.field.AdminSectionPathToJsText"
			},
			{
			xtype: "AdminSection.view.field.AdminSectionPathToCssText"
			}
		]
	}
);