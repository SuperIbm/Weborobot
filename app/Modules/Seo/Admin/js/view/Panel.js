Ext.define('Seo.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Seo.view.Panel',
	
	title: "Статистика посещения",
	icon: Admin.getApplication().Section.get("Seo")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Seo.view.SeoTab"
			}
		],
		tbar:
		[
			{
			xtype: "comboBoxExt",
			fieldLabel: "Период:",
	
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
							"Весь срок"
							],
							[
							"Сегодня"
							],
							[
							"Вчера"
							],
							[
							"Неделя"
							],
							[
							"Месяц"
							],
							[
							"Квартал"
							],
							[
							"Год"
							]
						]
					}
				),
			 
			displayField: "name",
			valueField: "name",
			name: "period",
			reference: "period",
			emptyText: "[Выберите период]",
			labelSeparator: "",
			labelWidth: 60,
			width: 220,
			value: "Месяц",
				listeners:
				{
					change: function(datefield, newValue, oldValue, eOpts)
					{
						if(newValue != oldValue)
						{
						var Dt = new Date();
						var DateFrom = datefield.up("panel").down("datefield[reference='dateFrom']");
						var DateTo = datefield.up("panel").down("datefield[reference='dateTo']");
						
							if(newValue == "Сегодня")
							{
							DateFrom.setValue(Ext.Date.format(Dt, "d.m.Y"));	
							DateTo.setValue(Ext.Date.format(Dt, "d.m.Y"));
							}
							else if(newValue == "Вчера")
							{
							Dt = Ext.Date.add(Dt, Ext.Date.DAY, -1);	
							
							DateTo.setValue(Ext.Date.format(Dt, "d.m.Y"));
							DateFrom.setValue(Ext.Date.format(Dt, "d.m.Y"))
							}
							else if(newValue == "Неделя")
							{							
							DateTo.setValue(Ext.Date.format(Dt, "d.m.Y"));
							
							Dt = Ext.Date.add(Dt, Ext.Date.DAY, -7);	
							DateFrom.setValue(Ext.Date.format(Dt, "d.m.Y"))
							}
							else if(newValue == "Месяц")
							{							
							DateTo.setValue(Ext.Date.format(Dt, "d.m.Y"));
							
							Dt = Ext.Date.add(Dt, Ext.Date.MONTH, -1);	
							DateFrom.setValue(Ext.Date.format(Dt, "d.m.Y"))
							}
							else if(newValue == "Квартал")
							{							
							DateTo.setValue(Ext.Date.format(Dt, "d.m.Y"));
							
							Dt = Ext.Date.add(Dt, Ext.Date.MONTH, -3);
							DateFrom.setValue(Ext.Date.format(Dt, "d.m.Y"))
							}
							else if(newValue == "Год")
							{							
							DateTo.setValue(Ext.Date.format(Dt, "d.m.Y"));
								
							Dt = Ext.Date.add(Dt, Ext.Date.YEAR, -1);
							DateFrom.setValue(Ext.Date.format(Dt, "d.m.Y"))
							}
							else
							{
							DateFrom.setValue("");
							DateTo.setValue("");	
							}
						}
						
					return true;
					}
				}
			},
			"-",
			{
			xtype: "datefield",
			fieldLabel: "С:",
			labelSeparator: "",
			labelWidth: 25,
			width: 160,
			name: "dateFrom",
			reference: "dateFrom",
			format: "d.m.Y",
			value: Ext.Date.format(Ext.Date.add(new Date(), Ext.Date.MONTH, -1), "d.m.Y"),
				listeners:
				{
					select: function(datefield, value, eOpts)
					{
					datefield.up("panel").down("comboBoxExt[reference='period']").setRawValue(null);		
					return true;
					}
				}
			},
			{
			xtype: "datefield",
			fieldLabel: "по:",
			labelSeparator: "",
			labelWidth: 25,
			width: 160,
			name: "dateTo",
			reference: "dateTo",
			format: "d.m.Y",
			value: Ext.Date.format(new Date(), "d.m.Y"),
				listeners:
				{
					select: function(datefield, value, eOpts)
					{
					datefield.up("panel").down("comboBoxExt[reference='period']").setRawValue(null);		
					return true;
					}
				}
			},
			"->",
			{
			xtype: "comboBoxExt",
			fieldLabel: "Детализация:",
	
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
							"По дням"
							],
							[
							"По неделям"
							],
							[
							"По месяцам"
							],
							[
							"За весь срок"
							]
						]
					}
				),
			 
			displayField: "name",
			valueField: "name",
			name: "detalization",
			reference: "detalization",
			emptyText: "По дням",
			labelSeparator: "",
			labelWidth: 90,
			width: 220,
			value: "По дням"
			}
		],
		initComponent: function()
		{
			this.tools = 
			[
				{
				type: 'refresh',
				tooltip: 'Обновить',
				itemId: 'refresh'
				}
			];
		
		this.callParent();	
		}
	}
);
