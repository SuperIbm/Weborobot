Ext.define('Infoblock.view.InfoblockGrid', 
	{
	extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Infoblock.view.InfoblockGrid',
	
		requires:
		[
		"Infoblock.view.field.InfoblockLabelInfoblockText"
		],
	
	name: "Infoblock",
	store: 'Infoblock',
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'Infoblock',
			dock: 'bottom',
			displayInfo: true
			}
		],

		initComponent: function()
		{
			this.columns =
			[
				{
				header: this.columns[0].header,
				dataIndex: 'idInfoblock',
				width: "5%",
				filter: 'number'
				},
				{
				header: this.columns[1].header,
				dataIndex: 'labelInfoblock',
				width: "82%",
				filter: 'string',
					editor:
					{
					xtype: "Infoblock.view.field.InfoblockLabelInfoblockText",
					hideLabel: true
					}
				},
				{
				header: this.columns[2].header,
				dataIndex: 'status',
				width: "13%",
				filter: 'boolean',
					editor:
					{
					xtype: 'comboBoxStatus',
					hideLabel: true
					}
				}
			];

			this.buttonCreate =
			{
			text: this.buttonCreateText,
			hidden: Admin.getApplication().Access.is("Infoblock", "isCreate") == true ? false : true
			};
			
			this.buttonUpdate = 
			{
			text: this.buttonUpdateText,
			hidden: Admin.getApplication().Access.is("Infoblock", "isUpdate") == true ? false : true
			};
			
			this.buttonDestroy = 
			{
			text: this.buttonDestroyText,
			hidden: Admin.getApplication().Access.is("Infoblock", "isDestroy") == true ? false : true
			};
		
		this.callParent();
		}
	}
);