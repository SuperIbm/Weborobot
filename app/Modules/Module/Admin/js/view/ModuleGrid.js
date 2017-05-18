Ext.define('Module.view.ModuleGrid',
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Module.view.ModuleGrid',
	
	name: "Module",
	store: "Module",
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'Module',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idModule',
			width: "5%",
			filter: 'number'
			},
			{
			header: 'Название компонента',
			dataIndex: 'labelModule',
			width: "80%",
			filter: 'string'
			},
			{
			header: 'Статус',
			dataIndex: 'status',
			width: "15%",
			filter: 'boolean',
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
			hidden: Admin.getApplication().Access.is("Module", "isCreate") == true ? false : true
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: Admin.getApplication().Access.is("Module", "isUpdate") == true ? false : true
			};
		
		this.callParent();
		}
	}
);