Ext.define('Admin.view.EnterForm', 
	{
    extend: 'Ext.form.FormPanel',
	alias: 'widget.Admin.view.EnterForm',
	
	padding: 5,
	
	bodyBorder: false,
	border: false,
	frame: false,

		initComponent: function()
		{
		var items = this.items;

			this.items =
			[
				{
				xtype: "textfield",
				fieldLabel: this.items[0].fieldLabel + ":<span class='needsForm'>*</span>",
				labelSeparator: "",
				labelWidth: 80,
				name: "login",
				reference: "login",
				width: 360,
				msgTarget: 'side',
					validator: function(value)
					{
						if(Weborobot.Util.isLength(value, 4, 25) == false) return items[0].msgError;
						else return true;
					}
				},
				{
				xtype: "textfield",
				fieldLabel: this.items[1].fieldLabel + ":<span class='needsForm'>*</span>",
				labelSeparator: "",
				labelWidth: 80,
				name: "password",
				reference: "password",
				width: 360,
				msgTarget: 'side',
				inputType: "password",
					validator: function(value)
					{
						if(Weborobot.Util.isLength(value, 6, 25) == false) return items[1].msgError;
						else return true;
					}
				},
				{
				xtype: "checkbox",
				fieldLabel: this.items[2].fieldLabel + ":",
				labelWidth: 80,
				name: "remember",
				reference: "remember"
				}
			];

		this.callParent();
		}
	}
);