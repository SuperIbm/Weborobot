Ext.define("Admin.view.ux.ComboBox",
	{
	extend: "Ext.form.field.ComboBox",
	alias: 'widget.comboBoxExt',
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	queryMode: 'local',
	
	typeAhead: true,
	editable: true,
	forceSelection: true,
	selectOnFocus: true,
	triggerAction: "all",
	msgTarget: 'side',
	
		initComponent: function()
		{
		this.callParent();
		
			this.setTriggers
			(
				{
					reload: 
					{
					cls: 'reload',
					cls: 'x-form-load-trigger',
					hidden: this.triggerReload == true ? false : true,	
						handler: function() 
						{
						this.getStore().load()
						}
					},
					picker: 
					{
					handler: 'onTriggerClick',
					scope: 'this'
					}
				}
			);
		}
	}
);