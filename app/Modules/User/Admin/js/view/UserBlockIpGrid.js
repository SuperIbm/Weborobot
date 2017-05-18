Ext.define('User.view.UserBlockIpGrid', 
	{
	extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.User.view.UserBlockIpGrid',
	
		requires:
		[
		"User.view.field.UserBlockIpIpText"
		],
	
	name: "User",
	store: "UserBlockIp",
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'UserBlockIp',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idBlockIp',
			filter: 'number',
			width: "5%"
			},
			{
			header: 'IP',
			dataIndex: 'ip',
			filter: 'string',
			width: "80%",
				editor: 
				{
				xtype: "User.view.field.UserBlockIpIpText",
				hideLabel: true	
				}
			},
			{
			header: 'Статус',
			dataIndex: 'status',
			filter: 'boolean',
			width: "15%",
				editor:
				{
				xtype: 'comboBoxStatus',
				hideLabel: true
				}
			}
		],
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Добавить",
			hidden: Admin.getApplication().Access.is("User", "isCreate") == true ? false : true
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: Admin.getApplication().Access.is("User", "isUpdate") == true ? false : true
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: Admin.getApplication().Access.is("User", "isDestroy") == true ? false : true
			}
		
		this.callParent();
		}
	}
);