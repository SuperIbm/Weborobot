Ext.define('Seo.component.get.view.SeoForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Seo.component.get.view.SeoForm',
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxExt",
			
				store:
				{
				type: "Seo.component.get.store.ComponentTemplateSelect"
				},
				
			valueField: "idComponentTemplate",
			displayField: "labelTemplate",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "idComponentTemplate",
			reference: "idComponentTemplate",
			emptyText: "[Выберите шаблон]",
			fieldLabel: "Шаблон:<span class='needsForm'>*</span>",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Вы должны выбрать шаблон!";
					else return true;
				}
			},
			{
			xtype: "comboBoxExt",
			fieldLabel: "Период:<span class='needsForm'>*</span>",
	
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
			labelWidth: 160,
			width: 450,
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Вы должны выбрать период!";
					else return true;
				}
			},
			{
			xtype: "comboBoxExt",
			fieldLabel: "Детализация:<span class='needsForm'>*</span>",
	
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
			emptyText: "[Выберите детализацию]",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Вы должны выбрать детализацию!";
					else return true;
				}
			}
		]
	}
);