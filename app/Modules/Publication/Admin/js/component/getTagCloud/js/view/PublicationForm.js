Ext.define('Publication.component.getTagCloud.view.PublicationForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Publication.component.getTagCloud.view.PublicationForm',
	
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
				type: "Publication.component.getTagCloud.store.ModuleTemplateSelect"
				},
				
			triggerReload: true,
				
			valueField: "idModuleTemplate",
			displayField: "labelTemplate",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "idModuleTemplate",
			reference: "idModuleTemplate",
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
			xtype: "numberfield",
			fieldLabel: "Количество на страницу:",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "limit",
			reference: "limit",
			
				validator: function(value)
				{
					if(Weborobot.Util.isInteger(value, true, 0, 4) == false)
					return "Количество на страницу должно содержать положительное целое число!";
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
			fieldLabel: 'Страница архива:',
			
			displayField: 'text',
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
			fieldLabel: 'Страница публикации:',
			
			displayField: 'text',
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