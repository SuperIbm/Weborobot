Ext.define('User.view.UserRoleGrid', 
	{
	extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.User.view.UserRoleGrid',
	
		requires:
		[
		"User.view.field.UserRoleNameRoleText"
		],
	
	name: "User",
	store: "UserRole",
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'UserRole',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idUserRole',
			filter: 'number',
			width: "5%"
			},
			{
			header: 'Название роли',
			dataIndex: 'nameRole',
			filter: 'string',
			width: "80%",
				editor: 
				{
				xtype: "User.view.field.UserRoleNameRoleText",
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
				xtype: "comboBoxStatus",
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