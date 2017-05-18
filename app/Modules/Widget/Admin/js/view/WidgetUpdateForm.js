Ext.define('Widget.view.WidgetUpdateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Widget.view.WidgetUpdateForm',
	
		requires:
		[
		"Widget.view.field.WidgetIconText",
		"Widget.view.field.WidgetDefComboBox",
		"Widget.view.field.WidgetPathToCssText",
		"Widget.view.field.WidgetPathToJsText"
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
			xtype: "Widget.view.field.WidgetIconText"
			},
			{
			xtype: "Widget.view.field.WidgetDefComboBox"
			},
			{
			xtype: "Widget.view.field.WidgetPathToJsText"
			},
			{
			xtype: "Widget.view.field.WidgetPathToCssText"
			}
		]
	}
);