Ext.define('Alias.view.AliasGrid', 
	{
	extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Alias.view.AliasGrid',
	
		requires:
		[
		"Alias.view.field.AliasPatternText"
		],
	
	name: "Alias",
	store: 'Alias',
	multiColumnSort: true,
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'Alias',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idAlias',
			width: "7%",
			filter: 'number'
			},
			{
			header: 'Паттерн',
			dataIndex: 'pattern',
			width: "28%",
			filter: 'string',
				editor:
				{
				xtype: "Alias.view.field.AliasPatternText",
				hideLabel: true	
				}
			},
			{
			header: 'Страница',
			dataIndex: 'namePage',
			width: "25%",
			sortable: false
			},
			{
			header: 'URL',
			dataIndex: 'path',
			width: "25%",
			sortable: false
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
			hidden: !Admin.getApplication().Access.is("Alias", "isCreate")
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("Alias", "isUpdate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("Alias", "isDestroy")
			};
			
		this.callParent();
		}
	}
);