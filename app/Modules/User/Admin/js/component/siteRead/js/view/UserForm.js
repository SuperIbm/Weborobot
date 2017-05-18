Ext.define('User.action.siteRead.view.UserForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.action.siteRead.view.UserForm',
	
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
				type: "User.action.siteRead.store.ComponentTemplateSelect"	
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
			xtype: 'treepicker',
			
			store: Ext.create('Page.store.Page'),
			rootVisible: false,
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: 'idPagePanel',
			fieldLabel: 'Страница кабинета:',
			
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
			
			name: 'idPageExit',
			fieldLabel: 'Страница выхода:',
			
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