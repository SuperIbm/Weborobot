Ext.define('Publication.component.getByAction.view.PublicationForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Publication.component.getByAction.view.PublicationForm',
	
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
				type: "Publication.component.getByAction.store.ComponentTemplateSelect"
				},
				
			triggerReload: true,
				
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
			
			store: "PublicationSectionSelect",
			triggerReload: true,
			
			valueField: "idPublicationSection",
			displayField: "labelSection",
			
			name: "idPublicationSection",
			reference: "idPublicationSection",
			emptyText: "[Выберите раздел]",
			fieldLabel: "Раздел:<span class='needsForm'>*</span>",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Вы должны выбрать раздел!";
					else return true;
				}
			},
			{
			xtype: "comboBoxExt",
			
				store: new Ext.data.ArrayStore
				(
					{
						fields:
						[
						"id",
						"name"
						],
						data:
						[
							[
							1,												 
							"Да"
							],
							[
							0,
							"Нет"
							],
						]
					}
				),
			
			valueField: "id",
			displayField: "name",
			
			name: "showDate",
			reference: "showDate",
			emptyText: "[Выберите статус]",
			fieldLabel: "Показывать дату:<span class='needsForm'>*</span>",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Вы должны определить это поле!";
					else return true;
				}
			},
			{
			xtype: 'treepicker',

			store: Ext.create('Page.store.Page'),
			rootVisible: false,
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: 'idPageArchive',
			reference: "idPageArchive",
			
			fieldLabel: 'Страница архива:',
			
			displayField: 'text',
			msgTarget: 'side',
				triggers:
				{
					clean: 
					{
					cls: "x-form-clean-trigger",
						handler: function()
						{
						this.reset();	
						}
					}
				}
			},
			{
			xtype: 'treepicker',

			store: Ext.create('Page.store.Page'),
			rootVisible: false,
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: 'idPagePublication',
			reference: "idPagePublication",
			
			fieldLabel: 'Страница публикации:',
			
			displayField: 'text',
			msgTarget: 'side',
				triggers:
				{
					clean: 
					{
					cls: "x-form-clean-trigger",
						handler: function()
						{
						this.reset();	
						}
					}
				}
			}
		]
	}
);