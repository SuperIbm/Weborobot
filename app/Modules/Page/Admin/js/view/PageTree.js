Ext.define('Page.view.PageTree', 
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.Page.view.PageTree',
	
		requires:
		[
		"Page.view.field.PageShowInMenuComboBox",
		"Page.view.field.PageModeAccessComboBox",
		"Page.view.field.PageNamePageText",
		"Page.view.field.PageNameLinkText",
		"Page.view.field.PageTitleText",
		"Page.view.field.PageKeywordsText",
		"Page.view.field.PageDescriptionText",
		"Page.view.field.PageRedirectText"
		],
	
	name: "Page",
	store: "Page",
	canDeleteFirstNode: false,
	
		viewConfig:
		{
			plugins:
			{
			ptype: 'treeviewdragdrop',
			ddGroup: "Page.view.PageTree",
			}
		},
	
		dragAble:
		{				
		module: "Page",
		bundle: "PageTreeArray",
		action: "setWeight",
		nameTable: "page",
		fieldKey: "idPage"
		},
	
	filter: true,
	
		columns:
		[
			{
			text: 'ID',
			width: 7,
			sortable: false,
			dataIndex: 'idPage'
			},
			{
			xtype: 'treecolumn',
			text: 'Название',
			width: 26,
			sortable: false,
			dataIndex: 'namePage',
				editor: 
				{
				xtype: "Page.view.field.PageNamePageText",
				hideLabel: true	
				}
			},
			{
			text: 'Ссылка',
			sortable: false,
			dataIndex: 'nameLink',
			hidden: true,
				editor: 
				{
				xtype: "Page.view.field.PageNameLinkText",
				hideLabel: true	
				}
			},
			{
			text: 'Путь',
			width: 15,
			sortable: false,
			dataIndex: 'path'
			},
			{
			text: 'Редактируемость',
			width: 13,
			sortable: false,
			dataIndex: 'isMeetsEdit',
				renderer: function(val)
				{
					if(val == -1 || val == 1) return "Возможно"
					else if(val == 0) return "Невозможно"
				}
			},
			{
			text: 'Показывать в меню',
			width: 13,
			sortable: false,
			dataIndex: 'showInMenu',
				editor: 
				{
				xtype: "Page.view.field.PageShowInMenuComboBox",
				hideLabel: true	
				}
			},
			{
			text: 'Доступ',
			width: 13,
			sortable: false,
			dataIndex: 'modeAccess',
				editor: 
				{
				xtype: "Page.view.field.PageModeAccessComboBox",
				hideLabel: true	
				}
			},
			{
			text: 'Заголовок',
			sortable: false,
			dataIndex: 'title',
			hidden: true,
				editor: 
				{
				xtype: "Page.view.field.PageTitleText",
				hideLabel: true	
				}
			},
			{
			text: 'Ключевые слова',
			sortable: false,
			dataIndex: 'keywords',
			hidden: true,
				editor: 
				{
				xtype: "Page.view.field.PageKeywordsText",
				hideLabel: true	
				}
			},
			{
			text: 'Описание страницы',
			sortable: false,
			dataIndex: 'description',
			hidden: true,
				editor: 
				{
				xtype: "Page.view.field.PageDescriptionText",
				hideLabel: true	
				}
			},
			{
			text: 'URL переадресации',
			dataIndex: 'redirect',
			hidden: true,
				editor: 
				{
				xtype: "Page.view.field.PageRedirectText",
				hideLabel: true	
				}
			},
			{
			text: 'Дата изменения',
			sortable: false,
			dataIndex: 'dateEdit',
			hidden: true
			},
			{
			text: 'Статус',
			width: 13,
			sortable: false,
			dataIndex: 'status',
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
			hidden: Admin.getApplication().Access.is("Page", "isCreate") == true ? false : true
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: Admin.getApplication().Access.is("Page", "isUpdate") == true ? false : true
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: Admin.getApplication().Access.is("Page", "isDestroy") == true ? false : true
			};
		
		this.callParent();
		var thisObj = this;
			
			this.getView().on("nodedragover",
				function(targetNode, position, dragData, e, eOpts)
				{
					if(targetNode.get("isMeetsEdit") == 0) return false;
					
					for(var i = 0; i < dragData.records.length; i++)
					{
						if(dragData.records[i].get("isMeetsEdit") == 0) return false;
					}
				
				return true;
				}
			);
		}
	}
);