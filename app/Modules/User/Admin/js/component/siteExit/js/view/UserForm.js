Ext.define('User.action.siteExit.view.UserForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.action.siteExit.view.UserForm',
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[			
			{
			xtype: 'treepicker',
			
			store: Ext.create('Page.store.Page'),
			rootVisible: false,
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: 'idPageAction',
			reference: "idPageAction",
			
			fieldLabel: 'Страница после действий:',
			
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