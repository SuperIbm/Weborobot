Ext.define('Widget.view.WidgetGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Widget.view.WidgetGrid',
	
		requires:
		[
		"Widget.view.field.WidgetIconText",
		"Widget.view.field.WidgetDefComboBox",
		"Widget.view.field.WidgetPathToCssText",
		"Widget.view.field.WidgetPathToJsText"
		],
	
	name: "Widget",
	store: "Widget",
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'Widget',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idWidget',
			width: "5%",
			filter: 'number'
			},
			{
			header: 'Название',
			dataIndex: 'labelWidget',
			width: "40%",
			filter: 'string'
			},
            {
			header: 'Название модуля',
			dataIndex: 'labelModule',
			width: "25%",
			filter: 'string'
            },
			{
			header: 'Иконка',
			dataIndex: 'icon',
			filter: 'string',
			hidden: true,
				editor:
				{
				xtype: "Widget.view.field.WidgetIconText",
				hideLabel: true
				}	
			},
			{
			header: 'Путь к JavaScript',
			dataIndex: 'pathToJs',
			filter: 'string',
			hidden: true,
				editor:
				{
				xtype: "Widget.view.field.WidgetPathToJsText",
				hideLabel: true
				}	
			},
			{
			header: 'Путь к CSS',
			dataIndex: 'pathToCss',
			filter: 'string',
			hidden: true,
				editor:
				{
				xtype: "Widget.view.field.WidgetPathToCssText",
				hideLabel: true
				}	
			},
			{
			header: 'По умолчанию',
			dataIndex: 'def',
			width: "15%",
			filter: 'string',
				editor:
				{
				xtype: "Widget.view.field.WidgetDefComboBox",
				hideLabel: true
				}	
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
			hidden: !Admin.getApplication().Access.is("Widget", "isCreate")
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("Widget", "isUpdate")
			};
		
		this.callParent();
		}
	}
);