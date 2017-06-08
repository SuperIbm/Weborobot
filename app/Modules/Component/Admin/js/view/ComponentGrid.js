Ext.define('ModuleTemplate.view.ModuleTemplateGrid',
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.ModuleTemplate.view.ModuleTemplateGrid',
	
		requires:
		[
        "ModuleTemplate.view.field.ModuleTemplatePathToJsText",
        "ModuleTemplate.view.field.ModuleTemplatePathToCssText"
		],
	
	name: "ModuleTree",
	store: 'ModuleTemplate',
	
	region: 'center',
	split: true,	
	forceFit: true,
	
	title: "Компоненты",
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
			width: "8%",
			filter: 'number'
            },
            {
			header: 'Название',
			dataIndex: 'labelComponent',
			width: "38%",
			filter: 'string'
            },
            {
			header: 'Название модуля',
			dataIndex: 'labelModule',
			width: "38%",
			filter: 'string'
            },
            {
            header: 'Название контроллера',
            dataIndex: 'controller',
            filter: 'string',
            hidden: true
            },
            {
            header: 'Путь к JavaScript',
            dataIndex: 'pathToJs',
            filter: 'string',
            hidden: true,
                editor:
                {
                xtype: "Component.view.field.ComponentPathToJsText",
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
                xtype: "Component.view.field.ComponentPathToCssText",
                hideLabel: true
                }
            },
            {
            header: 'Статус',
            dataIndex: 'status',
            width: "16%",
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
						
							if(record.getId() != -1)
							{
							this.getButtonCreate().setDisabled(false);	
							this.getMenuItemCreate().setDisabled(false);
							}
						
						this.setTitle("Компоненты: " + record.getData().text);
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