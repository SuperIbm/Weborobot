Ext.define('User.view.UserGroupCreatePageTree', 
	{
    extend: 'Page.view.PageTree',
	alias: 'widget.User.view.UserGroupCreatePageTree',
	
		requires:
		[
		'Page.view.PageTree'
		],
	
	border: true,	
	store: "PageSelect",
	selType: "rowmodel",
	
		columns: 
		[
			{
			text: 'ID',
			width: 5,
			sortable: false,
			dataIndex: 'idPage'
			},
			{
			xtype: 'treecolumn',
			text: 'Название',
			width: 30,
			sortable: false,
			dataIndex: 'text',
				renderer: function(val, x, rec)
				{
				input = "";
				
					if(rec.get("isChecked") === true)
					{
					input = "<input type='checkbox' name='pages' value='" + rec.get("idPage") +  "' checked='checked' />";
					}
					else  if(rec.get("isChecked") === false)
					{
					input = "<input type='checkbox' name='pages' value='" + rec.get("idPage") +  "' />";
					}
					
				return input + val;
				}
			},
			{
			text: 'Ссылка',
			width: 13,
			sortable: false,
			dataIndex: 'nameLink',
				editor: 
				{
				xtype: "Page.view.field.PageNameLinkText",
				hideLabel: true	
				}
			},
			{
			text: 'Путь',
			width: 13,
			sortable: false,
			dataIndex: 'path'
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
			text: 'Доступ к странице',
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
			width: 13,
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
			width: 13,
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
			width: 13,
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
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить дерево',
			itemId: 'refresh'
			},
			{
			type: 'expand',
			tooltip: 'Развернуть',
			itemId: 'expand'
			},
			{
			type: 'collapse',
			tooltip: 'Свернуть',
			itemId: 'collapse'
			}
		],
		getCheckedSelection: function()
		{
		var ids = new Array();
		
			$("#" + this.id + " INPUT[type='checkbox']:checked").each
			(
				function()
				{
				ids[ids.length] = $(this).val();	
				}
			);
		
		return ids;
		},
		_setChecked: function(ids)
		{
			$("#" + this.id + " INPUT[type='checkbox']").each
			(
				function()
				{
					for(var i = 0; i < ids.length; i++)
					{					
						if(ids[i] == $(this).val())
						{
						$(this).attr("checked", "checked");
						$(this).get(0).checked = true;
						break;	
						}
					}
				}
			);
		},
		setCheckedSelection: function(ids)
		{
		this._checed = ids;
		this._setChecked(this._checed);
		},
		listeners:
		{
			afterlayout: function()
			{			
				if(this._checed) this._setChecked(this._checed);
			}
		}
	}
);