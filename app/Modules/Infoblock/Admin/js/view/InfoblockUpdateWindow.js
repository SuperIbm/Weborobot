Ext.define('Infoblock.view.InfoblockUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Infoblock.view.InfoblockUpdateWindow',
		
		requires:
		[
		"Infoblock.view.InfoblockUpdateTab"
		],
	
	name: "Infoblock",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	width: 900,
	height: 540,
	modal: true,
		
		items:
		[
			{
			xtype: "Infoblock.view.InfoblockUpdateTab"
			}
		],
		initComponent: function()
		{
			this.fbar =
			[
				{
				text: this.fbar[0].text,
				xtype: "button",
				action: "send"
				},
				{
				text: this.fbar[1].text,
				xtype: "button",
				action: "reset"
				},
				{
				text: this.fbar[2].text,
				xtype: "button",
				action: "cancel"
				}
			];

		this.callParent();
		}
	}
);