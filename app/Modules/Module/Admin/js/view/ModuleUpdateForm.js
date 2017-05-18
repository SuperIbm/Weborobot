Ext.define('Module.view.ModuleUpdateForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Module.view.ModuleUpdateForm',
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			}
		]
	}
);