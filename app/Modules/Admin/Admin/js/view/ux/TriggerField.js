Ext.define("Admin.view.ux.TriggerField",
	{
	extend: "Ext.form.field.Text",
	xtype: "triggerFieldExt",
	alias: 'widget.triggerFieldExt',
	
	editable: false,
		initComponent: function()
		{
		this.callParent();
		var valueHide;
		
			this.getValueHide = function()
			{
			return valueHide;
			};
			
			this.setValueHide = function(valueNew)
			{
			valueHide = valueNew;
			return this;
			};
		},
		clickTrigger: function(id)
		{
		this.getTrigger(id).handler.call(this);
		}
	}
);