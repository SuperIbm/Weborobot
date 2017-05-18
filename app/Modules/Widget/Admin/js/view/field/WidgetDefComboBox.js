Ext.define('Widget.view.field.WidgetDefComboBox', 
	{
    extend: 'Admin.view.ux.ComboBox',
	xtype: "Widget.view.field.WidgetDefComboBox",
	
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
	fieldLabel: "По умолчанию:<span class='needsForm'>*</span>", 
	displayField: "name",
	valueField: "name",
	name: "def",
	reference: "def",
	emptyText: "[Выберите статус]",
		validator: function(value)
		{
			if(Weborobot.Util.isLength(value, 1) == false) return "Вы должны определить статус!";
			else return true;
		}
	}
);
	