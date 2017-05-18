Ext.define("Admin.view.ux.TriggerFieldGeneratePassword",
	{
	extend: "Admin.view.ux.TriggerField",
	xtype: "triggerFieldGeneratePassword",
	alias: 'widget.triggerFieldGeneratePassword',
	
		requires:
		[
		"Admin.view.ux.TriggerField"
		],
	
	editable: true,
		triggers:
		{
			searcher:
			{
			cls: 'x-form-random-trigger',
				handler: function()
				{
				this.setValue("");
				this.setValue(Weborobot.Util.generatePassword(7));
				}
			}
		}
	}
);