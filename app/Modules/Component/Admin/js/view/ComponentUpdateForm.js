Ext.define('Component.view.ComponentUpdateForm',
	{
	extend: 'Ext.form.Panel',
	alias: 'widget.Component.view.ComponentUpdateForm',

        requires:
            [
			"Component.view.field.ComponentPathToJsText",
			"Component.view.field.ComponentPathToCssText"
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
			xtype: "Component.view.field.ComponentPathToJsText"
			},
			{
			xtype: "Component.view.field.ComponentPathToCssText"
			}
		]
	}
);