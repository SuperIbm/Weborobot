Ext.define('PageTemplate.view.PageTemplateGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.PageTemplate.view.PageTemplateGrid',
	
		requires:
		[
		"PageTemplate.view.field.PageTemplateLabelTemplateText",
		"PageTemplate.view.field.PageTemplateNameTemplateText",
		"PageTemplate.view.field.PageTemplateCountBlocksNumber",
		"PageTemplate.view.field.PageTemplateTemplateFile",
		"PageTemplate.view.field.PageTemplateImageFile"
		],
	
	name: "PageTemplate",
	store: 'PageTemplate',
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'PageTemplate',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idPageTemplate',
			width: 5,
			filter: 'number'
			},
			{
			header: 'Изображение',
			dataIndex: 'idImage',
			xtype: 'imagecolumn',
			width: 25
			},
			{
			header: 'Название шаблона',
			dataIndex: 'labelTemplate',
			width: 18,
			filter: 'string',
				editor:
				{
				xtype: "PageTemplate.view.field.PageTemplateLabelTemplateText",
				hideLabel: true		
				}
			},
			{
			header: 'Папка шаблона',
			dataIndex: 'nameTemplate',
			width: 18,
			filter: 'string',
				editor:
				{
				xtype: "PageTemplate.view.field.PageTemplateNameTemplateText",
				hideLabel: true		
				}
			},
			{
			header: 'Количество блоков',
			dataIndex: 'countBlocks',
			width: 19,
			filter: 'number',
				editor:
				{
				xtype: "PageTemplate.view.field.PageTemplateCountBlocksNumber",
				hideLabel: true		
				}
			},
			{
			header: 'Статус',
			dataIndex: 'status',
			width: 15,
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
			hidden: Admin.getApplication().Access.is("PageTemplate", "isCreate") == true ? false : true
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: Admin.getApplication().Access.is("PageTemplate", "isUpdate") == true ? false : true
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: Admin.getApplication().Access.is("PageTemplate", "isDestroy") == true ? false : true
			};
		
		this.callParent();
		}
	}
);