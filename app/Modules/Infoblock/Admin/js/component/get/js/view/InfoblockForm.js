Ext.define('Infoblock.component.get.view.InfoblockForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Infoblock.component.get.view.InfoblockForm',
	
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
				type: "Infoblock.component.get.model.ModuleTemplateSelect"
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
			autoLoadOnValue: true,
			
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
			
			store: "InfoblockSelect",
			triggerReload: true,
			
			valueField: "idInfoblock",
			displayField: "labelInfoblock",
			
			name: "idInfoblock",
			reference: "idInfoblock",
			emptyText: "[Выберите блок кода]",
			fieldLabel: "Блок кода:<span class='needsForm'>*</span>",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Вы должны выбрать блок кода!";
					else return true;
				}
			}
		]
	}
);