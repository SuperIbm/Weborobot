Ext.define('Infoblock.view.InfoblockCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Infoblock.view.InfoblockCreateForm',
	
		requires:
		[
		"Infoblock.view.field.InfoblockLabelInfoblockText"
		],
	
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
			xtype: "Infoblock.view.field.InfoblockLabelInfoblockText"
			}
		]
	}
);