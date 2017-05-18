Ext.define('Infoblock.view.InfoblockCreateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Infoblock.view.InfoblockCreateTab',
	
		requires:
		[
		"Infoblock.view.InfoblockCreateForm", 
		"Infoblock.view.InfoblockCreateContentCKEditor"
		],
	
	name: "Infoblock",
	padding: 5,
	
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: false,
	forceLayout: true,

		initComponent: function()
		{
			this.items =
			[
				{
				title: this.items[0].title,
				layout: "fit",
				itemId: "tab_1",
				items:
					[
						{
						xtype: "Infoblock.view.InfoblockCreateForm"
						}
					]
				},
				{
				title: this.items[1].title,
				layout: "fit",
				itemId: "tab_2",
				items:
					[
						{
						xtype: "Infoblock.view.InfoblockCreateContentCKEditor"
						}
					]
				}
			];

		this.callParent();
		}
	}
);