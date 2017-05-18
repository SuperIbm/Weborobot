Ext.define('Alias.view.AliasCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Alias.view.AliasCreateForm',
	
		requires:
		[
		"Alias.view.field.AliasPatternText",
		"Alias.view.field.AliasIdPageTreePicker"
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
			xtype: "Alias.view.field.AliasPatternText"
			},
			{
			xtype: "Alias.view.field.AliasIdPageTreePicker"
			}
		]
	}
);