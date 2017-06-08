Ext.define('ModuleTemplate.view.ModuleTemplateGrid',
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.ModuleTemplate.view.ModuleTemplateGrid',
	
		requires:
		[
		"ModuleTemplate.view.field.ModuleTemplateLabelTemplateText"
		],
	
	name: "ModuleTree",
	store: 'ModuleTemplate',
	
	region: 'center',
	split: true,	
	forceFit: true,
	
	title: "Шаблоны",
	margin: '5 5 5 0',
	
		viewConfig:
		{
			plugins:
			{
			ptype: 'gridviewdragdrop',
			ddGroup: "ModuleTemplate.view.ModuleTemplateGrid",
			enableDrop: false
			}
		},
		
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'ModuleTemplate',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idModuleTemplate',
			width: "10%",
			filter: 'number'
			},
			{
			header: 'Название шаблона',
			dataIndex: 'labelTemplate',
			width: "40%",
			filter: 'string',
				editor: 
				{
				xtype: "ModuleTemplate.view.field.ModuleTemplateLabelTemplateText",
				hideLabel: true		
				}
			},
			{
			header: 'Название модуля',
			dataIndex: 'labelModule',
			width: "30%",
			filter: 'string'
			},
			{
			header: 'Статус',
			dataIndex: 'status',
			width: "20%",
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
			disabled: true,
			hidden: !Admin.getApplication().Access.is("ModuleTemplate", "isCreate")
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("ModuleTemplate", "isUpdate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("ModuleTemplate", "isDestroy")
			};
			
		this.callParent();
		var thisObj = this;
		
			if(this.getStore().isLoaded())
			{
				this.getStore().on("load",
					function()
					{
					var tree = this.up("panel").down("treepanel");
					var idModule = this.getStore().getProxy().getExtraParams()["idModule"];
					
						if(idModule)
						{
						var record = tree.getStore().getById(idModule);
						tree.getSelectionModel().select(record, null, true);
						
							if(record.getId() != 0)
							{
							this.getButtonCreate().setDisabled(false);	
							this.getMenuItemCreate().setDisabled(false);
							}
						
						this.setTitle("Шаблоны: " + record.getData().text);
						}
						else tree.getSelectionModel().select(tree.getStore().getRoot());
					},
					this,
					{
					single: true	
					}
				);
			}
		}
	}
);