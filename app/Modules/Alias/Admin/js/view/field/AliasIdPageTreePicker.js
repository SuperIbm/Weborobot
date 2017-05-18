Ext.define('Alias.view.field.AliasIdPageTreePicker', 
	{
    extend: 'Admin.view.ux.TreePicker',
	xtype: "Alias.view.field.AliasIdPageTreePicker",
	
	store: Ext.create('Page.store.Page'),
	rootVisible: false,
	
	fieldLabel: "Страница:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	editable: true,
	forceSelection: true,
	
	name: "idPage",
	reference: "idPage",
	
	displayField: 'text',
	msgTarget: 'side',
		
		triggers:
		{
			clean: 
			{
			cls: "x-form-clean-trigger",
				handler: function()
				{
				this.setRawValue();	
				}
			}
		}
	}
);
	