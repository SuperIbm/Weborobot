Ext.define('Infoblock.view.InfoblockCreateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.Infoblock.view.InfoblockCreateWindow',
		
		requires:
		[
		"Infoblock.view.InfoblockCreateTab"
		],
	
	name: "Infoblock",
	iconCls: "icon_create",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	width: 900,
	height: 540,
	modal: true,
		
		items:
		[
			{
			xtype: "Infoblock.view.InfoblockCreateTab"
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