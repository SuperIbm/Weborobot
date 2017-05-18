Ext.define('User.action.siteConfirm.view.UserForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.action.siteConfirm.view.UserForm',
	
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
				type: "User.action.siteConfirm.store.ComponentTemplateSelect"	
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
			}
		]
	}
);