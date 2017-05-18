Ext.define('Page.view.field.PageModeAccessComboBox', 
	{
    extend: 'Admin.view.ux.ComboBox',
	xtype: "Page.view.field.PageModeAccessComboBox",
	
	fieldLabel: "Доступ к странице:<span class='needsForm'>*</span>",
	
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
					"Наследовать"
					],
					[
					"Свободный"
					],
					[
					"Ограниченный"
					]
				]
			}
		),
	 
	displayField: "name",
	valueField: "name",
	name: "modeAccess",
	reference: "modeAccess",
	emptyText: "[Выберите доступ]",
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 1) == false) return "Нужно определить доступ!";
			else return true;
		}
	}
);
	