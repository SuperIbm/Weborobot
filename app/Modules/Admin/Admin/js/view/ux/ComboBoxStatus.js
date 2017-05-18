Ext.define("Admin.view.ux.ComboBoxStatus",
	{
	extend: "Admin.view.ux.ComboBox",
	alias: 'widget.comboBoxStatus',
	
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
					]
				]
			}
		),
		
	typeAhead: false,
	editable: false,
	selectOnFocus: false,
	forceSelection: false,
	
	displayField: "name",
	valueField: "name",
	name: "status",
	reference: "status",
	
		validator: function(value)
		{					
			if(Weborobot.Util.isLength(value, 1) == false) return this.errorMsg;
			else return true;
		}
	}
);