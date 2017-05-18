Ext.define('Page.view.field.PageShowInMenuComboBox', 
	{
    extend: 'Admin.view.ux.ComboBox',
	xtype: "Page.view.field.PageShowInMenuComboBox",
	
	fieldLabel: "Показывать в меню:<span class='needsForm'>*</span>",
	
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
					"Показывать"
					],
					[
					"Не показывать"
					],
					[
					"Только в карте сайта"
					]
				]
			}
		),
	 
	displayField: "name",
	valueField: "name",
	name: "showInMenu",
	reference: "showInMenu",
	emptyText: "[Выберите способ]",
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 1) == false) return "Вы должны определить статус!";
			else return true;
		}
	}
);
	