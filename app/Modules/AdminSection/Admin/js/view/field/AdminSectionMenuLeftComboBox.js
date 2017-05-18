Ext.define('AdminSection.view.field.AdminSectionMenuLeftComboBox', 
	{
    extend: 'Admin.view.ux.ComboBox',
	xtype: "AdminSection.view.field.AdminSectionMenuLeftComboBox",
	
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
					"Да"
					],
					[
					"Нет"
					]
				]
			}
		),
	fieldLabel: "Меню левое:<span class='needsForm'>*</span>", 
	displayField: "name",
	valueField: "name",
	name: "menuLeft",
	reference: "menuLeft",
	emptyText: "[Выберите статус]",
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 1) == false) return "Вы должны определить статус!";
			else return true;
		}
	}
);
	