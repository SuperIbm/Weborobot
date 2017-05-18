Ext.define('User.view.field.UserAccountStatusComboBox', 
	{
    extend: 'Admin.view.ux.ComboBox',
	xtype: "User.view.field.UserAccountStatusComboBox",
	
		store: new Ext.data.ArrayStore
		(
			{
				fields:
				[
				"name"
				],
				data:
				[
					[
					"Активен"
					],
					[
					"Не активен"
					],
					[
					"Не подтвержден"
					]
				]
			}
		),
		
	displayField: "name",
	valueField: "name",
	name: "status",
	reference: "status",
	emptyText: "Выберите статус",
	fieldLabel: "Статус:<span class='needsForm'>*</span>",
	
		validator: function(value)
		{					
			if(Weborobot.Util.isLength(value, 1) == false) return "Вы должны определить статус!";
			else return true;
		}
	}
);
	