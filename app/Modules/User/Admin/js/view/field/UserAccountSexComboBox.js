Ext.define('User.view.field.UserAccountSexComboBox', 
	{
    extend: 'Admin.view.ux.ComboBox',
	xtype: "User.view.field.UserAccountSexComboBox",
	
		store: Ext.create("Ext.data.ArrayStore",
			{
				fields:
				[
				"name"
				],
				data:
				[
					[
					"Мужской"
					],
					[
					"Женский"
					]
				]
			}
		),
	displayField: "name",
	valueField: "name",
	
	name: "sex",
	ref: "sex",
	
	emptyText: "[Выберите пол]",
	fieldLabel: "Пол:"
	}
);
	