Ext.define('Infoblock.view.InfoblockUpdateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Infoblock.view.InfoblockUpdateTab',
	
		requires:
		[
		"Infoblock.view.InfoblockUpdateForm", 
		"Infoblock.view.InfoblockUpdateContentCKEditor"
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
						xtype: "Infoblock.view.InfoblockUpdateForm"
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
						xtype: "Infoblock.view.InfoblockUpdateContentCKEditor"
						}
					]
				}
			];

		this.callParent();
		}
	}
);